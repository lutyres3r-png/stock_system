<?php

/**
 * Controlador de Autenticacion
 * STOCK SYSTEM
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        global $conn;
        $this->db = $conn;
        $this->user = new User($this->db);
    }

    /**
     * Procesar registro
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $dni = trim($_POST['dni'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');
            $apellido = trim($_POST['apellido'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');
            $curso_division = trim($_POST['curso_division'] ?? '');
            $materia = trim($_POST['materia'] ?? '');

            // Validaciones
            $errors = $this->validateRegister($dni, $nombre, $apellido, $email, $password, $confirm_password);

            if (!empty($errors)) {
                return array('success' => false, 'errors' => $errors);
            }

            // Verificar que email y DNI no existan
            $this->user->email = $email;
            if ($this->user->emailExists()) {
                return array('success' => false, 'errors' => array('email' => 'El correo ya esta registrado'));
            }

            $this->user->dni = $dni;
            if ($this->user->dniExists()) {
                return array('success' => false, 'errors' => array('dni' => 'El DNI ya esta registrado'));
            }

            // Preparar datos del usuario
            $this->user->dni = $dni;
            $this->user->nombre = $nombre;
            $this->user->apellido = $apellido;
            $this->user->email = $email;
            $this->user->password = $password;
            $this->user->rol = 'alumno';
            $this->user->estado = 'activo';
            $this->user->curso_division = $curso_division;
            $this->user->materia = $materia;

            // Registrar usuario
            $result = $this->user->register();

            if ($result['success']) {
                // Registrar en historial
                $this->logAction(null, 'registro', 'Nuevo usuario registrado (IP: ' . $_SERVER['REMOTE_ADDR'] . ')');
                return array('success' => true, 'message' => 'Registro exitoso. Ahora puedes iniciar sesion.');
            } else {
                return $result;
            }
        }

        return array('success' => false, 'message' => 'Metodo no permitido');
    }

    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Validaciones
            if (empty($email) || empty($password)) {
                return array('success' => false, 'message' => 'Email y contrasena son requeridos');
            }

            // Buscar usuario
            $this->user->email = $email;
            $result = $this->user->findByEmail();

            if ($result->num_rows === 0) {
                return array('success' => false, 'message' => 'Credenciales invalidas');
            }

            $userData = $result->fetch_assoc();

            // Verificar contrasena
            if (!$this->user->verifyPassword($password, $userData['password'])) {
                return array('success' => false, 'message' => 'Credenciales invalidas');
            }

            // Verificar estado
            if ($userData['estado'] !== 'activo') {
                return array('success' => false, 'message' => 'Usuario inactivo. Contacta al administrador.');
            }

            // Crear sesion
            session_start();
            $_SESSION['user_id'] = $userData['id_usuario'];
            $_SESSION['nombre'] = $userData['nombre'];
            $_SESSION['apellido'] = $userData['apellido'];
            $_SESSION['email'] = $userData['email'];
            $_SESSION['rol'] = $userData['rol'];
            $_SESSION['curso_division'] = $userData['curso_division'];

            // Registrar en historial
            $this->logAction($userData['id_usuario'], 'login', 'Usuario ha iniciado sesion (IP: ' . $_SERVER['REMOTE_ADDR'] . ')');

            return array('success' => true, 'message' => 'Inicio de sesion exitoso', 'redirect' => 'dashboard.php');
        }

        return array('success' => false, 'message' => 'Metodo no permitido');
    }

    /**
     * Logout
     */
    public function logout() {
        session_start();
        
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $this->logAction($user_id, 'logout', 'Usuario ha cerrado sesion (IP: ' . $_SERVER['REMOTE_ADDR'] . ')');
        }

        session_destroy();
        return array('success' => true, 'message' => 'Sesion cerrada', 'redirect' => 'login.php');
    }

    /**
     * Validar datos del registro
     */
    private function validateRegister($dni, $nombre, $apellido, $email, $password, $confirm_password) {
        $errors = array();

        // Validar DNI
        if (empty($dni)) {
            $errors['dni'] = 'El DNI es requerido';
        } elseif (!preg_match('/^[0-9]{6,10}$/', $dni)) {
            $errors['dni'] = 'El DNI debe contener entre 6 y 10 digitos';
        }

        // Validar nombre
        if (empty($nombre)) {
            $errors['nombre'] = 'El nombre es requerido';
        } elseif (strlen($nombre) < 3) {
            $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres';
        }

        // Validar apellido
        if (empty($apellido)) {
            $errors['apellido'] = 'El apellido es requerido';
        } elseif (strlen($apellido) < 3) {
            $errors['apellido'] = 'El apellido debe tener al menos 3 caracteres';
        }

        // Validar email
        if (empty($email)) {
            $errors['email'] = 'El email es requerido';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El email no es valido';
        }

        // Validar contrasena
        if (empty($password)) {
            $errors['password'] = 'La contrasena es requerida';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'La contrasena debe tener al menos 6 caracteres';
        }

        // Validar confirmacion de contrasena
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Las contrasenas no coinciden';
        }

        return $errors;
    }

    /**
     * Registrar accion en historial
     */
    private function logAction($user_id, $accion, $descripcion) {
        $query = "INSERT INTO historial (id_usuario, accion, descripcion, fecha_hora)
                  VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iss', $user_id, $accion, $descripcion);
        $stmt->execute();
        $stmt->close();
    }
}

?>
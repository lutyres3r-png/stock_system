<?php

/**
 * Modelo de Usuario
 * STOCK SYSTEM
 */

class User {
    private $conn;
    private $table = 'usuarios';

    // Propiedades del usuario
    public $id_usuario;
    public $dni;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $rol;
    public $estado;
    public $fecha_registro;
    public $curso_division;
    public $materia;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Registrar un nuevo usuario
     */
    public function register() {
        $query = "INSERT INTO " . $this->table . "
                  (dni, nombre, apellido, email, password, rol, estado, curso_division, materia)
                  VALUES
                  (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            return array('success' => false, 'message' => 'Error en la preparacion: ' . $this->conn->error);
        }

        // Hash de contrasena
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        // Vincular parametros - 9 parametros: s s s s s s s s s
        $stmt->bind_param(
            'sssssssss',
            $this->dni,
            $this->nombre,
            $this->apellido,
            $this->email,
            $password_hash,
            $this->rol,
            $this->estado,
            $this->curso_division,
            $this->materia
        );

        // Ejecutar
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            // Crear registro de reputacion inicial
            $this->createInitialReputation($user_id);
            $stmt->close();
            return array('success' => true, 'message' => 'Usuario registrado exitosamente');
        } else {
            $stmt->close();
            return array('success' => false, 'message' => 'Error al registrar: ' . $stmt->error);
        }
    }

    /**
     * Crear reputacion inicial
     */
    private function createInitialReputation($user_id) {
        $query = "INSERT INTO reputacion (id_usuario, puntos_totales, nivel, fecha_actualizacion)
                  VALUES (?, 0, 'bronce', NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Verificar si el email ya existe
     */
    public function emailExists() {
        $query = "SELECT id_usuario FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    /**
     * Verificar si el DNI ya existe
     */
    public function dniExists() {
        $query = "SELECT id_usuario FROM " . $this->table . " WHERE dni = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->dni);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    /**
     * Buscar usuario por email
     */
    public function findByEmail() {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    /**
     * Obtener usuario por ID
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_usuario = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    /**
     * Validar contrasena
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}

?>
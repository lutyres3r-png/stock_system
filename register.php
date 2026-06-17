<?php

/**
 * Pagina de Registro
 * STOCK SYSTEM
 */

require_once 'controllers/AuthController.php';

$auth = new AuthController();
$response = array('success' => false, 'message' => '', 'errors' => array());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = $auth->register();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - STOCK SYSTEM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 700px;
            width: 100%;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h1 {
            color: #667eea;
            font-weight: 700;
            font-size: 28px;
        }
        .register-header p {
            color: #666;
            margin-top: 10px;
        }
        .role-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .role-card {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        .role-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }
        .role-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        .role-card input[type="radio"]:checked + .role-content {
            color: white;
        }
        .role-card input[type="radio"]:checked ~ .role-check {
            display: flex;
        }
        .role-card.alumno input[type="radio"]:checked ~ * {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .role-card.docente input[type="radio"]:checked ~ * {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .role-card.institucion input[type="radio"]:checked ~ * {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .role-card input[type="radio"]:checked {
            opacity: 1;
        }
        .role-card {
            border: 2px solid #ddd;
        }
        .role-card input[type="radio"]:checked {
            border-color: #667eea;
            border: 2px solid #667eea;
        }
        .role-content {
            font-weight: 600;
            margin-bottom: 8px;
        }
        .role-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .role-description {
            font-size: 12px;
            color: #999;
            margin-top: 8px;
        }
        .role-check {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background: #667eea;
            border-radius: 50%;
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            display: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
            transition: transform 0.2s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            color: white;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        .alert {
            border-radius: 5px;
            border: none;
            margin-bottom: 20px;
        }
        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }
        .form-control.is-invalid {
            border-color: #e74c3c;
        }
        .role-card.selected {
            border: 2px solid #667eea;
            background-color: #f0f4ff;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>📋 STOCK SYSTEM</h1>
            <p>Crear una nueva cuenta</p>
        </div>

        <?php if ($response['success']): ?>
            <div class="alert alert-success" role="alert">
                ✓ <?php echo $response['message']; ?>
                <p style="margin-top: 10px;">Redirigiendo a login...</p>
            </div>
            <script>
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            </script>
        <?php endif; ?>

        <form method="POST" action="register.php" id="registerForm">
            <!-- Seleccionar Rol -->
            <div class="form-group">
                <label class="form-label">👤 Selecciona tu Rol en el Sistema</label>
                <div class="role-selector">
                    <!-- Alumno -->
                    <label class="role-card alumno">
                        <input type="radio" name="rol" value="alumno" required <?php echo ($_POST['rol'] ?? '') === 'alumno' ? 'checked' : ''; ?>>
                        <div class="role-check">✓</div>
                        <div class="role-content">
                            <div class="role-icon">👨‍🎓</div>
                            <strong>Alumno</strong>
                            <div class="role-description">Acceso a préstamos, proyectos y reservas</div>
                        </div>
                    </label>

                    <!-- Docente -->
                    <label class="role-card docente">
                        <input type="radio" name="rol" value="docente" <?php echo ($_POST['rol'] ?? '') === 'docente' ? 'checked' : ''; ?>>
                        <div class="role-check">✓</div>
                        <div class="role-content">
                            <div class="role-icon">👨‍🏫</div>
                            <strong>Docente</strong>
                            <div class="role-description">Gestión de proyectos y aprobaciones</div>
                        </div>
                    </label>

                    <!-- Institución -->
                    <label class="role-card institucion">
                        <input type="radio" name="rol" value="institucion" <?php echo ($_POST['rol'] ?? '') === 'institucion' ? 'checked' : ''; ?>>
                        <div class="role-check">✓</div>
                        <div class="role-content">
                            <div class="role-icon">🏢</div>
                            <strong>Institución</strong>
                            <div class="role-description">Control total del inventario</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Datos Personales -->
            <div class="form-row">
                <div class="form-group">
                    <label for="dni" class="form-label">DNI</label>
                    <input type="text" class="form-control <?php echo isset($response['errors']['dni']) ? 'is-invalid' : ''; ?>" 
                           id="dni" name="dni" placeholder="12345678" value="<?php echo $_POST['dni'] ?? ''; ?>" required>
                    <?php if (isset($response['errors']['dni'])): ?>
                        <span class="error-message"><?php echo $response['errors']['dni']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control <?php echo isset($response['errors']['email']) ? 'is-invalid' : ''; ?>" 
                           id="email" name="email" placeholder="correo@ejemplo.com" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                    <?php if (isset($response['errors']['email'])): ?>
                        <span class="error-message"><?php echo $response['errors']['email']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Nombre y Apellido -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control <?php echo isset($response['errors']['nombre']) ? 'is-invalid' : ''; ?>" 
                           id="nombre" name="nombre" placeholder="Juan" value="<?php echo $_POST['nombre'] ?? ''; ?>" required>
                    <?php if (isset($response['errors']['nombre'])): ?>
                        <span class="error-message"><?php echo $response['errors']['nombre']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control <?php echo isset($response['errors']['apellido']) ? 'is-invalid' : ''; ?>" 
                           id="apellido" name="apellido" placeholder="Pérez" value="<?php echo $_POST['apellido'] ?? ''; ?>" required>
                    <?php if (isset($response['errors']['apellido'])): ?>
                        <span class="error-message"><?php echo $response['errors']['apellido']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Curso y Materia (Solo para Alumnos y Docentes) -->
            <div id="academic-section" class="form-row">
                <div class="form-group">
                    <label for="curso_division" class="form-label">Curso/División</label>
                    <select class="form-control" id="curso_division" name="curso_division">
                        <option value="">Seleccionar...</option>
                        <option value="1ro 1ra" <?php echo ($_POST['curso_division'] ?? '') === '1ro 1ra' ? 'selected' : ''; ?>>1ro 1ra</option>
                        <option value="1ro 2da" <?php echo ($_POST['curso_division'] ?? '') === '1ro 2da' ? 'selected' : ''; ?>>1ro 2da</option>
                        <option value="2do 1ra" <?php echo ($_POST['curso_division'] ?? '') === '2do 1ra' ? 'selected' : ''; ?>>2do 1ra</option>
                        <option value="2do 2da" <?php echo ($_POST['curso_division'] ?? '') === '2do 2da' ? 'selected' : ''; ?>>2do 2da</option>
                        <option value="3ro 1ra" <?php echo ($_POST['curso_division'] ?? '') === '3ro 1ra' ? 'selected' : ''; ?>>3ro 1ra</option>
                        <option value="3ro 2da" <?php echo ($_POST['curso_division'] ?? '') === '3ro 2da' ? 'selected' : ''; ?>>3ro 2da</option>
                        <option value="4to 1ra" <?php echo ($_POST['curso_division'] ?? '') === '4to 1ra' ? 'selected' : ''; ?>>4to 1ra</option>
                        <option value="4to 2da" <?php echo ($_POST['curso_division'] ?? '') === '4to 2da' ? 'selected' : ''; ?>>4to 2da</option>
                        <option value="5to 1ra" <?php echo ($_POST['curso_division'] ?? '') === '5to 1ra' ? 'selected' : ''; ?>>5to 1ra</option>
                        <option value="5to 2da" <?php echo ($_POST['curso_division'] ?? '') === '5to 2da' ? 'selected' : ''; ?>>5to 2da</option>
                        <option value="6to 1ra" <?php echo ($_POST['curso_division'] ?? '') === '6to 1ra' ? 'selected' : ''; ?>>6to 1ra</option>
                        <option value="6to 2da" <?php echo ($_POST['curso_division'] ?? '') === '6to 2da' ? 'selected' : ''; ?>>6to 2da</option>
                        <option value="7mo 1ra" <?php echo ($_POST['curso_division'] ?? '') === '7mo 1ra' ? 'selected' : ''; ?>>7mo 1ra</option>
                        <option value="7mo 2da" <?php echo ($_POST['curso_division'] ?? '') === '7mo 2da' ? 'selected' : ''; ?>>7mo 2da</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="materia" class="form-label">Materia (Opcional)</label>
                    <input type="text" class="form-control" id="materia" name="materia" 
                           placeholder="ej: Electrónica" value="<?php echo $_POST['materia'] ?? ''; ?>">
                </div>
            </div>

            <!-- Contraseña -->
            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control <?php echo isset($response['errors']['password']) ? 'is-invalid' : ''; ?>" 
                           id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                    <?php if (isset($response['errors']['password'])): ?>
                        <span class="error-message"><?php echo $response['errors']['password']; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control <?php echo isset($response['errors']['confirm_password']) ? 'is-invalid' : ''; ?>" 
                           id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required>
                    <?php if (isset($response['errors']['confirm_password'])): ?>
                        <span class="error-message"><?php echo $response['errors']['confirm_password']; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn-register">Registrarse</button>
        </form>

        <div class="login-link">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar campos académicos según el rol
        const roleInputs = document.querySelectorAll('input[name="rol"]');
        const academicSection = document.getElementById('academic-section');
        
        function toggleAcademicFields() {
            const selectedRole = document.querySelector('input[name="rol"]:checked')?.value;
            if (selectedRole === 'institucion') {
                academicSection.style.display = 'none';
            } else {
                academicSection.style.display = 'grid';
            }
        }
        
        roleInputs.forEach(input => {
            input.addEventListener('change', toggleAcademicFields);
        });
        
        // Ejecutar al cargar la página
        toggleAcademicFields();

        // Validación del formulario
        const registerForm = document.getElementById('registerForm');
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>
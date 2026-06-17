<?php

/**
 * Dashboard Principal
 * STOCK SYSTEM
 */

session_start();

// Verificar si el usuario esta logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/database.php';

// Obtener información del usuario
$user_id = $_SESSION['user_id'];
$query = "SELECT u.*, r.puntos_totales, r.nivel FROM usuarios u 
          LEFT JOIN reputacion r ON u.id_usuario = r.id_usuario 
          WHERE u.id_usuario = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - STOCK SYSTEM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: white !important;
        }
        .sidebar {
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 56px;
            width: 250px;
            overflow-y: auto;
        }
        .sidebar a {
            display: block;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #f0f0f0;
            color: #667eea;
        }
        .sidebar a.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            padding: 30px;
        }
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .welcome-card h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }
        .badge-role {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            margin: 10px 0;
        }
        .badge-alumno {
            background-color: rgba(255, 255, 255, 0.3);
        }
        .badge-docente {
            background-color: rgba(255, 255, 255, 0.3);
        }
        .badge-institucion {
            background-color: rgba(255, 255, 255, 0.3);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-warehouse"></i> STOCK SYSTEM
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Hola, <?php echo $_SESSION['nombre']; ?>!</span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php" class="active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        
        <?php if ($_SESSION['rol'] !== 'institucion'): ?>
            <a href="#">
                <i class="fas fa-microchip"></i> Componentes
            </a>
            <a href="#">
                <i class="fas fa-hammer"></i> Herramientas
            </a>
            <a href="#">
                <i class="fas fa-exchange-alt"></i> Préstamos
            </a>
            <a href="#">
                <i class="fas fa-calendar"></i> Reservas
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'alumno'): ?>
            <a href="#">
                <i class="fas fa-project-diagram"></i> Mis Proyectos
            </a>
            <a href="#">
                <i class="fas fa-robot"></i> Bot IA
            </a>
        <?php elseif ($_SESSION['rol'] === 'docente'): ?>
            <a href="#">
                <i class="fas fa-project-diagram"></i> Proyectos
            </a>
            <a href="#">
                <i class="fas fa-check-circle"></i> Aprobaciones
            </a>
        <?php elseif ($_SESSION['rol'] === 'institucion'): ?>
            <a href="#">
                <i class="fas fa-microchip"></i> Componentes
            </a>
            <a href="#">
                <i class="fas fa-hammer"></i> Herramientas
            </a>
            <a href="#">
                <i class="fas fa-users"></i> Usuarios
            </a>
            <a href="#">
                <i class="fas fa-chart-bar"></i> Reportes
            </a>
        <?php endif; ?>
        
        <a href="#">
            <i class="fas fa-bell"></i> Alertas
        </a>
        <hr>
        <a href="#">
            <i class="fas fa-user"></i> Mi Perfil
        </a>
        <a href="#">
            <i class="fas fa-cog"></i> Configuración
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-card">
            <h2>¡Bienvenido, <?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>!</h2>
            <span class="badge-role badge-<?php echo $_SESSION['rol']; ?>">
                <?php 
                    $roles = array(
                        'alumno' => '👨‍🎓 ALUMNO',
                        'docente' => '👨‍🏫 DOCENTE',
                        'institucion' => '🏢 INSTITUCIÓN'
                    );
                    echo $roles[$_SESSION['rol']] ?? strtoupper($_SESSION['rol']);
                ?>
            </span>
            <p style="margin: 15px 0 5px 0;">Rol: <strong><?php echo strtoupper($_SESSION['rol']); ?></strong></p>
            <?php if ($_SESSION['rol'] !== 'institucion'): ?>
                <p style="margin: 5px 0;">Curso: <strong><?php echo $_SESSION['curso_division']; ?></strong></p>
            <?php endif; ?>
            <p style="margin-bottom: 0;">Fecha de acceso: <strong><?php echo date('d/m/Y H:i:s'); ?></strong></p>
        </div>

        <?php if ($_SESSION['rol'] === 'alumno'): ?>
            <!-- DASHBOARD ALUMNO -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-microchip fa-2x mb-3" style="color: #667eea;"></i>
                            <h5>Componentes</h5>
                            <p class="card-text">Disponibles: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-exchange-alt fa-2x mb-3" style="color: #764ba2;"></i>
                            <h5>Mis Préstamos</h5>
                            <p class="card-text">Activos: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar fa-2x mb-3" style="color: #667eea;"></i>
                            <h5>Mis Reservas</h5>
                            <p class="card-text">Activas: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-star fa-2x mb-3" style="color: #764ba2;"></i>
                            <h5>Mi Reputación</h5>
                            <p class="card-text">Nivel: <strong><?php echo ucfirst($user_data['nivel'] ?? 'Bronce'); ?></strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($_SESSION['rol'] === 'docente'): ?>
            <!-- DASHBOARD DOCENTE -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-project-diagram fa-2x mb-3" style="color: #667eea;"></i>
                            <h5>Proyectos</h5>
                            <p class="card-text">Activos: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Gestionar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x mb-3" style="color: #764ba2;"></i>
                            <h5>Solicitudes Pendientes</h5>
                            <p class="card-text">Por aprobar: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Revisar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-2x mb-3" style="color: #667eea;"></i>
                            <h5>Alumnos</h5>
                            <p class="card-text">En mis cursos: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Ver</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($_SESSION['rol'] === 'institucion'): ?>
            <!-- DASHBOARD INSTITUCIÓN -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-microchip fa-2x mb-3" style="color: #667eea;"></i>
                            <h5>Componentes</h5>
                            <p class="card-text">Total: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Gestionar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-hammer fa-2x mb-3" style="color: #764ba2;"></i>
                            <h5>Herramientas</h5>
                            <p class="card-text">Total: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Gestionar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-2x mb-3" style="color: #667eea;"></i>
                            <h5>Usuarios</h5>
                            <p class="card-text">Total: <strong>0</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-bar fa-2x mb-3" style="color: #764ba2;"></i>
                            <h5>Reportes</h5>
                            <p class="card-text">Disponibles: <strong>5</strong></p>
                            <a href="#" class="btn btn-sm btn-primary">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// registrar_usuario.php
require 'conexion.php';

// Verificar método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: CreacionCuenta.html");
    exit();
}

// Recoger y sanitizar datos
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Validaciones básicas
$errores = [];

if (empty($nombre) {
    $errores[] = "El nombre es obligatorio";
}

if (empty($apellido)) {
    $errores[] = "El apellido es obligatorio";
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electrónico no es válido";
}

if (strlen($password) < 8) {
    $errores[] = "La contraseña debe tener al menos 8 caracteres";
}

// Si hay errores, mostrarlos
if (!empty($errores)) {
    session_start();
    $_SESSION['errores_registro'] = $errores;
    $_SESSION['datos_anteriores'] = $_POST;
    header("Location: CreacionCuenta.html");
    exit();
}

// Verificar si el correo ya existe
$stmt = $conexion->prepare("SELECT id FROM usuario123 WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $conexion->close();
    session_start();
    $_SESSION['errores_registro'] = ["Este correo electrónico ya está registrado"];
    $_SESSION['datos_anteriores'] = $_POST;
    header("Location: CreacionCuenta.html");
    exit();
}
$stmt->close();

// Hash de la contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insertar nuevo usuario
$stmt = $conexion->prepare("INSERT INTO usuario123 (nombre, apellido, correo, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $apellido, $correo, $password_hash);

if ($stmt->execute()) {
    // Registro exitoso
    $stmt->close();
    $conexion->close();
    
    // Iniciar sesión automáticamente
    session_start();
    $_SESSION['user_id'] = $conexion->insert_id;
    $_SESSION['user_email'] = $correo;
    $_SESSION['user_name'] = $nombre;
    
    header("Location: registro_exitoso.php");
    exit();
} else {
    // Error en el registro
    error_log("Error al registrar usuario: " . $stmt->error);
    $stmt->close();
    $conexion->close();
    
    session_start();
    $_SESSION['errores_registro'] = ["Ocurrió un error al registrar. Por favor intenta nuevamente."];
    header("Location: CreacionCuenta.html");
    exit();
}
?>
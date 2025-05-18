<?php
require 'conexion.php';

// Obtener datos del formulario
$correo = $_POST['username'];
$password = $_POST['password'];
$es_desarrollador = isset($_POST['role-toggle']) ? 1 : 0; // Asumiendo que agregaste este campo a tu DB

// Consulta preparada para seguridad
$stmt = $conexion->prepare("SELECT id, password FROM usuario123 WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    
    // Verificar contraseña hasheada
    if (password_verify($password, $usuario['password'])) {
        // Iniciar sesión
        session_start();
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_email'] = $correo;
        $_SESSION['es_desarrollador'] = $es_desarrollador;
        
        // Redireccionar según rol
        header("Location: " . ($es_desarrollador ? "perfil_diseñador.php" : "perfil_usuario.php"));
        exit();
    }
}

// Si llega aquí, las credenciales son incorrectas
header("Location: InicioSesion.html?error=1");
exit();
?>
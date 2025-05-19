<?php
session_start(); // Siempre al inicio del script
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']);
    $password = $_POST['password'];

    // Validación básica
    if (empty($correo) || empty($password)) {
        header("Location: InicioSesion.html?error=campos_vacios");
        exit();
    }

    // Consulta preparada para evitar SQL injection
    $consulta = "SELECT id, nombre, apellido, correo, password FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($consulta);
    
    if (!$stmt) {
        die("Error en la consulta: " . $conexion->error);
    }
    
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        
        // Verificar contraseña (asumiendo que está hasheada)
        if (password_verify($password, $usuario['password'])) {
            // Iniciar sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];
            $_SESSION['correo'] = $usuario['correo'];
            
            header("Location: perfil_usuario.html");
            exit();
        }
    }

    // Credenciales incorrectas
    header("Location: InicioSesion.html?error=credenciales_incorrectas");
    exit();
} else {
    // Si no es POST, redirigir
    header("Location: InicioSesion.html");
    exit();
}
?>
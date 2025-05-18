<?php
include("conexion.php"); // Incluye solo la conexión

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepara los datos
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $apellido = $conexion->real_escape_string($_POST['apellido']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encripta la contraseña

    // Prepara la consulta SQL con sentencias preparadas (más seguro)
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, correo, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $apellido, $correo, $password);

    // Ejecuta y verifica
    if ($stmt->execute()) {
        echo "Registro exitoso";
        // Redirecciona si es necesario
        // header("Location: exito.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
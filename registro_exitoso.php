<?php
// registro_exitoso.php
session_start();

// Verificar que el usuario venga del proceso de registro
if (!isset($_SESSION['user_id'])) {
    header("Location: CreacionCuenta.html");
    exit();
}

// Mostrar mensaje de éxito
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso - Viralize</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="header-container"></div>

    <div class="success-container">
        <div class="success-icon">✓</div>
        <h2>¡Registro Exitoso!</h2>
        <p>Bienvenido/a <?php echo htmlspecialchars($_SESSION['user_name']); ?>, tu cuenta ha sido creada correctamente.</p>
        <p>Ahora puedes iniciar sesión y comenzar a usar nuestros servicios.</p>
        <a href="InicioSesion.html" class="btn">Iniciar Sesión</a>
    </div>

    <script>
        // Cargar header
        fetch("Header1.html")
            .then(response => response.text())
            .then(data => {
                document.getElementById("header-container").innerHTML = data;
            })
            .catch(error => console.error("Error al cargar el header:", error));
    </script>
</body>
</html>
<?php
// Limpiar datos temporales
unset($_SESSION['errores_registro']);
unset($_SESSION['datos_anteriores']);
?>
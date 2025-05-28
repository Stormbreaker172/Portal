<?php
// Obtener datos del formulario
$nombre = isset($_POST['auth_user']) ? trim($_POST['auth_user']) : '';
$correo = isset($_POST['auth_email']) ? trim($_POST['auth_email']) : '';
$genero = isset($_POST['genero']) ? trim($_POST['genero']) : '';
$edad = isset($_POST['edad']) ? trim($_POST['edad']) : '';
$motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : '';
$mac = isset($_POST['mac']) ? trim($_POST['mac']) : 'N/A';
$redir_url = isset($_POST['redirurl']) ? $_POST['redirurl'] : 'https://www.google.com';

// Obtener la IP del usuario
$ip_usuario = $_SERVER['HTTP_CLIENT_IP'] ??
    $_SERVER['HTTP_X_FORWARDED_FOR'] ??
    $_SERVER['REMOTE_ADDR'];

// Validar campos obligatorios
if (empty($nombre) || empty($correo) || empty($genero) || empty($edad) || empty($motivo)) {
    mostrarError("Por favor completa todos los campos.");
}

// Validar longitud del nombre
if (strlen($nombre) < 3 || strlen($nombre) > 50) {
    mostrarError("El nombre debe tener entre 3 y 50 caracteres.");
}

// Guardar en archivo CSV
$registro = date("Y-m-d H:i:s") . ",$nombre,$correo,$genero,$edad,$motivo,$ip_usuario,$mac\n";
file_put_contents("usuarios_wifi.csv", $registro, FILE_APPEND);

// Redirigir al sitio deseado
header("Location: http://www.tiendasneto.com");
exit;

// Función para mostrar errores en formato HTML
function mostrarError($mensaje) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Error de validación</title>
        <meta http-equiv='refresh' content='5; url=index.html'>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #ffa420;
                text-align: center;
                padding: 50px;
            }
            .mensaje-error {
                background: white;
                color: red;
                padding: 20px;
                border-radius: 8px;
                max-width: 400px;
                margin: auto;
                box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            }
        </style>
    </head>
    <body>
        <div class='mensaje-error'>
            <h2>Error</h2>
            <p>$mensaje</p>
            <p>Serás redirigido en unos segundos...</p>
        </div>
    </body>
    </html>";
    exit;
}
?>
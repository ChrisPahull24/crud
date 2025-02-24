<?php
include 'db.php'; // Conectar con la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $tipo_documento = $_POST['tipo_documento'];
    $numero_documento = $_POST['numero_documento'];
    $ciudad = $_POST['ciudad'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Validar que el número de documento no esté duplicado
    $check_sql = "SELECT id FROM clientes WHERE numero_documento = '$numero_documento'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "❌ El número de documento ya está registrado.";
    } else {
        // Insertar cliente en la base de datos
        $sql = "INSERT INTO clientes (nombre, apellido, tipo_documento, numero_documento, ciudad, direccion, telefono, email) 
                VALUES ('$nombre', '$apellido', '$tipo_documento', '$numero_documento', '$ciudad', '$direccion', '$telefono', '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "✅ Cliente registrado con éxito.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

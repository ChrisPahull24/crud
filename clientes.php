<?php
include 'db.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Obtener todos los clientes
    $result = $conn->query("SELECT * FROM clientes");
    $clientes = [];

    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    echo json_encode($clientes);
}

if ($method == 'POST') {
    // Agregar o actualizar cliente
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && $data['id'] != "") {
        // Actualizar cliente
        $stmt = $conn->prepare("UPDATE clientes SET nombre=?, apellido=?, tipo_documento=?, numero_documento=?, ciudad=?, direccion=?, telefono=?, email=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $data['nombre'], $data['apellido'], $data['tipo_documento'], $data['numero_documento'], $data['ciudad'], $data['direccion'], $data['telefono'], $data['email'], $data['id']);
    } else {
        // Agregar nuevo cliente
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellido, tipo_documento, numero_documento, ciudad, direccion, telefono, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $data['nombre'], $data['apellido'], $data['tipo_documento'], $data['numero_documento'], $data['ciudad'], $data['direccion'], $data['telefono'], $data['email']);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
}

if ($method == 'DELETE') {
    // Eliminar cliente
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id=?");
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
}

$conn->close();
?>

<?php
include 'db.php'; // Conectamos con la base de datos

// Consulta para obtener todos los clientes
$result = $conn->query("SELECT * FROM clientes");

// Verificamos si hay resultados
if ($result->num_rows > 0) {
    echo "<h2>Lista de Clientes</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Tipo de Documento</th>
            <th>Número de Documento</th>
            <th>Ciudad</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
         </tr>";

    // Mostramos cada fila de la tabla
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']}</td>
                <td>{$row['apellido']}</td>
                <td>{$row['tipo_documento']}</td>
                <td>{$row['numero_documento']}</td>
                <td>{$row['ciudad']}</td>
                <td>{$row['direccion']}</td>
                <td>{$row['telefono']}</td>
                <td>{$row['email']}</td>
             </tr>";
    }
    echo "</table>";
} else {
    echo "No hay clientes registrados.";
}

// Cerramos la conexión a la base de datos
$conn->close();
?>

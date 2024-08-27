<?php
include 'Conexion_bd.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si es una actualización o un nuevo registro
    if (isset($_POST['id_cliente']) && !empty($_POST['id_cliente'])) {
        // Actualizar un registro existente
        $id_cliente = $_POST['id_cliente'];
        $Nombre = $_POST['Nombre'];
        $Celular = $_POST['numero'];
        $Direccion = $_POST['correo'];

        $sql = "UPDATE tb_clientes SET Nombre=?, Celular=?, Direccion=? WHERE id_cliente=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssi", $Nombre, $Celular, $Direccion, $id_cliente);

        if ($stmt->execute()) {
            header("Location: index.php?status=updated");
            exit;
        } else {
            echo "Error al actualizar el registro: " . $con->error;
        }
    } else {
        // Agregar un nuevo registro
        $Nombre = $_POST['Nombre'];
        $Celular = $_POST['numero'];
        $Direccion = $_POST['correo'];

        $sql = "INSERT INTO tb_clientes (Nombre, Celular, Direccion) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $Nombre, $Celular, $Direccion);

        if ($stmt->execute()) {
            header("Location: index.php?status=added");
            exit;
        } else {
            echo "Error al agregar el registro: " . $con->error;
        }
    }
} elseif (isset($_GET['id_cliente']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    // Eliminar un registro
    $id_cliente = $_GET['id_cliente'];

    $sql = "DELETE FROM tb_clientes WHERE id_cliente=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id_cliente);

    if ($stmt->execute()) {
        header("Location: index.php?status=deleted");
        exit;
    } else {
        echo "Error al eliminar el registro: " . $con->error;
    }
}

// Cerrar la conexión
$con->close();
?>

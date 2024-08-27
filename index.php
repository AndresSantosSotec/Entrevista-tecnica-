<?php
include 'Conexion_bd.php'; // Conexión a la base de datos

// Consulta para obtener los datos de la base de datos
$sql = "SELECT id_cliente, Nombre, Celular, Direccion FROM tb_clientes";
$result = $con->query($sql);

// Verificar si la consulta fue exitosa
if ($result === false) {
    die("Error en la consulta: " . $con->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap 3 CSS desde CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Formulario de Contacto</h3>
                    </div>
                    <div class="card-body">
                        <form action="acciones.php" method="post">
                            <div class="form-group">
                                <label for="Nombre" class="control-label">Nombre</label>
                                <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="numero" class="control-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div>
                            <div class="form-group">
                                <label for="correo" class="control-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabla para mostrar los datos -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="text-center">Datos Almacenados</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Número</th>
                                    <th>Correo</th>
                                    <th>Acciones</th> <!-- Columna para los botones de acciones -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result === false) {
                                    echo "<p>Error en la consulta: " . $con->error . "</p>";
                                } elseif ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['Nombre'] . "</td>";
                                        echo "<td>" . $row['Celular'] . "</td>";
                                        echo "<td>" . $row['Direccion'] . "</td>";
                                        echo "<td>
                                                <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editModal' data-id='" . $row['id_cliente'] . "' data-nombre='" . $row['Nombre'] . "' data-celular='" . $row['Celular'] . "' data-direccion='" . $row['Direccion'] . "'>Editar</button>
                                                <a href='acciones.php?id_cliente=" . $row['id_cliente'] . "&action=delete' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este registro?\");'>Eliminar</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No hay datos almacenados</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar datos -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="editModalLabel">Editar Contacto</h4>
                </div>
                <div class="modal-body">
                    <form action="acciones.php" method="post" id="editForm">
                        <input type="hidden" id="id_cliente" name="id_cliente">
                        <div class="form-group">
                            <label for="editNombre" class="control-label">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="editNumero" class="control-label">Número</label>
                            <input type="text" class="form-control" id="editNumero" name="numero" required>
                        </div>
                        <div class="form-group">
                            <label for="editCorreo" class="control-label">Correo</label>
                            <input type="email" class="form-control" id="editCorreo" name="correo" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery desde CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Bootstrap 3 JS desde CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Script para cargar datos en el modal -->
    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id');
            var nombre = button.data('nombre');
            var celular = button.data('celular');
            var direccion = button.data('direccion');

            var modal = $(this);
            modal.find('.modal-body #id_cliente').val(id);
            modal.find('.modal-body #editNombre').val(nombre);
            modal.find('.modal-body #editNumero').val(celular);
            modal.find('.modal-body #editCorreo').val(direccion);
        });
    </script>
</body>

</html>

<?php
// Cerrar la conexión
$con->close();
?>

<?php
session_start();

//Preguntar por el pais con ese id
require 'header.php';
if (isset($_GET['id_pais'])) {
    require 'conexion.php';
    $id_pais = $_GET['id_pais'];
    $sql = "SELECT * FROM paises WHERE id_pais= '$id_pais'";

    $datoss = $con->query($sql);
    $campoo = $datoss->fetch_object();
    $nombreI = $campoo->nombre_pais;
}



$mensaje = "";
if (isset($_POST['accion'])) {
    //Inserta un pais
    if ($_POST['accion'] == "Guardar") {
        require 'conexion.php';
        $nombre = $_POST['nombre'];
        $sql = "INSERT INTO paises(id_pais, nombre_pais) VALUES (NULL,'$nombre')";
        $datos = $con->query($sql);

        if ($datos) {
            $mensaje = "Pais registrado correctamente";
            $class = "alert alert-success";
        }
    } else if ($_POST['accion'] == "Actualizar") {
        $id = $_GET['id_pais'];
        $nombre = $_POST['nombre'];
        $sql = "UPDATE paises SET nombre_pais = '$nombre' WHERE id_pais='$id'";
        $datos = $con->query($sql);
        


        $_SESSION['mensaje'] =
            '<div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                 Pais actualizado correctamente
            </div>
            </div>';
    }
    
}


?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Paises</title>
</head>

<body>
    <div class="container">
        <form action="" method="POST">

            <div class="row">
                <div class="<?php echo $class; ?>">
                    <?php echo $mensaje; ?>
                </div>
            </div>

            <div class="row">
                <?php
                if (isset($_SESSION['mensaje'])) {
                    echo $_SESSION['mensaje'];
                    unset($_SESSION['mensaje']);
                }
                ?>
            </div>

            <div class="col-md-6">
                <label for="nombre">Nombre del pais:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo @$nombreI; ?>">
            </div>
            <hr /> <br>
            <div class="col-md-12">
                <button name="accion" class="btn btn-success" value="Guardar" type="submit">Guardar Pais</button>
                <?php
                if (isset($_GET['id_pais'])) {
                ?>
                    <button name="accion" class="btn btn-primary" value="Actualizar" type="submit">Actualizar</button>

                <?php

                }

                ?>


            </div>
            <br>

            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE PAIS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'conexion.php';
                        //----------LISTAR-----------------------------------
                        $sql = "SELECT * FROM `paises`";
                        $datos = $con->query($sql);

                        while ($campo = $datos->fetch_object()) {
                        ?>
                            <tr>
                                <td><?php echo $campo->id_pais; ?></td>
                                <td><?php echo $campo->nombre_pais; ?></td>

                                <td>
                                    <a href="pais.php?id_pais=<?php echo $campo->id_pais; ?>" class="btn btn-info">Editar</a>
                                    <a href="eliminar_pais.php?id=<?php echo base64_encode($campo->id_pais); ?>" class="btn btn-danger">Eliminar</a>

                                </td>

                            </tr>

                        <?php

                        }

                        ?>
                    </tbody>
                </table>
            </div>

        </form>


    </div>
</body>

</html>
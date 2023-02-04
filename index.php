<?php
require 'header.php';
if (isset($_GET['id_equipo'])) {
    require 'conexion.php';
    $id_equipo = $_GET['id_equipo'];
    $sql = "SELECT * FROM equipos WHERE id= '$id_equipo'";

    $datoss = $con->query($sql);
    $campoo = $datoss->fetch_object();
    $id_pais = $campoo->id_pais;
    $id_ciudad = $campoo->id_ciudad;
    $equipoI = $campoo->nombre;
}

$mensaje = "";
if (isset($_POST['accion'])) {
    //Inserta un equipo
    if ($_POST['accion'] == "Guardar") {
        require 'conexion.php';
        $pais = $_POST['pais'];
        $ciudad = $_POST['ciudad'];
        $nombre = $_POST['nombre'];

        $sql = "INSERT INTO `equipos`(`id`, `id_pais`, `id_ciudad`, `nombre`) VALUES (NUll,'$pais','$ciudad','$nombre')";
        $datos = $con->query($sql);

        if ($datos) {
            $mensaje = "Equipo registrado correctamente";
            $class = "alert alert-success";
        }
    } else if ($_POST['accion'] == "Actualizar") {
        $id_equipo = $_GET['id_equipo'];
        $id_pais = $_POST['pais'];
        $id_ciudad = $_POST['ciudad'];
        $nombre = $_POST['nombre'];
        $sql = "UPDATE equipos SET id_pais = '$id_pais', id_ciudad = '$id_ciudad', nombre = '$nombre' WHERE id='$id_equipo'";
        $datos = $con->query($sql);

        $_SESSION['mensaje'] =
        '<div class="alert alert-warning d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
             Equipo actualizado correctamente
        </div>
        </div>';
        
        
    }
}




?>



<!doctype html>
<html lang="en">

<head>
    <title>Equipos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <form action="" method="POST">
            <div class="row">
                <div class="<?php echo $class; ?>">
                    <?php echo $mensaje;?>
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
                <label for="pais">Nombre de los Paises:</label>
                <select class="form-select" name="pais" aria-label="Default select example">
                    <option selected>Seleccione el pais</option>

                    <?php
                    require 'conexion.php';
                    $sql = "SELECT * FROM paises";
                    $datos = $con->query($sql);
                    while ($campo = $datos->fetch_object()) {
                        echo $campo->nombre_pais;
                        echo $campo->id_pais;
                    ?>
                        <option value="<?php echo $campo->id_pais; ?>"><?php echo $campo->nombre_pais; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <br>
            <div class="col-md-6">
                <label for="ciudad">Nombre de la ciudad:</label>
                <select class="form-select" name="ciudad" aria-label="Default select example">
                    <option selected>Seleccione la ciudad</option>

                    <?php
                    require 'conexion.php';
                    $sql = "SELECT * FROM ciudad";
                    $datos = $con->query($sql);
                    while ($campo = $datos->fetch_object()) {
                        echo $campo->nombre_ciudad;
                        echo $campo->id_pais;
                    ?>
                        <option value="<?php echo $campo->id_ciudad ?> "><?php echo $campo->nombre_ciudad; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <br>

            <div class="col-md-6">
                <label for="nombre">Nombre del equipo:</label>
                <input type="text" name="nombre" class="form-control" maxlength="60" required value="<?php echo @$equipoI; ?> " />
            </div>
            <hr />
            <br>

            <div class="col-md-12">
                <button name="accion" class="btn btn-success" value="Guardar">Guardar Equipo</button>
                <?php
                if (isset($_GET['id_equipo'])) {
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
                            <th>ID EQUIPO</th>
                            <th>NOMBRE PAIS</th>
                            <th>NOMBRE CIUDAD</th>
                            <th>NOMBRE EQUIPO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //----------LISTAR CIUDADES-----------------------------------
                        require 'conexion.php';

                        $sql = "SELECT e.id,e.nombre, p.nombre_pais,c.nombre_ciudad FROM equipos e 
                        INNER JOIN ciudad c ON e.id_ciudad= c.id_ciudad 
                        INNER JOIN paises p ON c.id_pais=p.id_pais";
                        $datos = $con->query($sql);

                        while ($campo = $datos->fetch_object()) {
                        ?>
                            <tr>
                                <td><?php echo $campo->id; ?></td>
                                <td><?php echo $campo->nombre_pais; ?></td>
                                <td><?php echo $campo->nombre_ciudad; ?></td>
                                <td><?php echo $campo->nombre; ?></td>
                                <td>
                                    <a href="index.php?id_equipo=<?php echo $campo->id; ?>" class="btn btn-info">Editar</a>
                                    <a href="eliminar_equipo.php?id_equipo=<?php echo base64_encode($campo->id); ?>" class="btn btn-danger">Eliminar</a>
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





    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
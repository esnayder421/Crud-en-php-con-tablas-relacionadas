<?php
require 'header.php';
session_start();

if (isset($_GET['id_ciudad'])) {
    require 'conexion.php';
    $id_ciudad = $_GET['id_ciudad'];
    $sql = "SELECT * FROM ciudad WHERE id_ciudad= '$id_ciudad'";

    $datoss = $con->query($sql);
    $campoo = $datoss->fetch_object();
    $id_pais=$campoo->id_pais;
    $ciudadI = $campoo->nombre_ciudad;
}

$mensaje = "";
if (isset($_POST['accion'])) {
    //Inserta una ciudad
    if ($_POST['accion'] == "Guardar") {
        require 'conexion.php';
        $pais = $_POST['pais'];
        $nombre = $_POST['nombre'];

        $sql = "INSERT INTO `ciudad`(`id_ciudad`, `id_pais`, `nombre_ciudad`) VALUES (NUll,'$pais','$nombre')";
        $datos = $con->query($sql);

        if ($datos) {
            $mensaje = "Ciudad registrada correctamente";
            $class = "alert alert-success";
        }

    }else if($_POST['accion']=="Actualizar"){
        $id_ciudad= $_GET['id_ciudad'];
        $id_pais = $_POST['pais'];
        $nombre =$_POST['nombre'];
        $sql="UPDATE ciudad SET id_pais = '$id_pais', nombre_ciudad = '$nombre' WHERE id_ciudad='$id_ciudad'";
        $datos= $con->query($sql);
       
        $_SESSION['mensaje'] =
        '<div class="alert alert-warning d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
             Ciudad actualizado correctamente
        </div>
        </div>';
        
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Ciudad</title>
</head>

<body>
    <div class="container">
        <form action="" method="POST">
            <br>
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

            <label for="pais">Paises:</label>
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
            </div><br>

            <div class="col-md-6">
                <label for="nombre">Nombre de la Ciudad:</label>
                <input type="text" name="nombre" class="form-control" maxlength="60" required value="<?php echo @$ciudadI; ?>"  />
            </div>
            <hr />
            <div class="col-md-12">
                <button name="accion" class="btn btn-success" value="Guardar">Guardar Ciudad</button>
                <?php
                if (isset($_GET['id_ciudad'])) {
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
                            <th>ID CIUDAD</th>
                            <th>NOMBRE PAIS</th>
                            <th>NOMBRE CIUDAD</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        //----------LISTAR CIUDADES-----------------------------------
                        require 'conexion.php';

                        $sql = "SELECT c.id_ciudad, p.nombre_pais, c.nombre_ciudad FROM ciudad c, paises p WHERE c.id_pais=p.id_pais  ";
                        $datos = $con->query($sql);

                        while ($campo = $datos->fetch_object()) {
                        ?>
                            <tr>
                                
                                <td><?php echo $campo->id_ciudad; ?></td>
                                <td><?php echo $campo->nombre_pais; ?></td>
                                <td><?php echo $campo->nombre_ciudad; ?></td>

                                <td>
                                <a href="ciudad.php?id_ciudad=<?php echo $campo->id_ciudad; ?>" class="btn btn-info">Editar</a>
                                    <a href="eliminar_ciudad.php?id=<?php echo base64_encode($campo->id_ciudad); ?>" class="btn btn-danger">Eliminar</a>
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
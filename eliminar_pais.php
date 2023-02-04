<?php
session_start();

require_once 'conexion.php';
$id = base64_decode($_GET['id']);
$sql = "DELETE FROM `paises` WHERE id_pais=$id";
$datos = $con->query($sql);
// despues de borrar el dato redireccionamos a el index (pagina principal)

$_SESSION['mensaje'] =
    '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                 Pais eliminado correctamente
            </div>
            </div>';

header("location:pais.php");

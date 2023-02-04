<?php


require_once 'conexion.php';
$id_equipo = base64_decode($_GET['id_equipo']);
$sql ="DELETE FROM `equipos` WHERE id=$id_equipo";
$datos = $con->query($sql);
// despues de borrar el dato redireccionamos a el index (pagina principal)


header("location:index.php");
<?php
function obtener_parametro($par, $array) {
    return isset($array[$par]) ? trim($array[$par]) : null;
}

function obtener_get($par) {
    return obtener_parametro($par, $_GET);
}

function obtener_post($par) {
    return obtener_parametro($par, $_POST);
}

function conectar() {
    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}

function volver(){
    header("Location: index.php");
}

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

function obtener_codigo_insertar(&$error) {
    return filter_input(INPUT_POST, 'codigo', FILTER_CALLBACK, [
        'options' => function ($x) use (&$error) {
            $long = mb_strlen($x);
            if ($long < 1 || $long > 2) {
                insertar_error(
                'codigo',
                'La longitud del código es incorrecta',
                $error
                );
            }
            if (!ctype_digit($x)) {
                insertar_error(
                    'codigo',
                    'Los caracteres del código no son válidos',
                    $error
                );
            }
            if (empty($error['codigo'])) {
                $pdo = conectar();
                $sent = $pdo->prepare("SELECT COUNT(*)
                                       FROM departamentos
                                       WHERE codigo = :codigo");
                $sent->execute([':codigo' => $x]);
                $cuantos = $sent->fetchColumn();
                if ($cuantos !== 0) {
                    insertar_error('codigo', 'El código ya existe', $error);
                }
            }
            return $x;
        }
    ]);
}

function insertar_error($campo, $mensaje, &$error) {
    if (!isset($error[$campo])) {
        $error[$campo] = [];
    }
    $error[$campo] = $mensaje;
}

function comprobar_parametros($codigo, $denominacion) {
    if(!isset($codigo, $denominacion)) {
        throw new Exception();
    }
}

function validar_digitos($numero, $campo, &$error) {
    if (!ctype_digit($numero)) {
        insertar_error(
            $campo,
            'Los caracteres del campo no son válidos',
            $error
        );
    }
}

function comprobar_errores($error) {
    if (!empty($error)) {
        throw new Exception();
    }
}

function validar_rango_numerico($numero, $campo, $min, $max, &$error) {
    if ($numero < $min || $numero > $max) {
        insertar_error(
            $campo,
            'La longitud del campo es incorrecta',
            $error
        );
    }
}

function validar_existe($tabla, $columna, $valor, $campo, &$error) {
    $pdo = conectar();
    $sent = $pdo->prepare("SELECT COUNT(*)
                            FROM $tabla
                           WHERE $columna = :$columna");
    $sent->execute([":$columna => $valor"]);
    $cuantos = $sent->fetchColumn();
    if ($cuantos !==0){
        insertar_error($campo, 'La fila ya existe', $error);
    }
}

function validar_longitud($cadena, $campo, $min, $max, &$error) {
    $long = mb_strlen($cadena);

    if ($long < $min || $long > $max) {
        insertar_error(
            $campo,
            'La longitud del campo es incorrecta',
            $error
        );
    }
}

function insertar_departamento($codigo, $denominacion) {
    $pdo = conectar();
    $sent = $pdo->prepare("INSERT 
                             INTO departamentos (codigo, denominacion)
                           VALUES (:codigo, :denominacion)");
    $sent->execute([
        ':codigo' => $codigo,
        ':denominacion' => $denominacion,
    ]);
}
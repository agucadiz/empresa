<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}

/**
 * Vuelve al index.php
 */
function volver_principal()
{
    header("Location: /index.php");
}

function volver_empleados()
{
    header("Location: /empleados/");
}

function volver_departamentos()
{
    header("Location: /departamentos/");
}

function obtener_get($par)
{
    return obtener_parametro($par, $_GET);
}

function obtener_post($par)
{
    return obtener_parametro($par, $_POST);
}

function obtener_parametro($par, $array)
{
    return isset($array[$par]) ? trim($array[$par]) : null;
}

function obtener_parametros(array $par, array $array): array
{
    $res = [];

    foreach ($par as $p) {
        $res[$p] = obtener_parametro($p, $array);
    }

    return $res;
}

function comprobar_parametros(array $par): bool
{
    foreach ($par as $v) {
        if ($v === null) {
            return false;
        }
    }

    return true;
}

function validar_codigo($numero, &$error)
{
    validar_digitos($numero, 'numero', $error);
    validar_rango_numerico($numero, 'numero', 0, 99, $error);
    validar_numerico($numero, 'numero', $error);
    //validar_existe.
    //validar_longitud.
    //validar número.
}

function validar_denominacion($nombre, &$error)
{
    validar_longitud($nombre, 'denominacion', 1, 255, $error);
}

function validar_digitos($numero, $campo, &$error): bool
{
    if (!ctype_digit($numero)) {
        insertar_error(
            $campo,
            'Los caracteres del campo no son válidos',
            $error
        );
        return false;
    }

    return true;
}

function validar_numerico($numero, $campo, &$error)
{
    if (!is_numeric($numero)) {
        insertar_error(
            $campo,
            'El campo no tiene un valor numérico válido',
            $error
        );
    }
}

function validar_rango_numerico($numero, $campo, $min, $max, &$error)
{
    if ($numero < $min || $numero > $max) {
        insertar_error(
            $campo,
            'La longitud del campo es incorrecta',
            $error
        );
    }
}

function comprobar_existe($tabla, $columna, $valor)
{
    $pdo = conectar();
    $sent = $pdo->prepare("SELECT COUNT(*)
                             FROM $tabla
                            WHERE $columna = :$columna");
    $sent->execute([":$columna" => $valor]);
    $cuantos = $sent->fetchColumn();
    return $cuantos;
}

function validar_existe($tabla, $columna, $valor, $campo, &$error): bool
{
    $pdo = conectar();
    $sent = $pdo->prepare("SELECT COUNT(*)
                             FROM $tabla
                            WHERE $columna = :$columna");
    $sent->execute([":$columna" => $valor]);
    $cuantos = $sent->fetchColumn();
    if ($cuantos !== 0) {
        insertar_error($campo, 'La fila ya existe', $error);
        return false;
    }
    return true;
}

function validar_longitud($cadena, $campo, $min, $max, &$error)
{
    $long = mb_strlen($cadena);

    if ($long < $min || $long > $max) {
        insertar_error(
            $campo,
            'La longitud del campo es incorrecta',
            $error
        );
    }
}

function insertar_error($campo, $mensaje, &$error)
{
    if (!isset($error[$campo])) {
        $error[$campo] = [];
    }
    $error[$campo][] = $mensaje;
}

function mostrar_errores($campo, $error)
{
    if (isset($error[$campo])) {
        foreach ($error[$campo] as $mensaje) { ?>
            <ul <?= css_error($campo, $error) ?>>
                <li><?= $mensaje ?></li>
            </ul><?php
                }
            }
        }

        function comprobar_params($codigo, $denominacion)
        {
            if (!isset($codigo, $denominacion)) {
                throw new Exception();
            }
        }

        function hay_errores($error)
        {
            return !empty($error);
        }

        function css_error($campo, $error)
        {
            return isset($error[$campo]) ? 'class="error"' : '';
        }

        function css_campo_error($campo, $error)
        {
            return isset($error[$campo]) ? 'class="campo-error"' : '';
        }

        function cabecera()
        { ?>
    <nav style="padding: 4px; text-align: right; border: 1.5px solid;" class="container mx-auto">
        <a href="/empleados/" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Empleados</a>
        <a href="/departamentos/" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Departamentos</a>
    </nav><?php
        }

        function selected($a, $b)
        {
            return $a == $b ? 'selected' : '';
        }

        function hh($x)
        {
            return htmlspecialchars($x ?? '', ENT_QUOTES | ENT_SUBSTITUTE);
        }

        function pie()
        {
            if (isset($_COOKIE['acepta_cookies'])) {
                return;
            } ?>
    <form action="/comunes/cookies.php" method="get" style="border: 1px solid; margin-top: 1em; padding: 0.5ex 1.5ex">
        <p align="right">
            Este sitio usa cookies.
            <button type="submit">Aceptar</button>
        </p>
    </form><?php
        }

        function token_csrf()
        {
            $token_csrf = sesion_csrf();
            ?>
    <input type="hidden" name="token_csrf" value="<?= $token_csrf ?>"><?php
                                                                    }

                                                                    function sesion_csrf()
                                                                    {
                                                                        // TODO: Expiración del token de sesión
                                                                        if (!isset($_SESSION['token_csrf'])) {
                                                                            $_SESSION['token_csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
                                                                            // $_SESSION['token_csrf_time'] = time();
                                                                        } // else if (time() - $_SESSION['token_csrf_time'] > )
                                                                        return $_SESSION['token_csrf'];
                                                                    }

                                                                    function comprobar_csrf(): bool
                                                                    {
                                                                        return obtener_post('token_csrf') === $_SESSION['token_csrf'];
                                                                    }

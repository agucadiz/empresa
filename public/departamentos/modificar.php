<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar un departamento</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $id = obtener_get('id');

    if (!isset($id)) {
        return volver_principal();
    }

    const PAR = [
        'codigo',
        'denominacion',
    ];

    $par = obtener_parametros(PAR, $_POST);
    extract($par);

    $pdo = conectar();
    $error = [];

    if (comprobar_parametros($par)) {
        validar_codigo($codigo, $error);
        validar_denominacion($denominacion, $error);
        if (!hay_errores($error)) {
            $sent = $pdo->prepare("UPDATE departamentos
                                  SET codigo = :codigo,
                                      denominacion = :denominacion
                                WHERE id = :id");
        $sent->execute([
            ':codigo' => $codigo,
            ':denominacion' => $denominacion,
            ':id' => $id]);
        }
        return volver_principal();
    } else {
        $pdo = conectar();
        $sent = $pdo->prepare("SELECT codigo, denominacion
                                 FROM departamentos
                                WHERE id = :id");
        $sent->execute([':id' => $id]);
        $fila = $sent->fetch();

        if (empty($fila)) {
            return volver_principal();
        }
        extract($fila);
    }

    cabecera();
    ?>
    <div>
        <form action="" method="post">
            <div>
                <label <?= css_campo_error('codigo', $error) ?>>
                    Código:
                    <input type="text" name="codigo" size="10"
                    value="<?= $codigo ?>"
                    <?= css_campo_error('codigo', $error) ?>
                    >
                </label>
                <?php mostrar_errores('codigo', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('denominacion', $error) ?>>
                    Denominación:
                    <input type="text" name="denominacion"
                    value="<?= $denominacion ?>"
                    <?= css_campo_error('denominacion', $error) ?>
                    >
                </label>
                <?php mostrar_errores('denominacion', $error) ?>
            </div>
            <div>
                <button type="submit">Modificar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>

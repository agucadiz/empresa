<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar un empleado</title>
</head>

<body>
    <?php
    require 'auxiliar.php';

    $id = obtener_get('id');

    if (!isset($id)) {
        return volver_principal();
    }

    const PAR = [
        'numero',
        'nombre',
        'salario',
        'fecha_nac',
        'departamento_id',
    ];

    $par = obtener_parametros(PAR, $_POST);
    extract($par);

    $pdo = conectar();
    $error = [];
    
    if (comprobar_parametros($par)) {
        validar_numero($numero, $error);
        validar_nombre($nombre, $error);
        validar_salario($salario, $error);
        validar_fecha_nac($fecha_nac, $error);
        validar_departamento_id($departamento_id, $error);
        if (!hay_errores($error)) {
            $sent = $pdo->prepare("UPDATE empleados
                                  SET numero = :numero,
                                      nombre = :nombre
                                      salario = :salario
                                      fecha_nac = :fecha_nac
                                      departamento_id = :departamento_id
                                WHERE id = :id");
            $sent->execute([
                ':numero' => $numero,
                ':nombre' => $nombre,
                ':salario' => $salario,
                ':fecha_nac' => $fecha_nac,
                ':departamento_id' => $departamento_id,
                ':id' => $id
            ]);
        }
        return volver_principal();
    } else {
        $pdo = conectar();
        $sent = $pdo->prepare("SELECT numero, nombre, salario, fecha_nac, departamento_id
                                 FROM empleados
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
                <label <?= css_campo_error('numero', $error) ?>>
                    Número:
                    <input type="text" name="numero" size="10" 
                    value="<?= $numero ?>" 
                    <?= css_campo_error('numero', $error) ?>
                    >
                </label>
                <?php mostrar_errores('numero', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('nombre', $error) ?>>
                    Nombre:
                    <input type="text" name="nombre" 
                    value="<?= $nombre ?>" 
                    <?= css_campo_error('nombre', $error) ?>
                    >
                </label>
                <?php mostrar_errores('nombre', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('salario', $error) ?>>
                    Salario:
                    <input type="text" name="salario" 
                    value="<?= $salario ?>" 
                    <?= css_campo_error('salario', $error) ?>
                    >
                </label>
                <?php mostrar_errores('salario', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('fecha_nac', $error) ?>>
                    Fecha de nacimiento:
                    <input type="date" name="fecha_nac" 
                    value="<?= $fecha_nac ?>" 
                    <?= css_campo_error('fecha_nac', $error) ?>
                    >
                </label>
                <?php mostrar_errores('fecha_nac', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('departamento_id', $error) ?>>
                    Departamento:
                    <select name="departamento_id">
                        <?php foreach ($departamentos as $departamento) : ?>
                            <option value="<?= $departamento['id'] ?>" <?= selected(
                                                                            $departamento['id'],
                                                                            $departamento_id
                                                                        ) ?>>
                                <?= $departamento['denominacion'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </label>
                <?php mostrar_errores('departamento_id', $error) ?>
            </div>
            <div>
                <button type="submit">Modificar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>
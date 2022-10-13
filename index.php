<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <!-- psql -h localhost -d empresa -U empresa
         psql -h localhost -d empresa -U empresa < empresa.sql
    -->
    
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $sent = $pdo->query('SELECT * FROM departamentos ORDER BY codigo');
    $filas = $sent->fetchAll();?>

    <table border="1"><?php
    foreach ($filas as $key => $value) {?>
    <tr>
        <td><?php print_r($value['codigo']); ?></td>
        <td><?php print_r($value['denominacion']); ?></td>
    </tr>
    <?php
    }?>
    </table>
    <?php

/*     echo "<pre>";
    foreach ($sent as $fila) {
        print_r($fila);
    }
    echo "</pre>"; */
    ?>
</body>
</html>
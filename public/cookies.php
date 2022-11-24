<?php
session_start();

require '../src/auxiliar.php';

setcookie('acepta_cookies', '1', time() + 3600 * 24 * 30, '/');
volver_principal();

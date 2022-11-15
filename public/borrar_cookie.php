<?php

session_start();

require '../../src/auxiliar.php';

setcookie('acepta_cookies', '1', 1, '/');
volver_principal();

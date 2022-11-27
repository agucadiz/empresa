<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Empresa</title>
</head>

<body>
    <?php
    require '../src/auxiliar.php';

    cabecera();
    ?>

    <div class="container mx-auto">
        <form action="borrar_cookie.php">
            <button type="submit">Borrar cookie</button>
        </form>

        <div class="overflow-x-auto relative mt-4 text-center h-96" >
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Proyecto de Empresa</h1>
            <p class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Este proyecto está compuesto por los apartados de departamentos y empleados de una empresa.</p>
            <a href="https://github.com/agucadiz/empresa" target="_blank" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                Proyecto GitHub
                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>

        <div>
            <?php pie() ?>
        </div>
    </div>



    <script src="/js/flowbite/flowbite.js"></script>

</body>

</html>
<?php
define("_PROJECT", true);
require_once("includes/autoload.inc.php");
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap core -->
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- bootstrap popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="css/bootstrap-icons.min.css">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
    <!-- jquery mobile -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <!-- jquery ui -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <!-- own files -->
    <script async src="js/ajax.class.js"></script>
    <script async src="js/callbacks.js"></script>
    <script async src="js/functions.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>PROJECT</title>
</head>
<body data-bs-theme="dark"> <!-- theme: dark or light  -->
    <div class="container-fluid">
        <header class="container-fluid">
            <nav id="main-nav" class="navbar navbar-expand-lg" data-bs-theme="dark"></nav>
        </header>
        <main class="container-lg">
            <div class="row" id="alerts"></div>
            <div class="row" id="content">
                <div class="col-12 col-md-8 col-lg-9 col-xl-10"></div>
                <aside class="col-12 col-md-4 col-lg-3 col-xl-2"></aside>
            </div>
        </main>
        <footer class="container-fluid"></footer>        
    </div>
</body>
</html>
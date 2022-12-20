<?php

declare(strict_types=1);

session_start();

require_once("classes/customer.php");
require_once("classes/customer_status.php");
require_once("classes/ticket.php");
require_once("classes/pages.php");
require_once("classes/donation.php");

define("ROOT", $_SERVER["REDIRECT_ROOT"]);


define("ROUTE", $_SERVER["REDIRECT_ROUTE"]);


define("PATH", ROOT . ROUTE);

function getPDO(): PDO
{
    static $pdo = new PDO("mysql:host=localhost;dbname=de-natte-zeehond", "root", "");

    return $pdo;
}


?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" href="<?= ROOT ?>/img/Logo.png">

    <link rel="stylesheet" href="<?= ROOT ?>/style.css">
    <title>De Blauwe Loper</title>
</head>

<body>
    <?php
    /** `ROUTE` split on '/' */
    $route = explode("/", trim(ROUTE, "/"));


    $finalRoute = (ROUTE !== "/")
        ? ROUTE
        : header("Location: " . ROOT . "/start");
    require_once("required/header.php");
    require_once("pages" . ROUTE . ".php");

    ?>
</body>

</html>
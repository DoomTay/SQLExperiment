<?php
require("functions/connect.php");
require("functions/pagination.php");

$currentPage = isset($_GET["page"]) ? max($_GET["page"],1) : 1;

$total = implode($worldDB->query("SELECT COUNT(*) FROM country") -> fetch(PDO::FETCH_ASSOC));
$perPage = 15;
$maxPages = ceil($total / $perPage);

$pageTitle = "Main Page";
include("templates/header.php");
require("functions/pageStuff.php");
include("templates/body.php");

$offset = $perPage * ($currentPage - 1);

getPages("country","Code","Code");
include("templates/footer.php");
?>
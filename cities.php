<?php
require("functions/connect.php");
require("functions/pagination.php");

$currentPage = isset($_GET["page"]) ? max($_GET["page"],1) : 1;

$total = implode($worldDB->query("SELECT COUNT(*) FROM city") -> fetch(PDO::FETCH_ASSOC));
$perPage = 15;
$maxPages = ceil($total / $perPage);

$pageTitle = "Cities";
include("templates/header.php");
require("functions/pageStuff.php");
include("templates/body.php");

$offset = $perPage * ($currentPage - 1);

getPages("city","ID","CountryCode");
include("templates/footer.php");
?>
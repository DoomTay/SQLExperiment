<?php
require_once("template.php");
require_once("connect.php");
require_once("pagination.php");

$currentPage = isset($_GET["page"]) ? max($_GET["page"],1) : 1;

$total = implode($conn->query("SELECT COUNT(*) FROM country") -> fetch(PDO::FETCH_ASSOC));
$perPage = 15;
$maxPages = ceil($total / $perPage);

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Main Page";
	$TPL->ContentBody = __FILE__;
    $TPL->ContentHead = "pageStuff.php";
    include "layout.php";
    exit;
}

$offset = $perPage * ($currentPage - 1);

getPages("country","Code","Code");
?>
<?php
require_once("template.php");
require_once("connect.php");
require_once("pagination.php");

$currentPage = isset($_GET["page"]) ? max($_GET["page"],1) : 1;

$total = implode($conn->query("SELECT COUNT(*) FROM city") -> fetch(PDO::FETCH_ASSOC));
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

$pageQuery = $conn->query("SELECT * FROM city ORDER By Name LIMIT $perPage OFFSET $offset");

if($pageQuery->rowCount() > 0)
{
	echo "<ul id=\"results\">\n";

	while($row = $pageQuery->fetch(PDO::FETCH_ASSOC))
	{
		echo "\t<li>\n".
		"\t\t<div class=\"resultbox\">\n".
		"\t\t\t<header><a href=\"/city.php?id=".$row["ID"]."\">".$row["Name"]."</a></header>\n".
		"\t\t\t<div>".$row["CountryCode"]."</div>\n".
		"\t\t</div>\n".
		"\t</li>\n";
	}
	
	echo "</ul>";
}
else
{
	echo "0 results";
}

echo "\n";

createPageList($currentPage,$maxPages);

getPages("city","ID","CountryCode");
?>
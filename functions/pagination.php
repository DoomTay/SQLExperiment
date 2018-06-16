<?php
require ("functions/linkConversionFunctions.php");

function createPageList($currentPage,$maxPages)
{
	global $currentURL;
	echo "<ul id=\"pages\">\n";

	$withPage = $currentURL;
	if(strpos($withPage, 'page=') === false)
	{
		if(strpos($withPage, '?') !== false)
		{
			if(strpos($withPage, '?') == strlen($withPage) - 1) $withPage = $withPage."page=0";
			else $withPage = $withPage."&page=0";
		}
		else $withPage = $withPage."?page=0";
	}
	else $withPage = preg_replace("/page=-?\d+/","page=0",$withPage);
	$withPage = htmlentities($withPage);

	//First page in list
	echo "\t<li><a href=\"".str_replace("page=0","page=1",$withPage)."\"".($currentPage == 1 ? " class=\"active\"" : "").">1</a></li>\n";
	if($currentPage > 4) echo "\t<li>...</li>\n";

	$compressedStart = max(2,$currentPage - 2);

	//Get four other pages surrounding current page
	for($i = min($compressedStart,$maxPages - 4); $i < min($compressedStart + 5,$maxPages); $i++)
	{
		echo "\t<li><a href=\"".str_replace("page=0","page=".$i,$withPage)."\"".($currentPage == $i ? " class=\"active\"" : "").">".$i."</a></li>\n";
	}

	if($currentPage + 2 < ($maxPages - 1)) echo "\t<li>...</li>\n";
	//Final page
	echo "\t<li><a href=\"".str_replace("page=0","page=".($maxPages),$withPage)."\"".($currentPage == $maxPages ? " class=\"active\"" : "").">$maxPages</a></li>\n";

	echo "</ul>";
}

function getPages($table,$IDProperty,$secondaryName)
{
	global $worldDB;
	global $perPage;
	global $offset;
	global $currentPage;
	global $maxPages;
	
	$pageQuery = $worldDB->query("SELECT * FROM $table ORDER By Name LIMIT $perPage OFFSET $offset");
	
	if($pageQuery->rowCount() > 0)
	{
		echo "<ul id=\"results\">\n";

		while($row = $pageQuery->fetch(PDO::FETCH_ASSOC))
		{
			echo "\t<li>\n".
			"\t\t<div class=\"resultbox\">\n".
			"\t\t\t<header>";
			if($table == "country") echo countryToLink($row);
			else if($table == "city") echo cityToLink($row);
			else echo "<a href=\"/$table.php?id=".$row[$IDProperty]."\">".$row["Name"]."</a>";
			echo "</header>\n".
			"\t\t\t<div>".$row[$secondaryName]."</div>\n".
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
}
?>
<?php
require ("functions/linkConversionFunctions.php");

function createPageList($currentPage,$maxPages)
{
	global $currentURL;
?>
<ul id="pages">
<?php

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
?>
	<li><a href="<?php echo str_replace("page=0","page=1",$withPage) ?>"<?php echo ($currentPage == 1 ? " class=\"active\"" : "") ?>>1</a></li>
<?php if($currentPage > 4): ?>
	<li>...</li>
<?php
	endif;
	$compressedStart = max(2,$currentPage - 2);

	//Get four other pages surrounding current page
	for($i = min($compressedStart,$maxPages - 4); $i < min($compressedStart + 5,$maxPages); $i++)
	{
?>
	<li><a href="<?php echo str_replace("page=0","page=$i",$withPage) ?>"<?php echo ($currentPage == $i ? " class=\"active\"" : "") ?>><?php echo $i ?></a></li>
<?php
	}
	
	if($currentPage + 2 < ($maxPages - 1)): ?>
	<li>...</li>
<?php
	endif;
	//Final page
?>
	<li><a href="<?php echo str_replace("page=0","page=$maxPages",$withPage) ?>"<?php echo ($currentPage == $maxPages ? " class=\"active\"" : "") ?>><?php echo $maxPages ?></a></li>
</ul>
<?php
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
?>
<ul id="results">
<?php

		while($row = $pageQuery->fetch(PDO::FETCH_ASSOC))
		{
?>
	<li>
		<div class="resultbox">
			<header><?php
			if($table == "country") echo countryToLink($row);
			else if($table == "city") echo cityToLink($row);
			else echo "<a href=\"/$table.php?id=".$row[$IDProperty]."\">".$row["Name"]."</a>";
			?></header>
			<div><?php echo $row[$secondaryName] ?></div>
		</div>
	</li>
<?php
		}
?>
</ul>
<?php
	}
	else
	{
?>
0 results
<?php
	}
?>

<?php

	createPageList($currentPage,$maxPages);
}
?>
<?php
function pageUp()
{
	global $currentURL;
	global $currentPage;
	
	$nextPage = $currentURL;
	if(strpos($nextPage, 'page=') === false)
	{
		if(strpos($nextPage, '?') !== false) $nextPage = $nextPage."&page=0";
		else $nextPage = $nextPage."?page=0";
	}
	$nextPage = htmlentities($nextPage);
	
	return preg_replace("/page=(\d+)/","page=".($currentPage + 1),$nextPage);
}

function pageDown()
{
	global $currentURL;
	global $currentPage;
	
	$nextPage = $currentURL;
	if(strpos($nextPage, 'page=') === false)
	{
		if(strpos($nextPage, '?') !== false) $nextPage = $nextPage."&page=0";
		else $nextPage = $nextPage."?page=0";
	}
	$nextPage = htmlentities($nextPage);
	
	return preg_replace("/page=(\d+)/","page=".($currentPage - 1),$nextPage);
}

if($currentPage > 1) echo "<link rel=\"prev\" href=\"".pageDown()."\" />";
if($currentPage < $maxPages) echo "\n<link rel=\"next\" href=\"".pageUp()."\" />";
?>

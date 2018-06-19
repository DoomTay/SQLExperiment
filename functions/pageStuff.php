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

if($currentPage > 1):?>
<link rel="prev" href="<?php echo pageDown() ?>" />
<?php endif;
if($currentPage < $maxPages):?>
<link rel="next" href="<?php echo pageUp() ?>" />
<?php endif; ?>

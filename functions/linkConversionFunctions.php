<?php
function countryToLink($element)
{
	return "<a href=\"/country.php?id=".$element["Code"]."\">".$element["Name"]."</a>";
}

function cityToLink($element)
{
	return "<a href=\"/city.php?id=".$element["ID"]."\">".$element["Name"]."</a>";
}
?>
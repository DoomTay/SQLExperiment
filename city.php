<?php
require("functions/connect.php");
$cityID = $_GET["id"];

$data = $worldDB->query("SELECT * FROM city WHERE ID = $cityID")->fetch(PDO::FETCH_ASSOC);

if(!$data)
{
	http_response_code(404);
	include("404.php");
	exit;
}

$pageTitle = $data["Name"];
include("templates/header.php");
require("functions/linkConversionFunctions.php");

include("templates/body.php");

$countryData = $worldDB->query("SELECT Code,Name FROM country WHERE Code = 
\"".$data["CountryCode"]."\"")->fetch(PDO::FETCH_ASSOC);
?>
<div style="text-align: center"><img src="http://via.placeholder.com/250x350" width="250" height="350" alt="<?php echo $data["Name"] ?>" /></div>

<div class="infoBox">
	<header><?php echo $data["Name"] ?></header>
	<div>
		<dl>
			<dt>District</dt>
			<dd><?php echo $data["District"] ?></dd>
			<dt>Population</dt>
			<dd><?php echo $data["Population"] ?></dd>
			<dt>Capital</dt>
			<dd><?php echo countryToLink($countryData) ?></dd>
		</dl> 
	</div>
</div>
<?php include("templates/footer.php"); ?>
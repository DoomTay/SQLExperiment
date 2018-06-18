<?php
include("functions/connect.php");
$cityID = $_GET["id"];

$data = $worldDB->query("SELECT * FROM city WHERE ID = \"$cityID\"")->fetch(PDO::FETCH_ASSOC);

if(!$data)
{
	http_response_code(404);
	require("404.php");
	exit;
}

$pageTitle = $data["Name"];
require("templates/header.php");
include("functions/linkConversionFunctions.php");

require("templates/body.php");

$countryData = $worldDB->query("SELECT Code,Name FROM country WHERE Code = 
\"".$data["CountryCode"]."\"")->fetch(PDO::FETCH_ASSOC);

$cityObject = array("District" => $data["District"],
					"Population" =>  $data["Population"],
					"Capital" => countryToLink($countryData)
				);
?>

<div style="text-align: center"><img src="http://via.placeholder.com/250x350" width="250" height="350" alt="<?php echo $data["Name"] ?>" /></div>

<div class="infoBox">
	<header><?php echo $data["Name"] ?></header>
	<div>
		<dl>
<?php foreach ($cityObject as $key => $value): ?>
			<dt><?php echo $key ?></dt>
				<dd><?php echo $value ?></dd>
<?php endforeach; ?>
		</dl> 
	</div>
</div>
<?php require("templates/footer.php"); ?>
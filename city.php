<?php
require_once("template.php");
require_once("connect.php");
require_once("linkConversionFunctions.php");

$cityID = $_GET["id"];

$data = $conn->query("SELECT * FROM city WHERE ID = \"$cityID\"")->fetch(PDO::FETCH_ASSOC);

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = $data["Name"];
	$TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

$countryData = $conn->query("SELECT Code,Name FROM country WHERE Code = 
\"".$data["CountryCode"]."\"")->fetch(PDO::FETCH_ASSOC);

$cityObject = array("District" => $data["District"],
					"Population" =>  $data["Population"],
					"Capital" => countryToLink($countryData)
				);
?>

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
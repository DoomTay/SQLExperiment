<?php
require("functions/connect.php");
$countryID = $_GET["id"];

$data = $worldDB->query("SELECT * FROM country WHERE Code = \"$countryID\"")->fetch(PDO::FETCH_ASSOC);

if(!$data)
{
	http_response_code(404);
	include("404.php");
	exit;
}

$pageTitle = $data["Name"];
include("templates/header.php");
require("functions/linkConversionFunctions.php");
?>
<style>
.cities
{
	list-style-type: none;
	padding: 0;
}
</style>
<?php
include("templates/body.php");

$languages = $worldDB->query("SELECT * FROM countrylanguage WHERE CountryCode = \"$countryID\" ORDER BY Percentage DESC")->fetchAll(PDO::FETCH_ASSOC);
$cities = $worldDB->query("SELECT ID,ID,Name FROM city WHERE CountryCode = \"$countryID\" ORDER BY Population DESC")->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_ASSOC);
?>

<div style="text-align: center"><img src="http://via.placeholder.com/250x350" width="250" height="350" alt="<?php echo $data["Name"] ?>" /></div>

<div class="infoBox">
	<header><?php echo $data["Name"] ?></header>
	<div>
		<dl>
			<dt>Country Code</dt>
			<dd><?php echo $data["Code"] ?></dd>
			<dt>Two-Letter Country Code</dt>
			<dd><?php echo $data["Code2"] ?></dd>
			<dt>Continent</dt>
			<dd><?php echo $data["Continent"] ?></dd>
			<dt>Region</dt>
			<dd><?php echo $data["Region"] ?></dd>
			<dt>Surface Area</dt>
			<dd><?php echo $data["SurfaceArea"] ?> sq. km</dd>
			<dt>Year of Independence</dt>
			<dd><?php echo $data["IndepYear"] ?? "N/A" ?></dd>
			<dt>Cities</dt>
			<dd>
<?php	
	if(count($cities) > 0)
	{		
		$linkifiedCites = array_map("cityToLink",$cities);		
		//echo implode(",\n",$linkifiedCites);
?>
				<ul class="cities">
<?php foreach($linkifiedCites as $city): ?>
					<li><?php echo $city ?></li>
<?php endforeach; ?>
				</ul>
<?php
	}
	else echo "N/A";
?>
			</dd>
			<dt>Languages</dt>
			<dd>
				<table>
				<tr>
					<th>Language</th>
					<th>Percentage</th>
					<th>Official</th>
				</tr>
<?php
	$finalString = "";
							
	if(count($languages) > 0)
	{
		foreach($languages as $lang):
?>
				<tr>
					<td><?php echo $lang["Language"] ?></td>
					<td><?php echo $lang["Percentage"] ?>%</td>
					<td><?php echo $lang["IsOfficial"] == "T" ? "Yes" : "No" ?></td>
				</tr>
<?php endforeach;
	}
	else echo "N/A";
?>
				<tr>
					<td>Samoan</td>
					<td>90.6%</td>
					<td>Yes</td>
				</tr>
				<tr>
					<td>English</td>
					<td>3.1%</td>
					<td>Yes</td>
				</tr>
				<tr>
					<td>Tongan</td>
					<td>3.1%</td>
					<td>No</td>
				</tr>
				</table>
			</dd>
			<dt>Population</dt>
			<dd><?php echo $data["Population"] ?></dd>
			<dt>Life Expectancy</dt>
			<dd><?php echo $data["LifeExpectancy"] ?? "N/A" ?></dd>
			<dt>Gross National Product</dt>
			<dd><?php echo $data["GNP"] ?? "N/A" ?></dd>
			<dt>Gross National Product (Old)</dt>
			<dd><?php echo $data["GNPOld"] ?? "N/A" ?></dd>
			<dt>Local Name</dt>
			<dd><?php echo $data["LocalName"] ?></dd>
			<dt>Form of Government</dt>
			<dd><?php echo $data["GovernmentForm"] ?></dd>
			<dt>Head of State</dt>
			<dd><?php echo $data["HeadOfState"] ?? "N/A" ?></dd>
			<dt>Capital</dt>
			<dd><?php echo $data["Capital"] ? cityToLink($cities[$data["Capital"]]) : "N/A" ?></dd>
		</dl> 
	</div>
</div>
<?php include("templates/footer.php"); ?>
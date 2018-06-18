<?php
include("functions/connect.php");
$countryID = $_GET["id"];

$data = $worldDB->query("SELECT * FROM country WHERE Code = \"$countryID\"")->fetch(PDO::FETCH_ASSOC);

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

$languages = $worldDB->query("SELECT * FROM countrylanguage WHERE CountryCode = \"$countryID\" ORDER BY Percentage DESC")->fetchAll(PDO::FETCH_ASSOC);
$cities = $worldDB->query("SELECT ID,ID,Name FROM city WHERE CountryCode = \"$countryID\" ORDER BY Population DESC")->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_ASSOC);

$countryObject = array("Continent" => $data["Continent"],
						"Region" => $data["Region"],
						"Surface Area" => ($data["SurfaceArea"] . " sq. km"),
						"Year of Independence" => $data["IndepYear"] ?? "N/A",
						"Cities" => (function($cityList)
						{
							$finalString = "";
							
							if(count($cityList) > 0)
							{
								$finalString .= "\n";
								
								$linkifiedCites = array_map("cityToLink",$cityList);
								$linkifiedCites = array_map(function($link){ return "\t\t\t\t$link"; },$linkifiedCites);
								
								$finalString .= implode(",\n",$linkifiedCites);
								
								$finalString .= "\t\t\t";
							}
							else $finalString = "N/A";
							
							return $finalString;
						})($cities),
						"Languages" => (function($languageList)
						{
							$finalString = "";
							
							if(count($languageList) > 0)
							{
								$finalString .= "\n";
								$finalString .= "\t\t\t\t<table>\n";
								$finalString .= "\t\t\t\t<tr>\n";
								$finalString .= "\t\t\t\t\t<th>Language</th>\n";
								$finalString .= "\t\t\t\t\t<th>Percentage</th>\n";
								$finalString .= "\t\t\t\t\t<th>Official</th>\n";
								$finalString .= "\t\t\t\t</tr>\n";
								foreach($languageList as $lang)
								{
									$finalString .= "\t\t\t\t<tr>\n";
									$finalString .= "\t\t\t\t\t<td>".$lang["Language"]."</td>\n";
									$finalString .= "\t\t\t\t\t<td>".$lang["Percentage"]."%</td>\n";
									$finalString .= "\t\t\t\t\t<td>".($lang["IsOfficial"] == "T" ? "Yes" : "No")."</td>\n";
									$finalString .= "\t\t\t\t</tr>\n";
								}
								$finalString .= "\t\t\t\t</table>\n";
								$finalString .= "\t\t\t";
							}
							else $finalString = "N/A";
							
							return $finalString;
						})($languages),
						"Population" => $data["Population"],
						"Life Expectancy" => ($data["LifeExpectancy"] ?? "N/A"),
						"Gross National Product" => ($data["GNP"] ?? "N/A"),
						"Gross National Product (Old)" => ($data["GNPOld"] ?? "N/A"),
						"Local Name" => $data["LocalName"],
						"Form of Government" => $data["GovernmentForm"],
						"Head of State" => ($data["HeadOfState"] ?? "N/A"),
						"Capital" => ($data["Capital"] ? cityToLink($cities[$data["Capital"]]) : "N/A")
						);

?>

<div style="text-align: center"><img src="http://via.placeholder.com/250x350" width="250" height="350" alt="<?php echo $data["Name"] ?>" /></div>

<div class="infoBox">
	<header><?php echo $data["Name"] ?></header>
	<div>
		<dl>
<?php foreach ($countryObject as $key => $value): ?>
			<dt><?php echo $key ?></dt>
				<dd><?php echo $value ?></dd>
<?php endforeach; ?>
		</dl> 
	</div>
</div>
<?php require("templates/footer.php"); ?>
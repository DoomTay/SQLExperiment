<?php
require_once("template.php");
require_once("connect.php");
require_once("linkConversionFunctions.php");

$countryID = $_GET["id"];

$data = $conn->query("SELECT * FROM country WHERE Code = \"$countryID\"")->fetch(PDO::FETCH_ASSOC);

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = $data["Name"];
	$TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}

$languages = $conn->query("SELECT * FROM countrylanguage WHERE CountryCode = \"$countryID\" ORDER BY Percentage DESC")->fetchAll(PDO::FETCH_ASSOC);
$cities = $conn->query("SELECT ID,ID,Name FROM city WHERE CountryCode = \"$countryID\" ORDER BY Population DESC")->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_ASSOC);

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
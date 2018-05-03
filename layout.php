<?php
require_once("template.php");
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport"  content="width=device-width">
<link rel="stylesheet" href="/styles/styles.css" />
<title><?php if(isset($TPL->PageTitle)) { echo $TPL->PageTitle; } ?> - World Database</title>
<?php if(isset($TPL->ContentHead)) { include $TPL->ContentHead; } ?>

</head>

<body>
<header id="mainHeader">
	<h1><a href="/">World Database</a></h1>
</header>
<nav>
	<a href="/">Browse</a>
	<a href="/cities.php">Cities</a>
	<a href="/search.php">Search</a>
</nav>
<div id="content"><?php if(isset($TPL->ContentBody)) { include $TPL->ContentBody; }?>

</div>
</body>
</html>
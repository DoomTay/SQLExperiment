<?php
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport"  content="width=device-width">
<link rel="stylesheet" href="/styles/styles.css" />
<title><?php if(isset($pageTitle)) { echo $pageTitle; } ?> - World Database</title>
<?php
require_once("template.php");
if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Not Found";
    $TPL->ContentBody = __FILE__;
    include "layout.php";
    exit;
}
?>
<h1>Not Found</h1>
<p>The destination you seek is but a mere dream.</p>
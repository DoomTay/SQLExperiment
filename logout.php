<?php

session_start();
session_unset();
session_destroy();

header("location:".$_SERVER['HTTP_REFERER']);
exit();
?>
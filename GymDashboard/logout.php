<?php
session_start();
session_unset();
session_destroy();

// Prevent caching of logout response
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

header("Location: index.php");
exit();

<?php
require __DIR__.'/../src/app.php';
$_SESSION = [];
session_regenerate_id(true);
header('Location: index.php');
exit;

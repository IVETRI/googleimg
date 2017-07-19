<?php
$returnarray = array();
header('Content-Type: application/json');
$returnarray["OK"] = "404";
$returnarray["MSG"] = "these are not the kittens that you are looking for";
echo json_encode($returnarray);
?>

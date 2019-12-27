<?php

$char = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9");

$code = "";

for ($i=0; $i < 6; $i++) {
  $r = $char[rand(0,(count($char)-1))];
  $code .= $r;
}

$var = array("code" => $code);

echo json_encode($var);


?>

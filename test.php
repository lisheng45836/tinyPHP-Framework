<?php


$arr = array('controller' => 'Home', 'action' => 'index');
foreach ($arr as $key => $value) {
    echo "Key: $key; Value: $value<br />\n";
}


foreach ($arr as $value) {
	echo "Value : $value \n";
}
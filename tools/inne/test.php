<?php

$handle = @fopen("test2.csv", "r");
$i=1;
$currentDate=date('Y-m-d H:i:s');


if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $line=explode("^",$buffer);
        
        echo "########## $line[26]: \n";
        #preg_match('/^.*?([0-9]{2,}).*\( *PG *([0-9])/',$line[26],$matches);
        preg_match('/\( *PG *([0-9]) *\)/',$line[26],$matches);
        #var_dump($matches);
        var_dump($matches);
    }
}




?>

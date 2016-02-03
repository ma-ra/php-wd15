<?php

$handle = @fopen("stoff.txt", "r");

#wzory napisów do usunięcia z nazwy
$usun=array("anthrazit",
        "BL Olive",
        "BL Rot",
        "BL Schwarz",
        "Grau / -anthrazit",
        "Grau / beige",
        "grau / weiss",
        "Grau / weiss",
        "grau",
        "Grey",
        "Hell-beige",
        "Kissen grau",
        "Kissen rot",
        "Kissen schwarz / blau",
        "KL Braun",
        "KL Grau",
        "KL grün",
        "KL Mocca",
        "KL Rot",
        "Kl schwarz",
        "KL Schwarz",
        "KL uni taupe",
        "KL uni weiss",
        "KL Weiss",
        "Musterring Exclusiv!",
        "Rot / anthrazit",
        "Schlamm",
        "schwarz grau",
        "Schwarz",
        "Uni Anthrazit",
        "Uni beige",
        "Uni Blau",
        "Uni creme",
        "Uni Dunkelbraun",
        "Uni Dunkelgrau",
        "Uni Dunkelrot",
        "Uni Gelbgrün",
        "Uni Grau",
        "Uni Grau/Schwarz",
        "Uni Hellbeige",
        "Uni Hellbraun",
        "Uni Hellgrau",
        "Uni Mausgrau",
        "Uni Petrol",
        "Uni Pistazie",
        "Uni Schwarz",
        "Uni Schwarz-Weiss",
        "Uni Taupe",
        "Uni WW",
        "Uni Ziegelrot",
        "weiss grau",
        "2Weiss-Grau",
        "Echtleder beige",
        "Echtleder dunkelbraun",
        "Echtleder hellbraun",
        "Echtleder rot",
        "Ersatzlieferant",
        "beige grau",
        "beige",
        "Blau",
        "Braun / beige",
        "Braun",
        "Druckstoff",
        "Espresso"
);

if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $line=$buffer;
        
        #regexp dla numeru mat
        $regNrMat='(^ *[0-9]+)';
        
        #regexp dla nazw materiałów
        $regNazwaMat="(.*)";

        #regexp dla dostawcy
        $dostawcy=array("S.I.C.","Vinteks","Aksa Global","Lech","Furnitex","Höpke","Froca","Davis","Carina","Eurotex","Textum","Globatex","Anabell","Mabor Polen");
        $regDostawcy="(";
        foreach ($dostawcy as $dostawca) {
            $regDostawcy=$regDostawcy . "(" . $dostawca . ")|";
        }
        $regDostawcy=substr($regDostawcy,0,-1) . ")";
        
        #regexp dla nieznanego pola
        $regNieznane="(( *[0-9]+)| *(Leder))";
        
        #regexp dla grupy cenowej
        $regGrupaCenMat="(( *[0-9]+)| *(Leder))";
        
        #regexp dla ceny
        $regCenaMat="( [0-9,\,]+)";
        
        #regexp
        $regexp="/$regNrMat$regNazwaMat$regDostawcy$regNieznane$regGrupaCenMat$regCenaMat/";

        preg_match($regexp,$line,$matches);
#        echo $line . "\n";
#        echo $regexp . "\n";
#        var_dump($matches);


        #usówanie wzorca z nazwy
        foreach ($usun as $value) {
            isset($matches[2])? $matches[2]=str_replace($value, "", $matches[2]): true;
        }

        #podmiana dostawcy na numerek
        $supplier=array(
            "S.I.C." => 1,
            "Aksa Global" => 2,
            "Höpke" => 3,
            "Froca" => 4,
            "Davis" => 5,
            "Carina" => 6,
            "Eurotex" => 7,
            "Textum" => 8,
            "Anabell" => 9,
            "Globatex" => 10,
            "Mabor Polen" => 11,
            "Furnitex" => 12,
            "Vinteks" => 13,
            "Lech" => 14,
        );


        #drukowanie
        echo isset($matches[1]) ? trim($matches[1]) : " ";
        echo "^";
        echo isset($matches[2]) ? trim($matches[2]) : " ";
        echo "^";
        echo isset($matches[3]) ? $supplier[trim($matches[3])] : " ";
#        echo "^";
#        echo isset($matches[18]) ? trim($matches[18]) : " ";
        echo "^";
        echo isset($matches[21]) ? trim(str_replace("00", "", $matches[21])) : " ";
        echo "^";
        echo isset($matches[24]) ? trim(str_replace(",", ".", $matches[24])) : " ";

        echo "\n";
    }
}




?>


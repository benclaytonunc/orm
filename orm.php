<?php
function main() {
    echo "in main";
    echo "<br>";
  }
main();
require_once("CreateClass.php");
$classMaker = new CreateClass();

require_once('pest.php');
//this creates a rest client
$pest = new Pest('http://appthero.me/index.php');


function getTableNames($pest) {
    $jsonResponse = $pest->get('/tables/list');
    $tableArray = json_decode($jsonResponse,true);
    $tableName = array();
    for($b=0; $b <sizeof($tableArray); $b++) {
        array_push($tableName, $tableArray[$b]["table_name"]);
    }
    print_r($tableName);
    return($tableName);
    
  #  echo $pest;
}
echo getTableNames($pest);

function getColumnsForTable($pest, $tableName) {
    $jsonResponse2 = $pest->get("/columns/list/$tableName");
    $tableArray2 = json_decode($jsonResponse2,true);
    $colName = array();
    for($a=0; $a <sizeof($tableArray2); $a++) {
        array_push($colName, $tableArray2[$a]["COLUMN_NAME"]);
    }
    print_r($colName);
    return($colName);

}
echo "<br>";
#echo getColumnsForTable($pest, "appointment");
#require_once PROJECT_ROOT_PATH."/Model";
$tableList = getTableNames($pest);

foreach($tableList as $a) {
    $aFile = fopen("Comp421_Spring2022/appointmentsAPI/Model/".$a."Model.php","w") or die("Unable to open file!");
    $concat = '<?php'.$classMaker->createClassHeader($a."Model");
    $columnList = getColumnsForTable($pest, $a);
    foreach($columnList as $l) {
        $concat = $concat.$classMaker->createProperty($l);
        $concat = $concat.$classMaker->createGetter($l);
        $concat = $concat.$classMaker->createSetter($l);
    }
    $concat = $concat.$classMaker->createEndOfClass(). '?>';
    echo "$concat <br>";
    fwrite($aFile, $concat);
    fclose($aFile);
}

require_once("CreateServiceClass.php");
$ServClassMaker = new CreateServiceClass();

foreach($tableList as $a) {
    $aFile = fopen("Comp421_Spring2022/appointmentsAPI/Service/".$a."Service.php","w") or die("Unable to open file!");
    $concat = '<?php'.$ServClassMaker->s_createClassHeader($a."Service");
    $columnList = getColumnsForTable($pest, $a);
    $primaryKey = "PK";
    $concat = $concat.$ServClassMaker->s_createGetAllMethod($a);
    $concat = $concat.$ServClassMaker->s_createGet($a, $primaryKey);
    $concat = $concat.$ServClassMaker->S_createEndOfClass(). '?>';
    echo "$concat <br>";
    fwrite($aFile, $concat);
    fclose($aFile);
}
/*
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);
for($b = 0; $b <= 5; $b++){

}

//$myfile = fopen("")
*/

?>
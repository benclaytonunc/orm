<?php
class createClass{
function createClassHeader($className) {
    $baseHeader = "\nclass $className {\n";
    return $baseHeader;
}
function createProperty($propertyName){
    $baseProperty = "private $$propertyName; \n";
    return $baseProperty;
}
function createGetter($propertyName){
    $newthis = "this";
    $baseGetter = "public function get$propertyName(){ return $$newthis->$$propertyName; }\n" ;
    return $baseGetter;
}
function createSetter($propertyName){
    $newthis = "this";
    $baseSetter = "public function set$propertyName(){ $$newthis->$$propertyName = $propertyName; }\n" ;
    return $baseSetter;
}
function createEndOfClass(){
    return "}\n";
}
}

$appointment = new CreateClass();
echo $appointment->createClassHeader("Appointments");
echo "<br>";
echo $appointment->createProperty("companyId");
echo "<br>";
echo $appointment->createGetter("companyId");
echo "<br>";
echo $appointment->createSetter("AppointmentId");
echo "<br>";
echo $appointment->createEndOfClass();

?>

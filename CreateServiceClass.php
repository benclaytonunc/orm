<?php 
class CreateServiceClass {
    function s_createClassHeader($className) {
        $baseHeader = "\nclass $className extends Database {\n";
        return $baseHeader;
    }
    
    function s_createGetAllMethod($className) {
        $ts = "this->select";
        $rows = "rows";
        $baseGetter = "public function get$className(){ $$rows = $$ts('SELECT * FROM $className');\nreturn $$rows; }\n" ;
        return $baseGetter;
    }
    function s_createGet($className, $primaryKey) {
        $ts = "this->select";
        $rows = "rows";
        $id = "id";
        $classNameId = $className.'Id';
        $baseCreateGet = "public function get$className($$id){ $$rows = $$ts('SELECT * FROM $className WHERE $classNameId = ?',['i',$$id]);\nreturn $$rows; }\n" ;
        return $baseCreateGet;
    }
    function s_createEndOfClass(){
        return "}\n";
    } 
}
$service = new CreateServiceClass();
echo $service->s_createClassHeader("Companies");
echo $service->s_createGetAllMethod("Companies");
echo $service->s_createGet("Companies", "PK");
echo $service->s_createEndOfClass();
?>
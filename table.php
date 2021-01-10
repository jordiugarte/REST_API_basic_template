
<?php

require_once "class/response.php";
require_once "class/table.php";
require_once "class/optionUrl.php";

$_response = new response;
$_table = new table;
$optionUrl = new  optionUrl;

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if(isset($_GET["id"])){
        $tableId = $_GET['id'];
        $dataTable = $_table->getTable($tableId);
        $optionUrl->resDataGet($dataTable);
    }else if (isset($_GET['cartilla'])){
        $cartillaId=$_GET['cartilla'];
        $dataTable=$_table->getTableCartilla($cartillaId);
        $optionUrl->resDataGet($dataTable);
    }else{
        $dataTable = $_table->listTables();
        $optionUrl->resDataGet($dataTable);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postBody=$optionUrl->getDataURL();
    $dataArray = $_table->store($postBody);
    $optionUrl->resDataPOST($dataArray);

} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $postBody=$optionUrl->getDataURL();
    $dataArray=$_table->update($postBody);
    $optionUrl->resDataPOST($dataArray);

} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $postBody=$optionUrl->getDataURL();
    $dataArray = $_table->delete($postBody);
    $optionUrl->resDataPOST($dataArray);

} else {
    $optionUrl->reqUnk();
}

?>
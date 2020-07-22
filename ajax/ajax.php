<?require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';?>
<?
if(!CModule::IncludeModule("iblock"))
    return;

$res = CIBlockElement::GetByID($_REQUEST['id'])->fetch();
$response = array();
if($res['ID']){
    if(CIBlockElement::delete($res['ID'])){
        $response['status'] = "success";
    } else {
        $response['status'] = "error";
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>

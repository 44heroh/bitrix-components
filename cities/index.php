<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Города");
?>
<?$APPLICATION->IncludeComponent(
    "test:complex.component",
    ".default",
    array(
        'IBLOCK_TYPE' => "references",
        'IBLOCK_ID' => 4,
        "SEF_FOLDER" => "/cities/",
        "SEF_MODE" => "Y",
        "SET_STATUS_404" => "Y",
        "COMPONENT_TEMPLATE" => ".default",
        'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "Y",
        'NEWS_COUNT' => 20,
        // Элементы в разделах
        /*"SEF_URL_TEMPLATES" => array(
            "list" => "",
            "detail" => "#SECTION_CODE#/#ELEMENT_CODE#/",
            "section" => "#SECTION_CODE#/",
        ),*/
        // Элементы без разделов
        "SEF_URL_TEMPLATES" => array(
            "list" => "",
            "detail" => "#ELEMENT_CODE#/",
//            "section" => "#SECTION_CODE#/",
        )
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
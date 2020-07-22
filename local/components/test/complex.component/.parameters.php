<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
    return;
$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock=array();
$rsIBlock = CIBlock::GetList(Array("SORT" => "ASC"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
{
    $arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arSorts = Array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = Array(
    "ID"=>GetMessage("T_IBLOCK_DESC_FID"),
    "NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
    "ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
    "SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
    "TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
    {
        $arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

$arUGroupsEx = Array();
$dbUGroups = CGroup::GetList($by = "c_sort", $order = "asc");
while($arUGroups = $dbUGroups -> Fetch())
{
    $arUGroupsEx[$arUGroups["ID"]] = $arUGroups["NAME"];
}

$arComponentParameters = array(
	"PARAMETERS" => array(
        "SET_STATUS_404" => Array(
	        "PARENT" => "ADDITIONAL_SETTINGS",
	        "NAME" => GetMessage("CATALOG_STATUS_404"),
	        "TYPE" => "CHECKBOX",
	        "DEFAULT" => "N",
        ),
        "VARIABLE_ALIASES" => Array(
            "ELEMENT_ID" => Array("NAME" => GetMessage("CATALOG_SECTION_ELEMENT_ID")),
            "ELEMENT_CODE" => Array("NAME" => GetMessage("CATALOG_SECTION_ELEMENT_CODE")),
            "SUB_ELEMENT_ID" => Array("NAME" => GetMessage("CATALOG_SUB_SECTION_ELEMENT_ID")),
            "SUB_ELEMENT_CODE" => Array("NAME" => GetMessage("CATALOG_SUB_SECTION_ELEMENT_CODE")),
        ),
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "NEWS_COUNT" => Array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_IBLOCK_DESC_LIST_CONT"),
            "TYPE" => "STRING",
            "DEFAULT" => "20",
        ),
		"SEF_MODE" => Array(
			"list" => array(
				"NAME" => GetMessage("CATALOG_SECTION_INDEX_NAME"),
				"DEFAULT" => "",
				"VARIABLES" => array(""),
			),
			"detail" => array(
				"NAME" => GetMessage("CATALOG_DETAIL_NAME"),
				"DEFAULT" => "#ELEMENT_CODE#/",
				"VARIABLES" => array("ID"),
			),
            "section" => array(
                "NAME" => GetMessage("CATALOG_SECTION_DETAIL_NAME"),
                "DEFAULT" => "#SECTION_CODE#/",
                "VARIABLES" => array("SECTION_ID"),
            )
		),
	),
);
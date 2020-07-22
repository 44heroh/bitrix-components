<?

use \Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class ListD7 extends CBitrixComponent
{

    /**
     * подключает языковые файлы
     */

    public function onIncludeComponentLang()
    {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    /**
     * Обработка входных параметров
     *
     * @param mixed[] $arParams
     * @return mixed[] $arParams
     */

    public function onPrepareComponentParams($arParams)
    {
        // время кэширования

        $arParams["CACHE_TIME"] = (int) $arParams["CACHE_TIME"];
        $arParams["IBLOCK_ID"] = (int) $arParams["IBLOCK_ID"];
        $arParams["IBLOCK_TYPE"] = (string) $arParams["IBLOCK_TYPE"];
        $arParams["NEWS_COUNT"] = (int) $arParams["NEWS_COUNT"];
        $arParams['DETAIL_URL'] = (string) $arParams['DETAIL_URL'];

        return $arParams;
    }



    /**
     * получение результатов
     *
     * @return void
     */

    protected function getResult($arParams)
    {
        $arResult = array();

        \Bitrix\Main\Loader::includeModule('iblock');
        $arSelect = array("ID", "NAME", "CODE", "IBLOCK_ID", "PREVIEW_TEXT");
        $arFilter = array("IBLOCK_ID"=>IntVal($arParams['IBLOCK_ID']), "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>$arParams['NEWS_COUNT']), $arSelect);
        $res->NavStart($arParams['NEWS_COUNT']);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $arFields["DETAIL_PAGE_URL"] = str_replace("#ELEMENT_CODE#", $arFields["CODE"], $arParams["DETAIL_URL"]);
            $arResult['ITEMS'][] = $arFields;
        }
        $arResult['NAV'] = $res;

        return $arResult;
    }


    /**
     * выполняет логику работы компонента
     *
     * @return void
     */

    public function executeComponent()
    {
        try
        {
            global $USER;
            global $APPLICATION;

            $arParams["CACHE_TIME"] = IntVal($this->$arParams["CACHE_TIME"]);
            $CACHE_ID = SITE_ID."|".$APPLICATION->GetCurPage()."|";
            // Кеш зависит только от подготовленных параметров без "~"
            foreach ($this->arParams as $k => $v)
                if (strncmp("~", $k, 1))
                    $CACHE_ID .= ",".$k."=".$v;
            $CACHE_ID .= "|".$USER->GetGroups();

            $cache = new CPHPCache;
            if ($cache->StartDataCache($arParams["CACHE_TIME"], $CACHE_ID, "/".SITE_ID.$this->GetRelativePath()))
            {
                // Запрос данных и формирование массива $arResult
                $this->arResult = $this->getResult($this->arParams);

                // Подключение шаблона компонента
                $this->IncludeComponentTemplate();

                $this->templateCachedData = $this->GetTemplateCachedData();

                $cache->EndDataCache(
                    array(
                        "arResult" => $this->arResult,
                        "templateCachedData" => $this->templateCachedData
                    )
                );
            }
            else
            {
                extract($cache->GetVars());
                $this->SetTemplateCachedData($templateCachedData);
            }

        }
        catch (Exception $e)
        {
            ShowError($e->getMessage());
        }
    }
}
?>
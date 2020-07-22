<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div class="row">
    <?foreach($arResult['ITEMS'] as $key => $arItem){?>
        <div class="col-12">
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
            <a href="javascript:void(0);" class="js-delete" data-id="<?=$arItem["ID"]?>">x</a>
        </div>
    <? }?>
    <div class="col-12">
        <?
        $navStr = $arResult['NAV']->GetPageNavStringEx($navComponentObject, "Страницы:", "round");
        echo $navStr;
        ?>
    </div>
</div>

<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;

/**
 * @var string $mid
 */

Loc::loadMessages(__FILE__);

$request = Application::getInstance()->getContext()->getRequest();

$aTabs = [];
$aTabs[] = [
	'DIV' => 'imyie_tab_settings',
	'TAB' => Loc::getMessage('IMYIE_TAB_NAME'),
	'ICON' => '',
	'TITLE' => Loc::getMessage('IMYIE_TAB_TITLE'),
];

$arAllOptions = [];

/************************ tab ***************************/
$arAllOptions['imyie_tab_settings'][] = [
	'token',
	Loc::getMessage('IMYIE_OPTIONS_TOKEN'),
	null,
	['text']
];

/************************ tab ***************************/

// $request->getQuery('save')
// $request->getQuery('apply')
if (
	(isset($_REQUEST['save']) || isset($_REQUEST['apply']))
	&& check_bitrix_sessid()
) {
	__AdmSettingsSaveOptions($mid, $arAllOptions['imyie_tab_settings']);

    LocalRedirect('settings.php?mid='.$mid.'&lang='.LANG);
}

$tabControl = new CAdminTabControl('tabControl', $aTabs);

?><form method="post" action="<?=$APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?=LANGUAGE_ID?>" name="imyie_postcoder_settings"><?
	echo bitrix_sessid_post();

	$tabControl->Begin();

	$tabControl->BeginNextTab();
	__AdmSettingsDrawList($mid, $arAllOptions['imyie_tab_settings']);

	$tabControl->Buttons([]);
	$tabControl->End();

?></form>

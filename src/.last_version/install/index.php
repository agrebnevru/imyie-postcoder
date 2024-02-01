<?php

use Bitrix\Main\Application;
use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

class imyie_postcoder extends CModule {

    var $MODULE_ID = 'imyie.postcoder';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = 'Y';

    public function imyie_postcoder() {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

        $this->MODULE_NAME = GetMessage('IMYIE_POSTCODER_INSTALL_NAME');
		$this->MODULE_DESCRIPTION = GetMessage('IMYIE_POSTCODER_INSTALL_DESCRIPTION');
		$this->PARTNER_NAME = GetMessage('IMYIE_POSTCODER_INSTALL_COPMPANY_NAME');
        $this->PARTNER_URI  = 'https://agrebnev.ru/';
    }

	function InstallDB($install_wizard = true)
	{
		ModuleManager::registerModule($this->MODULE_ID);

		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		ModuleManager::unregisterModule($this->MODULE_ID);

		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles()
	{
		return true;
	}

	function InstallPublic()
	{
        return true;
	}

	function InstallOptions()
	{
        return true;
	}

	function UnInstallFiles()
	{
		return true;
	}

	function DoInstall()
	{
		global $APPLICATION, $step;

		$this->InstallFiles();
		$this->InstallDB(false);
		$this->InstallEvents();
		$this->InstallPublic();

		return true;
	}

	function DoUninstall()
	{
		global $APPLICATION, $step;

		$this->UnInstallDB();
		$this->UnInstallFiles();
		$this->UnInstallEvents();

		return true;
	}
}

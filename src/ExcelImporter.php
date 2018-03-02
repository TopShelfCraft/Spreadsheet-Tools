<?php
namespace topshelfcraft\excelimporter;

use Craft;
use craft\base\Plugin;
use topshelfcraft\excelimporter\models\SettingsModel;
use topshelfcraft\excelimporter\services\HelperService;
use topshelfcraft\excelimporter\services\SpreadsheetService;
use craft\console\Application as ConsoleApplication;

/**
 * @property SettingsModel $settings
 * @property HelperService $helper
 * @property SpreadsheetService $spreadsheet
 */
class ExcelImporter extends Plugin
{

	/**
	 * @var ExcelImporter $plugin
	 */
	public static $plugin;

	/**
	 *
	 */
	public function init()
	{

		parent::init();

		self::$plugin = $this;

		if (Craft::$app instanceof ConsoleApplication) {
			$this->controllerNamespace = 'topshelfcraft\excelimport\console\controllers';
		}

	}

	/**
	 * Create the settings model
	 *
	 * @return SettingsModel
	 * @throws \Exception
	 */
	protected function createSettingsModel(): SettingsModel
	{

		$settingsModel = new SettingsModel();

		$storagePath = Craft::$app->path->getStoragePath() . '/excel-importer';
		$settingsModel->xlsUploadPath = $storagePath;

		return $settingsModel;

	}

}

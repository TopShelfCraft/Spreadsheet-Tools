<?php
namespace topshelfcraft\spreadsheet;

use Craft;
use craft\base\Plugin;
use topshelfcraft\spreadsheet\console\controllers\WalkController;
use topshelfcraft\spreadsheet\models\SettingsModel;
use topshelfcraft\spreadsheet\services\HelperService;
use topshelfcraft\spreadsheet\services\SpreadsheetService;
use craft\console\Application as ConsoleApplication;

/**
 * @property SettingsModel $settings
 * @property HelperService $helper
 * @property SpreadsheetService $spreadsheet
 */
class Spreadsheet extends Plugin
{

	/**
	 * @var Spreadsheet $plugin
	 */
	public static $plugin;

	/**
	 *
	 */
	public function init()
	{

		parent::init();

		self::$plugin = $this;

		if (Craft::$app instanceof ConsoleApplication)
		{
//			Craft::$app->controllerNamespace = 'topshelfcraft\\excelimporter\\console\\controllers';
			Craft::$app->controllerMap['excel'] = WalkController::class;
		}

//		// Handle any console commands
//		if (Craft::$app instanceof ConsoleApplication) {
//			$this->controllerNamespace = 'topshelfcraft\\excelimporter\\console\\controllers';
//		}

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

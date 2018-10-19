<?php
namespace topshelfcraft\spreadsheettools;

use Craft;
use craft\base\Plugin;
use topshelfcraft\spreadsheettools\console\controllers\WalkController;
use topshelfcraft\spreadsheettools\models\SettingsModel;
use topshelfcraft\spreadsheettools\services\HelperService;
use topshelfcraft\spreadsheettools\services\SpreadsheetService;
use craft\console\Application as ConsoleApplication;

/**
 * Toolkit for reading, writing, and processing spreadsheet data
 *
 * @property SettingsModel $settings
 * @property HelperService $helper
 * @property SpreadsheetService $spreadsheet
 */
class SpreadsheetTools extends Plugin
{

	/**
	 * @var SpreadsheetTools $plugin
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
//			$this->controllerNamespace = 'topshelfcraft\\spreadsheettools\\console\\controllers';
			Craft::$app->controllerMap['spreadsheet-tools'] = WalkController::class;
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

		$storagePath = Craft::$app->path->getStoragePath() . '/spreadsheet-tools';
		$settingsModel->xlsUploadPath = $storagePath;

		return $settingsModel;

	}

}

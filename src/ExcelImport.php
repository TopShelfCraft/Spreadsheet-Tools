<?php

namespace topshelfcraft\excelimport;

use Craft;
use craft\base\Plugin;
use Symfony\Component\Filesystem\Filesystem;
use topshelfcraft\excelimport\models\SettingsModel;
use topshelfcraft\excelimport\services\HelperService;
use topshelfcraft\excelimport\services\SpreadsheetService;

/**
 * Class ExcelImport
 * @property SettingsModel $settings
 * @property HelperService $helperService
 * @property SpreadsheetService $spreadsheetService
 */
class ExcelImport extends Plugin
{
    /** @var ExcelImport $plugin */
    public static $plugin;

    /**
     * Initialize plugin
     */
    public function init()
    {
        // Make sure parent init functionality runs
        parent::init();

        // Save an instance of this plugin for easy reference throughout app
        self::$plugin = $this;
    }

    /**
     * Create the settings model
     * @return SettingsModel
     * @throws \Exception
     */
    protected function createSettingsModel() : SettingsModel
    {
        // Create a settings model
        $settingsModel = new SettingsModel();

        // Set the storage path
        $storagePath = Craft::$app->path->getStoragePath() . '/excel-import';
        $settingsModel->xlsUploadPath = $storagePath;

        // Return the settings model
        return $settingsModel;
    }

    /**
     * Get the helper service
     * @return HelperService
     */
    public function getHelperService() : HelperService
    {
        // Return service with dependencies injected
        return new HelperService([
            'settings' => $this->settings,
        ]);
    }

    /**
     * Get spreadsheet service
     * @return SpreadsheetService
     */
    public function getSpreadsheetService() : SpreadsheetService
    {
        return new SpreadsheetService();
    }
}

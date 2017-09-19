<?php

namespace topshelfcraft\excelimport\services;

use Symfony\Component\Filesystem\Filesystem;
use topshelfcraft\excelimport\models\SettingsModel;

/**
 * Class HelperService
 * @property array $validImportTypes
 * @property array $validImportTypeKeys
 * @property array $validSpreadsheetMimes
 * @property string $spreadsheetUploadPath
 */
class HelperService extends BaseService
{
    /** @var SettingsModel $settings */
    protected $settings;

    /**
     * Get the valid import types from the config
     * @return array
     */
    public function getValidImportTypes() : array
    {
        return (array) $this->settings->validImportTypes;
    }

    /**
     * Get the array keys for the valid import types
     * @return array
     */
    public function getValidImportTypeKeys() : array
    {
        return array_keys($this->getValidImportTypes());
    }

    /**
     * Determine if a string is a valid import type key.
     * @param $importType
     * @return bool
     */
    public function isValidImportType($importType) : bool
    {
        return in_array($importType, $this->getValidImportTypeKeys(), false);
    }

    /**
     * Get the spreadsheet mime types from the config.
     * @return array
     */
    public function getValidSpreadsheetMimes() : array
    {
        return (array) $this->settings->validUploadMimes;
    }

    /**
     * Determine if a string is a valid spreadsheet mime type.
     * @param $mimeType
     * @return bool
     */
    public function isValidSpreadsheetMime($mimeType) : bool
    {
        return in_array($mimeType, $this->getValidSpreadsheetMimes(), false);
    }

    /**
     * Get the spreadsheet upload path.
     * @param string $filename
     * @return mixed
     */
    public function getSpreadsheetUploadPath($filename = '')
    {
        return '/' .
            trim($this->settings->xlsUploadPath, '/') .
            '/' .
            trim($filename, '/');
    }

    /**
     * Check if the spreadsheet exists.
     * @param string $filename
     * @return bool
     */
    public function doesSpreadsheetExist($filename = '') : bool
    {
        return (new Filesystem())->exists(
            $this->getSpreadsheetUploadPath($filename)
        );
    }
}

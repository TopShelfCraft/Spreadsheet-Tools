<?php
namespace topshelfcraft\spreadsheettools\services;

use Symfony\Component\Filesystem\Filesystem;
use topshelfcraft\spreadsheettools\SpreadsheetTools;
use topshelfcraft\spreadsheettools\models\SettingsModel;

/**
 * @property array $validImportTypes
 * @property array $validImportTypeKeys
 * @property array $validSpreadsheetMimes
 * @property string $spreadsheetUploadPath
 */
class HelperService extends BaseService
{

	/**
	 * @var SettingsModel $settings
	 */
	protected $settings;

	/**
	 * Initializes this service with the plugin settings already injected.
	 */
	public function init()
	{
		parent::init([
			'settings' => SpreadsheetTools::$plugin->getSettings()
		]);
	}

	/**
	 * Get the valid import types from the config
	 *
	 * @return array
	 */
	public function getValidImportTypes(): array
	{
		return (array)$this->settings->validImportTypes;
	}

	/**
	 * Get the array keys for the valid import types
	 *
	 * @return array
	 */
	public function getValidImportTypeKeys(): array
	{
		return array_keys($this->getValidImportTypes());
	}

	/**
	 * Determine if a string is a valid import type key.
	 *
	 * @param $importType
	 * @return bool
	 */
	public function isValidImportType($importType): bool
	{
		return in_array($importType, $this->getValidImportTypeKeys(), false);
	}

	/**
	 * Get the spreadsheet mime types from the config.
	 *
	 * @return array
	 */
	public function getValidSpreadsheetMimes(): array
	{
		return (array)$this->settings->validUploadMimes;
	}

	/**
	 * Determine if a string is a valid spreadsheet mime type.
	 *
	 * @param $mimeType
	 * @return bool
	 */
	public function isValidSpreadsheetMime($mimeType): bool
	{
		return in_array($mimeType, $this->getValidSpreadsheetMimes(), false);
	}

	/**
	 * Get the spreadsheet upload path.
	 *
	 * @param string $filename
	 * @return mixed
	 * @throws \Exception
	 */
	public function getSpreadsheetUploadPath($filename = '')
	{

		// Normalize the path
		$path = '/' . trim($this->settings->xlsUploadPath, '/') . '/';

		// Make sure that directory exists
		(new Filesystem())->mkdir($path);

		// Return the path anf filename put together
		return $path . trim($filename, '/');

	}

	/**
	 * Check if the spreadsheet exists.
	 *
	 * @param string $filename
	 * @return bool
	 * @throws \Exception
	 */
	public function doesSpreadsheetExist($filename = ''): bool
	{
		return (new Filesystem())->exists(
			$this->getSpreadsheetUploadPath($filename)
		);
	}

}

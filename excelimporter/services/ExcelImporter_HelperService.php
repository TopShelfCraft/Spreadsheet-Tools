<?php
namespace Craft;

class ExcelImporter_HelperService extends BaseApplicationComponent
{
	/**
	 * Get the valid import types from the config
	 *
	 * @return array
	 */
	public function getValidImportTypes()
	{
		return (array) craft()->config->get('validImportTypes', 'excelimporter');
	}

	/**
	 * Get the array keys for the valid import types
	 *
	 * @return array
	 */
	public function getValidImportTypeKeys()
	{
		return array_keys( $this->getValidImportTypes() );
	}

	/**
	 * Determine if a string is a valid import type key.
	 *
	 * @param $importType
	 * @return bool
	 */
	public function isValidImportType( $importType )
	{
		return in_array($importType, $this->getValidImportTypeKeys());
	}

	/**
	 * Get the spreadsheet mime types from the config.
	 *
	 * @return mixed
	 */
	public function getValidSpreadsheetMimes()
	{
		return craft()->config->get('validUploadMimes', 'excelimporter');
	}

	/**
	 * Determine if a string is a valid spreadsheet mime type.
	 *
	 * @param $mimeType
	 * @return bool
	 */
	public function isValidSpreadsheetMime( $mimeType )
	{
		return in_array($mimeType, $this->getValidSpreadsheetMimes() );
	}

	/**
	 * Get the spreadsheet upload path.
	 *
	 * @return mixed
	 */
	public function getSpreadsheetUploadPath( $filename = '' )
	{
		return craft()->config->get('xlsUploadPath', 'excelimporter') . trim($filename, '/');
	}

	/**
	 * Check if the spreadsheet exists.
	 *
	 * @param string $filename
	 * @return bool
	 */
	public function doesSpreadsheetExist( $filename = '' )
	{
		if ( empty($filename) || ! IOHelper::fileExists( $this->getSpreadsheetUploadPath( $filename ) ) )
		{
			return false;
		}
		return true;
	}
}
<?php
namespace topshelfcraft\spreadsheettools\models;

use craft\base\Model;

/**
 * Class SettingsModel
 */
class SettingsModel extends Model
{

	/**
	 * @var array $validImportTypes
	 */
	public $validImportTypes = [];

	/**
	 * @var array $validImportTypes
	 */
	public $validUploadMimes = [
		'application/vnd.ms-excel',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	];

	/**
	 * @var string $xlsUploadPath
	 */
	public $xlsUploadPath = '';

}

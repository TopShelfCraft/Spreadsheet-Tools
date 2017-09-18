<?php
namespace Craft;

class ExcelImporter_SpreadsheetService extends BaseApplicationComponent
{

	public function parseFile($file)
	{
		require_once craft()->path->getPluginsPath().'excelimporter/vendor/autoload.php';

		//identify the type of $inputFileName
		$inputFileType = \PHPExcel_IOFactory::identify($file);

		//create a new Reader of the type that has been identified
		$objReader = \PHPExcel_IOFactory::createReader($inputFileType);

		//advise the Reader that we only want to load cell data
		$objReader->setReadDataOnly(true);

		//load $inputFileName to a PHPExcel Object
		$objPHPExcel = $objReader->load($file);

		//return the sheet data as an array
		return $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	}

}

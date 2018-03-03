<?php
namespace topshelfcraft\spreadsheet\services;

use PHPExcel_IOFactory;

class SpreadsheetService extends BaseService
{

	/**
	 * Parses a supplied file and returns its data as an array of rows.
	 *
	 * @param string $file
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function parseFile($file): array
	{

		// Create a new Reader of the type that has been identified
		$objReader = PHPExcel_IOFactory::createReader(
			PHPExcel_IOFactory::identify($file)
		);

		// Advise the Reader that we only want to load cell data
		$objReader->setReadDataOnly(true);

		// Load $inputFileName to a PHPExcel Object
		$objPHPExcel = $objReader->load($file);

		// Return the sheet data as an array
		return $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

	}

	/**
	 * Walks the parsed spreadsheet rows, passing the data from each into a specified method.
	 *
	 * @param string $file
	 * @param callable $callable
	 * @param mixed $userData
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function walkRows(string $file, callable $callable, $userData = null): bool
	{
		$array = $this->parseFile($file);
		return array_walk($array, $callable, $userData);
	}

}

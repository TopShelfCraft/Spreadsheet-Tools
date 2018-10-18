<?php
namespace topshelfcraft\spreadsheettools\services;

use PhpOffice\PhpSpreadsheet\IOFactory;

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
	public function getRows(string $file, $readDataOnly = true): array
	{

		$reader = IOFactory::createReaderForFile($file);
		$reader->setReadDataOnly($readDataOnly);
		$spreadsheet = $reader->load($file);

		// Return the sheet data as an array
		return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

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
		$array = $this->getRows($file);
		return array_walk($array, $callable, $userData);
	}

}

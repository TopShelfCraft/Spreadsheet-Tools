<?php
namespace topshelfcraft\spreadsheet\helpers;

class SpreadsheetHelper
{

	public static function getDataKeyedByHeaderRow($array, $rename = [])
	{

		$data = $array;
		$header = array_shift($data);

		foreach ($data as $rowKey => $row) {

			$data[$rowKey] = [];

			foreach ($row as $k => $v)
			{

				$data[$rowKey][$header[$k]] = $v;

				if (!empty($header[$k]))
				{
					$data[$rowKey][$header[$k]] = $v;
				}

			}

		}

		// TODO: Implement custom key renaming from $rename

		return $data;

	}

}

<?php
namespace topshelfcraft\spreadsheettools\demo;

class Console
{

	/**
	 *
	 */
	public function log($data)
	{

		\craft\helpers\Console::output(print_r($data, true));

	}

}

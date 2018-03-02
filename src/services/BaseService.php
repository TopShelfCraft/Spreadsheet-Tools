<?php
namespace topshelfcraft\excelimporter\services;

use craft\base\Component;

abstract class BaseService extends Component
{

	/**
	 * @param array $config
	 */
	public function __construct(array $config = [])
	{

		parent::__construct();

		foreach ($config as $key => $val) {
			$this->{$key} = $val;
		}

	}

}

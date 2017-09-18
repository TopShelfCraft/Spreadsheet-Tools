<?php
namespace Craft;

class ExcelImporterPlugin extends BasePlugin
{

	public function getName()
	{
		return Craft::t('Excel Importer');
	}

	public function getVersion()
	{
		return '0.0.1';
	}

	public function getDeveloper()
	{
		return 'Aaron Waldon';
	}

	public function getDeveloperUrl()
	{
		return 'http://causingeffect.com/';
	}

	public function hasCpSection()
	{
		return false;
	}

}
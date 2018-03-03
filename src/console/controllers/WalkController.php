<?php
namespace topshelfcraft\spreadsheet\console\controllers;

use Symfony\Component\Filesystem\Filesystem;
use topshelfcraft\spreadsheet\Spreadsheet;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Read, write, and process spreadsheet data
 *
 * @package topshelfcraft\spreadsheet\console\controllers
 */
class WalkController extends Controller
{


	/*
	 * Public properties
	 */


	/**
	 * @var string $defaultAction
	 */
	public $defaultAction = 'rows';

	/**
	 * @var string $file
	 */
	public $file = null;

	/** @var string $class
	 */
	public $class = null;

	/**
	 * @var string $method
	 */
	public $method = null;


	/*
	 * Public methods
	 */


	/**
	 * @inheritdoc
	 */
	public function options($actionId): array
	{
		$options = parent::options($actionId);
		$options[] = 'file';
		$options[] = 'class';
		$options[] = 'method';
		return $options;
	}

	/**
	 * Walks the parsed spreadsheet rows, passing the data from each into a specified method.
	 *
	 * @throws \Exception
	 */
	public function actionRows()
	{

		// Make sure our parameters have been defined...

		$errors = false;

		if ($this->file === null)
		{
			$this->_writeErr('--file=/path/to/spreadsheet/file is required.');
			$errors = true;
		}

		if ($this->class === null)
		{
			$this->_writeErr('--class=my.custom.class is required.');
			$errors = true;
		}

		if ($this->method === null)
		{
			$this->_writeErr('--method=myMethod is required.');
			$errors = true;
		}

		if ($errors)
		{
			return;
		}

		// Get filesystem class
		$fs = new Filesystem();

		// Make sure the file path exists
		if (!$fs->exists($this->file))
		{
			$this->_writeErr('The specified source file does not exist.');
			$errors = true;
		}

		// Get our class
		$class = null;

		$qualifiedClass = '\\' . str_replace('.', '\\', $this->class);

		// If the class exists, instantiate it.
		if (class_exists($qualifiedClass))
		{
			$class = $qualifiedClass;
			$class = new $class;
		}

		// Make sure the class exists.
		if (!$class)
		{
			$this->_writeErr('The specified class does not exist.');
			$errors = true;
		}

		// Make sure we have a method to call
		if ($class && !method_exists($class, $this->method))
		{
			$this->_writeErr('The specified method does not exist.');
			$errors = true;
		}

		if ($errors)
		{
			return;
		}

		$callable = [$class, $this->method];

		// Make sure our callable is actually callable.
		if (!is_callable($callable))
		{
			$this->_writeErr('The specified method is not callable.');
			return;
		}

		if (!Spreadsheet::$plugin->spreadsheet->walkRows($this->file, $callable))
		{
			$this->_writeErr('An unknown error occurred while running the specified method.');
			return;
		}

		$this->stdout(
			'Method executed successfully.' . PHP_EOL,
			Console::FG_GREEN
		);

	}


	/*
	 * Private methods
	 */


	/**
	 * Writes an error to console
	 * @param string $msg
	 */
	private function _writeErr($msg)
	{
		$this->stderr('Error', Console::BOLD, Console::FG_RED);
		$this->stderr(': ', Console::FG_RED);
		$this->stderr($msg . PHP_EOL);
	}


}

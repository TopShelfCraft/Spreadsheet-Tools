<?php
namespace topshelfcraft\spreadsheet\console\controllers;

use Symfony\Component\Filesystem\Filesystem;
use topshelfcraft\spreadsheet\Spreadsheet;
use yii\console\Controller;
use yii\helpers\Console;

class WalkController extends Controller
{

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

	/**
	 * Walks the parsed spreadsheet rows, passing the data from each into a specified method.
	 *
	 * @throws \Exception
	 */
	public function actionRows()
	{
		// Make sure our parameters have been defined

		$errors = false;

		if ($this->file === null) {
			$this->writeErr('--file=/path/to/excel/file is required.');
			$errors = true;
		}

		if ($this->class === null) {
			$this->writeErr('--class=my.custom.class is required.');
			$errors = true;
		}

		if ($this->method === null) {
			$this->writeErr('--method=myMethod is required.');
			$errors = true;
		}

		if ($errors) {
			return;
		}

		// Get filesystem class
		$fs = new Filesystem();

		// Make sure the file path exists
		if (!$fs->exists($this->file)) {
			$this->writeErr('The specified Excel file does not exist');
			$errors = true;
		}

		// Get our class
		$class = null;

		$qualifiedClass = '\\' . str_replace('.', '\\', $this->class);

		if (class_exists($qualifiedClass)) {
			$class = $qualifiedClass;
			$class = new $class;
		}

		if (!$class) {
			$this->writeErr('The specified class does not exist');
			$errors = true;
		}

		// Make sure we have a method to call
		if ($class && !method_exists($class, $this->method)) {
			$this->writeErr('The specified method does not exist');
			$errors = true;
		}

		if ($errors) {
			return;
		}

		if (!Spreadsheet::$plugin->spreadsheetService->walkRows(
			$this->file,
			[
				$class,
				$this->method
			]
		)) {
			$this->writeErr('An unknown error occurred while running the specified method');
			return;
		}

		$this->stdout(
			'Method executed successfully.' . PHP_EOL,
			Console::FG_GREEN
		);
	}

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
	 * Writes an error to console
	 * @param string $msg
	 */
	private function writeErr($msg)
	{
		$this->stderr('Error', Console::BOLD, Console::FG_RED);
		$this->stderr(': ', Console::FG_RED);
		$this->stderr($msg . PHP_EOL);
	}

}

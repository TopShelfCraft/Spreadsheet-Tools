<?php

namespace topshelfcraft\excelimport\console\controllers;

use Symfony\Component\Filesystem\Filesystem;
use topshelfcraft\excelimport\ExcelImport;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Walk command
 */
class WalkController extends Controller
{
    /** @var string $filePath */
    public $filePath = null;

    /** @var string $class */
    public $class = null;

    /** @var string $method */
    public $method = null;

    /**
     * Walks through rows of specified file and sends to specified callback
     * @throws \Exception
     */
    public function actionRows()
    {
        // Make sure our parameters have been defined

        $errors = false;

        if ($this->filePath === null) {
            $this->writeErr('--filePath=/path/to/excel/file is required.');
            $errors = true;
        }

        if ($this->class === null) {
            $this->writeErr('--class=\\\\my\\\\custom\\\\class is required.');
            $errors = true;
        }

        if ($this->method === null) {
            $this->writeErr('--class=myMethod is required.');
            $errors = true;
        }

        if ($errors) {
            return;
        }

        // Get filesystem class
        $fs = new Filesystem();

        // Make sure the file path exists
        if (! $fs->exists($this->filePath)) {
            $this->writeErr('The specified Excel file does not exist');
            $errors = true;
        }

        // Get our class
        $class = null;

        if (class_exists($this->class)) {
            $class = $this->class;
            $class = new $class;
        }

        if (! $class) {
            $this->writeErr('The specified class does not exist');
            $errors = true;
        }

        // Make sure we have a method to call
        if ($class && ! method_exists($class, $this->method)) {
            $this->writeErr('The specified method does not exist');
            $errors = true;
        }

        if ($errors) {
            return;
        }

        if (! ExcelImport::$plugin->spreadsheetService->walkRows(
            $this->filePath,
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
    public function options($actionId) : array
    {
        $options = parent::options($actionId);
        $options[] = 'filePath';
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

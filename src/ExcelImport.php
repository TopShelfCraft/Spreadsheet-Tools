<?php

namespace topshelfcraft\excelimport;

use craft\base\Plugin;

/**
 * Class ExcelImport
 */
class ExcelImport extends Plugin
{
    /** @var ExcelImport $plugin */
    public static $plugin;

    /**
     * Initialize plugin
     */
    public function init()
    {
        // Make sure parent init functionality runs
        parent::init();

        // Save an instance of this plugin for easy reference throughout app
        self::$plugin = $this;
    }
}

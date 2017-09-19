<?php

namespace topshelfcraft\excelimport;

use craft\base\Plugin;
use topshelfcraft\excelimport\services\HelperService;

/**
 * Class ExcelImport
 * @property HelperService $helperService
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

    /**
     * Get the helper service
     * @return HelperService
     */
    public function getHelperService() : HelperService
    {
        return new HelperService();
    }
}

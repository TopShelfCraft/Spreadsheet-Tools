<?php

namespace topshelfcraft\excelimport\services;

use PHPExcel_IOFactory;

/**
 * Class SpreadsheetService
 */
class SpreadsheetService extends BaseService
{
    /**
     * Parse file
     * @param $file
     * @return array
     * @throws \Exception
     */
    public function parseFile($file) : array
    {
        // Create a new Reader of the type that has been identified
        $objReader = PHPExcel_IOFactory::createReader(
            PHPExcel_IOFactory::identify($file)
        );

        // Advise the Reader that we only want to load cell data
        $objReader->setReadDataOnly(true);

        // Load $inputFileName to a PHPExcel Object
        $objPHPExcel = $objReader->load($file);

        // Return the sheet data as an array
        return $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    }
}

<?php

declare(strict_types=1);

namespace Echron\Tools;

class CsvHelper
{
    public static function parseCSVFile(
        string $filePath,
        string $lineDelimiter = \PHP_EOL,
        string $delimiter = ';',
        array  $headers = null
    ): array {
        // TODO: method uses a lot of memory when reading large CSV files, is there a way to reduce this?
        if (!\file_exists($filePath)) {
            throw new \Exception('Unable to get FileMaker products: CSV file "' . $filePath . '" does not exist');
        }
        $result = [];


        $fileData = file_get_contents($filePath);


        $row = 1;

        $lines = \str_getcsv($fileData, $lineDelimiter);

        foreach ($lines as $line) {
            $lineData = \str_getcsv($line, $delimiter);

            if (\is_null($headers)) {
                $headers = $lineData;
            } else {
                $num = count($lineData);
                $row++;

                $productData = [];
                for ($c = 0; $c < $num; $c++) {
                    $field = $c;
                    if (isset($headers[$c])) {
                        $field = $headers[$c];
                    } else {
                        // TODO: should we log this?
                    }

                    $productData[$field] = $lineData[$c];
                }

                $result[] = $productData;
            }
        }

        unset($fileData);
        unset($lines);

        return $result;
    }

}

<?php
declare(strict_types=1);

namespace Echron\Tools;

class CsvHelper
{

    public static function parseCSVFile(
        string $filePath,
        string $lineDelimiter = \PHP_EOL,
        string $delimiter = ';',
        array $headers = null
    ): array {
        if (!\file_exists($filePath)) {
            throw new \Exception('Unable to get FileMaker products: CSV file "' . $filePath . '" does not exist');
        }

        $fileData = file_get_contents($filePath);

        $result = [];

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
                    $field = '[unknown ' . $c . ']';
                    if (isset($headers[$c])) {
                        $field = $headers[$c];
                    }

                    $productData[$field] = $lineData[$c];
                }

                $result[] = $productData;
            }
        }

        return $result;
    }

}

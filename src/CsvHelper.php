<?php

declare(strict_types=1);

namespace Echron\Tools;

class CsvHelper
{
    public static function toCSVFile(array $data, string $filePath, string $lineDelimiter = PHP_EOL, string $delimiter = ';', string $encapsulate = '"'): void
    {
        $rows = [];

        $headers = null;
        foreach ($data as $dat) {
            if ($headers === null) {
                // TODO: validate that all rows have the same keys?
                $headers = array_keys($dat);
            } else {
                $diff = array_diff($headers, array_keys($dat));
                if (count($diff) > 0) {
                    // TODO: implement this

//                    var_dump($diff);
//                    foreach ($diff as $diffKey) {
//
//                    }
                }
            }
        }
        $rows[] = self::toCSVRow($headers, $delimiter, $encapsulate);
        foreach ($data as $dat) {

            $rowFields = [];
            foreach ($headers as $header) {
                $rowFieldValue = '';
                if (isset($dat[$header])) {
                    $rowFieldValue = (string)$dat[$header];
                } else {
                    // TODO: log this
                }
                $rowFields[] = $rowFieldValue;
            }
            $rows[] = self::toCSVRow($rowFields, $delimiter, $encapsulate);
        }

        file_put_contents($filePath, implode($lineDelimiter, $rows));
    }

    public static function parseCSVFile(
        string     $filePath,
        string     $lineDelimiter = \PHP_EOL,
        string     $delimiter = ';',
        array|null $headers = null
    ): array
    {
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

    private static function toCSVRow(array $values, string $delimiter, string $encapsulate): string
    {
        $values = array_map(function (string $value) use ($encapsulate) {
            return $encapsulate . $value . $encapsulate;
        }, $values);
        return implode($delimiter, $values);
    }

}

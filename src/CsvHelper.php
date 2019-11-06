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

        // $headers = null;
        $row = 1;

        //        $fileData = \str_replace([
        //            "\r\n",
        //            //                    "\r",
        //        ], \PHP_EOL, $fileData);

        //        $fileData = \str_replace([
        //            //            "\r\n",
        //            "\r",
        //        ], \PHP_EOL, $fileData);
        $lines = \str_getcsv($fileData, $lineDelimiter);

        //        foreach ($lines as $line) {
        //            var_dump($line);
        //        }
        //        die('---');

        // return [];

        foreach ($lines as $line) {
            $lineData = \str_getcsv($line, $delimiter);

            //            var_dump($lineData);
            //            var_dump($line);
            //            die('---');

            if (\is_null($headers)) {
                $headers = $lineData;
            } else {
                $num = count($lineData);
                //                    echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;

                $productData = [];
                for ($c = 0; $c < $num; $c++) {
                    $field = '[unknown ' . $c . ']';
                    if (isset($headers[$c])) {
                        $field = $headers[$c];
                    }

                    $productData[$field] = $lineData[$c];
                    //                        echo $field . ': ' . $data[$c] . \PHP_EOL;
                }

                $result[] = $productData;
            }
        }

        return $result;
        var_dump($result);
        die('---');

        if (($handle = fopen($filePath, "r")) !== false) {
            while (($lineData = fgetcsv($handle, 4096, $delimiter)) !== false) {
                if (\is_null($headers)) {
                    $headers = $lineData;
                } else {
                    $num = count($lineData);
                    //                    echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;

                    $productData = [];
                    for ($c = 0; $c < $num; $c++) {
                        $field = '[unknown ' . $c . ']';
                        if (isset($headers[$c])) {
                            $field = $headers[$c];
                        }

                        $productData[$field] = $lineData[$c];
                        //                        echo $field . ': ' . $data[$c] . \PHP_EOL;
                    }

                    $result[] = $productData;
                }
            }
            fclose($handle);
        }

        return $result;
    }

}

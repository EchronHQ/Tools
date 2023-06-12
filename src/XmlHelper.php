<?php

declare(strict_types=1);

namespace Echron\Tools;

class XmlHelper
{
    public static function parseStringToSimpleXml(string $xmlString): \SimpleXMLElement
    {
        libxml_use_internal_errors(true);

        $xmlString = self::cleanupMeta($xmlString);

        $xml = simplexml_load_string($xmlString, \SimpleXMLElement::class, LIBXML_NOCDATA);

        if ($xml === false) {
            foreach (libxml_get_errors() as $error) {
                throw new \Exception($error->message);
            }
            libxml_clear_errors();
            throw new \Exception('Unable to parse data');
        }
        libxml_use_internal_errors(false);

        return $xml;
    }

    private static function cleanupMeta(string $xml): string
    {
        //Temp fix
        $xml = str_replace("\x01", "", $xml);
        return str_replace("\x02", "", $xml);

    }

    public static function parseAndValidateStringToSimpleXml(string $xmlString, string $xsdFilePath): \SimpleXMLElement
    {
        if (!file_exists($xsdFilePath)) {
            throw new \Exception('Xsd file `' . $xsdFilePath . '` does not exist');
        }
        libxml_use_internal_errors(true);
        //
        $xmlDom = new \DOMDocument();
        $xmlLoaded = $xmlDom->loadXML($xmlString);
        if (!$xmlLoaded) {
            foreach (libxml_get_errors() as $error) {
                return new \Exception($error->message, $error->code);


            }
            libxml_clear_errors();
        }
        libxml_use_internal_errors(false);
        //Validate file
        $errors = self::_validateConfigFile($xmlDom, $xsdFilePath);
        // $errors = $xmlDom->schemaValidate(BP.'/etc/config.xsd');
        if (count($errors) > 0) {
            //die('Failed');
            /** @var \LibXMLError $error */
            foreach ($errors as $error) {
                throw new \Exception($error->message);
            }
        }
        return simplexml_import_dom($xmlDom);


    }

    private static function _validateConfigFile(\DOMDocument $xmlDom, $xsdFilePath): array
    {
        libxml_use_internal_errors(true);
        $errors = [];
        try {
            $result = $xmlDom->schemaValidate($xsdFilePath);
            if (!$result) {
                $validationErrors = libxml_get_errors();
                if (count($validationErrors)) {
                    $errors = $validationErrors;
                } else {
                    $errors[] = 'Unknown validation error';
                }
            }
        } catch (\Exception $ex) {
            libxml_clear_errors();
            libxml_use_internal_errors(false);
            //var_dump($ex->getMessage());
            //throw $ex;
        }
        libxml_use_internal_errors(false);

        return $errors;
    }

    public static function saveFile(\SimpleXMLElement $xml, string $destination): bool
    {
        libxml_use_internal_errors(true);
        $dir = dirname($destination);
        if (!FileSystem::dirExists($dir)) {
            FileSystem::createDir($dir);
        }

        $domXml = new \DOMDocument('1.0');
        $domXml->preserveWhiteSpace = false;
        $domXml->formatOutput = true;
        $domXml->loadXML($xml->asXML());
        $saved = $domXml->save($destination);

        if ($saved === false) {

            $error = error_get_last();
            if ($error !== null) {
                $message = $error['message'];

                throw new \Exception('Unable to save XML file: ' . $message);
            } else {
                throw new \Exception('Unable to save XML file: unknown exception');
            }

        }
        libxml_use_internal_errors(false);

        return true;

    }
}

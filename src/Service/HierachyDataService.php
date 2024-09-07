<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class HierachyDataService
{
    private string $dataDirectory;

    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        $this->dataDirectory = $parameterBagInterface->get('data_directory');
    }

    /** returns a plain array of hierachy data from csv file */
    public function getData(string $filename): array
    {
        $filePath = $this->dataDirectory.'/'.$filename;

        if (!file_exists($filePath)) {
            throw new \Exception("File not found $filePath");
        }
        $hiearchyData = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = $this->reformHeadersToCamelCase(fgetcsv($handle)); // recognize headers and convert to camel case
            while (($raw = fgetcsv($handle)) !== false) {
                $rawData              = [];
                $rawData[$headers[0]] = $raw[0];
                $rawData[$headers[1]] = $raw[1];
                $rawData[$headers[2]] = $raw[2];
                $rawData[$headers[3]] = $raw[3];
                array_push($hiearchyData, $rawData);
            }
            fclose($handle);
        }

        return $hiearchyData;
    }

    public function toCamelCase($string): string
    {
        $str = str_replace('_', '', ucwords($string, '_'));
        $str = lcfirst($str);

        return $str;
    }

    public function reformHeadersToCamelCase($headers): array
    {
        return array_map([$this, 'toCamelCase'], $headers);
    }
}

<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class HierachyDataService
{
    private string $dataDirectory;

    private CacheInterface $cache;

    public function __construct(ParameterBagInterface $parameterBagInterface, CacheInterface $cacheInterface)
    {
        $this->dataDirectory = $parameterBagInterface->get('data_directory');
        $this->cache         = $cacheInterface;
    }

    /** returns a plain array of hierachy data from csv file */
    public function getData(string $filename): array
    {
        $filePath = $this->dataDirectory . '/' . $filename;

        if (!file_exists($filePath)) {
            throw new \Exception("File not found $filePath");
        }

        $hiearchyData = $this->cache->get('csv_data_cache', function (ItemInterface $item) use ($filePath) {
            $item->expiresAfter(3600);
            return  $this->readDataFromCsvFile($filePath);
        });

        return $hiearchyData;
    }

    public function readDataFromCsvFile(string $filePath): array
    {
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

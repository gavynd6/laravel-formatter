<?php

namespace Atroposmental\Formatter;

use InvalidArgumentException;

use Atroposmental\Formatter\Parsers\ArrayParser;
use Atroposmental\Formatter\Parsers\CollectionParser;
use Atroposmental\Formatter\Parsers\CsvParser;
use Atroposmental\Formatter\Parsers\EloquentParser;
use Atroposmental\Formatter\Parsers\JsonParser;
use Atroposmental\Formatter\Parsers\XmlParser;

class Formatter {
    //  Add class constants that help define input format
    const CSV  = 'csv';
    const JSON = 'json';
    const XML  = 'xml';
    const ARR  = 'array';
    const YAML = 'yaml';
    const COLL = 'collection';
    const ELQNT = 'eloquent';

    private static $supportedTypes = [
        self::CSV,
        self::JSON,
        self::XML,
        self::ARR,
        self::COLL,
        self::ELQNT,
    ];

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * Make: Returns an instance of formatter initialized with data and type
     *
     * @param  mixed       $data The data that formatter should parse
     * @param  string      $type The type of data formatter is expected to parse
     * @param  string      $delimiter The delimitation of data formatter to csv
     * @param  string      $enclosure The enclosure of data formatter to csv
     * @param  string      $newline The newline of data formatter to csv
     * @param  string      $escape The escape of data formatter to csv
     * @return Formatter
     */
    public static function make($data, $type, $headers = false, $delimiter = null, $enclosure = null, $newline = null, $escape = null) {
        if ( in_array($type, self::$supportedTypes) ) {
            $parser = null;

            switch ($type) {
                case self::CSV:
                    $parser = new CsvParser($data, $headers, $delimiter, $enclosure, $newline, $escape);
                    break;

                case self::JSON:
                    $parser = new JsonParser($data);
                    break;

                case self::XML:
                    $parser = new XmlParser($data);
                    break;

                case self::ARR:
                    $parser = new ArrayParser($data);
                    break;

                case self::COLL:
                    $parser = new CollectionParser($data);
                    break;
                
                case self::ELQNT:
                    $parser = new EloquentParser($data);
                    break;
            }

            return new Formatter($parser, $type);
        }

        throw new InvalidArgumentException('make function only accepts [csv, json, xml, array, collection, eloquent] for $type but ' . $type . ' was provided.');
    }

    private function __construct($parser) {
        $this->parser = $parser;
    }

    public function toJson() {
        return $this->parser->toJson();
    }

    public function toArray() {
        return $this->parser->toArray();
    }

    public function toCollection() {
        return $this->parser->toCollection();
    }

    public function toEloquent() {
        return $this->parser->toEloquent();
    }

    public function toXml($baseNode = 'xml', $encoding = 'utf-8', $formated = false) {
        return $this->parser->toXml($baseNode, $encoding, $formated);
    }

    public function toCsv($newline = "\n", $delimiter = ",", $enclosure = '"', $escape = "\\") {
        return $this->parser->toCsv($newline, $delimiter, $enclosure, $escape);
    }

    // public function toYaml() {
    //     return $this->parser->toYaml();
    // }
}

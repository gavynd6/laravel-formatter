<?php

namespace Atroposmental\Formatter\Parsers;

use InvalidArgumentException;

use League\Csv\Reader;
use Atroposmental\Formatter\ArrayHelpers;

class CsvParser extends Parser {
    public $type = \Atroposmental\Formatter\Formatter::CSV;

    public function __construct(
        protected $data,
        protected bool $headers = false,
        protected string $delimiter = ',',
        protected string $enclosure = '"',
        protected string $newline = "\n",
        protected string $escape = "\\"
    ) {
        if ( is_string($data) ) {
            $this->data = Reader::createFromString($data);
            $this->data->setDelimiter($this->delimiter);
            $this->data->setEnclosure($this->enclosure);
        } else {
            throw new InvalidArgumentException('CsvParser only accepts (string) [csv] for $data.');
        }
    }

    public function toArray() {
        $temp = $this->data->jsonSerialize();

        $headings = $temp[0];
        $result   = $headings;

        if ( count($temp) > 1 ) {
            $result = [];

            for ($i = 1; $i < count($temp); ++$i) {
                $row = [];
                for ($j = 0; $j < count($headings); ++$j) {
                    $row[$headings[$j]] = $temp[$i][$j];
                }

                $expanded = [];
                foreach ($row as $key => $value) {
                    ArrayHelpers::set($expanded, $key, $value);
                }

                $result[] = $expanded;
            }
        }

        return $result;
    }
}

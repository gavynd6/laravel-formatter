<?php

namespace Atroposmental\Formatter\Parsers;

use InvalidArgumentException;

class ArrayParser extends Parser {
    public $type = \Atroposmental\Formatter\Formatter::ARR;

    public function __construct(
        protected $data
    ) {
        if ( is_string($data) ) {
            $data = unserialize($data);
        }

        if ( is_array($data) || is_object($data) ) {
            $this->data = (array) $data;
        } else {
            throw new InvalidArgumentException('ArrayParser only accepts (optionally serialized) [object, array] for $data.');
        }
    }

    public function toArray() {
        return $this->data;
    }
}

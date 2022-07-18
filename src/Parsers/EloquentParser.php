<?php

namespace Atroposmental\Formatter\Parsers;

use InvalidArgumentException;
// use Illuminate\Database\Eloquent\Collection

class EloquentParser extends Parser {

    private $array;

    public function __construct($data) {
        if ( is_string($data) ) {
            $data = unserialize($data);
        }


        if ( is_a($data, \Illuminate\Support\Collection::class) ) {
            $this->array = $data;
        }
        else if ( is_array($data) || is_object($data) ) {
            $this->array = (array) $data;
        } else {
            throw new InvalidArgumentException(
                'EloquentParser only accepts (optionally serialized) [object, array] for $data.'
            );
        }
    }

    public function toArray() {
        return $this->array;
    }
}

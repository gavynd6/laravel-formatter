<?php

namespace Atroposmental\Formatter\Parsers;

use InvalidArgumentException;

class CollectionParser extends Parser {
    public $type = \Atroposmental\Formatter\Formatter::COLL;

    public function __construct(
        protected $data
    ) {
        if ( is_string($data) ) {
            if (! ($data = json_decode($data, true)) && json_last_error() == JSON_ERROR_SYNTAX ) {
                $data = unserialize($data);
            }
        }

        if ( is_a($data, \Illuminate\Support\Collection::class) ) {
            $this->data = $data;
        }
        else if ( is_array($data) || is_object($data) ) {
            $this->data = collect($data);
        } else {
            throw new InvalidArgumentException('CollectionParser only accepts (optionally serialized) [object, array] for $data.');
        }
    }

    public function toArray() {
        return $this->data->toArray();
    }
}

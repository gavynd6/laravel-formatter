<?php

namespace Atroposmental\Formatter\Parsers;

use InvalidArgumentException;
// use Illuminate\Database\Eloquent\Collection;

class EloquentParser extends Parser {
    public $type = \Atroposmental\Formatter\Formatter::ELQNT;

    public function __construct(
        protected $data
    ) {
        if ( is_string($data) ) {
            $data = unserialize($data);
        }

        if ( is_a($data, \Illuminate\Support\Collection::class) ) {
            $this->data = $data;
        }
        else if ( is_array($data) || is_object($data) ) {
            $this->data = (array) $data;
        } else {
            throw new InvalidArgumentException('EloquentParser only accepts (optionally serialized) [object, array] for $data.');
        }
    }

    public function toArray() {
        return $this->data;
    }
}

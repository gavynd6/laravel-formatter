<?php

namespace Atroposmental\Formatter\Parsers;

use InvalidArgumentException;

class JsonParser extends Parser {
    public $type = \Atroposmental\Formatter\Formatter::JSON;

    public function __construct(
        protected $data
    ) {
        $this->data = json_decode(trim($data), true);

        if ( json_last_error() !== JSON_ERROR_NONE ) {
            throw new InvalidArgumentException('JsonParser only accepts (optionally serialized) [string, object, array] for $data.');
        }
    }

    public function toArray() {
        return $this->data;
    }
}

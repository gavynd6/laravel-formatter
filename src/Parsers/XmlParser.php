<?php

namespace Atroposmental\Formatter\Parsers;

class XmlParser extends Parser {
    public $type = \Atroposmental\Formatter\Formatter::XML;

    public function __construct(
        protected $data
    ) {
        $this->data = $this->objectify($data);
    }

    /**
     * Ported from laravel-formatter
     * https://github.com/SoapBox/laravel-formatter
     *
     * @author  Daniel Berry <daniel@danielberry.me>
     * @license MIT License (see LICENSE.readme included in the bundle)
     */
    protected function objectify($value) {
        $temp = is_string($value) ?
            simplexml_load_string($value, 'SimpleXMLElement', LIBXML_NOCDATA) :
            $value;

        $result = [];

        foreach ((array) $temp as $key => $value) {
            if ($key === "@attributes") {
                $result['_' . key($value)] = $value[key($value)];
            } elseif (is_array($value) && count($value) < 1) {
                $result[$key] = '';
            } else {
                $result[$key] = (is_array($value) or is_object($value)) ? $this->objectify($value) : $value;
            }
        }

        return $result;
    }

    public function toArray() {
        return (array) $this->data;
    }
}

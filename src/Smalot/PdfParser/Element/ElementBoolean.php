<?php

namespace Smalot\PdfParser\Element;

use Smalot\PdfParser\Element;
use Smalot\PdfParser\Document;

/**
 * Class ElementBoolean
 * @package Smalot\PdfParser\Element
 */
class ElementBoolean extends Element
{
    /**
     * @param string   $value
     * @param Document $document
     */
    public function __construct($value, Document $document = null)
    {
        parent::__construct(strtolower($value) == 'true', null);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value ? 'true' : 'false';
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function equals($value)
    {
        return ($this->getContent() === $value);
    }

    /**
     * @param string   $content
     * @param Document $document
     * @param int      $offset
     *
     * @return bool|ElementBoolean
     */
    public static function parse($content, Document $document = null, &$offset = 0)
    {
        if (preg_match('/^\s*(?<value>true|false)/is', $content, $match)) {
            $value  = $match['value'];
            $offset = strpos($content, $value) + strlen($value);

            return new self($value, $document);
        }

        return false;
    }
}

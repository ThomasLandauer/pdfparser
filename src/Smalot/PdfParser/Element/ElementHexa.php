<?php

namespace Smalot\PdfParser\Element;

use Smalot\PdfParser\Element\ElementString;
use Smalot\PdfParser\Document;

/**
 * Class ElementHexa
 * @package Smalot\PdfParser\Element
 */
class ElementHexa extends ElementString
{
    /**
     * @param string   $value
     * @param Document $document
     */
    public function __construct($value, Document $document = null)
    {
        $text = '';
        for ($i = 0; $i < strlen($value); $i += 4) {
            $hex = substr($value, $i, 4);
            $text .= '&#' . hexdec($hex) . ';';
        }
        $text = html_entity_decode($text, ENT_NOQUOTES, 'UTF-8');

        parent::__construct($text, null);
    }

    /**
     * @param string   $content
     * @param Document $document
     * @param int      $offset
     *
     * @return bool|ElementHexa
     */
    public static function parse($content, Document $document = null, &$offset = 0)
    {
        if (preg_match('/^\s*\<(?<name>[A-F0-9]+)\>/is', $content, $match)) {
            $name   = $match['name'];
            $offset = strpos($content, '<' . $name) + strlen($name) + 2; // 1 for '>'

            return new self($name, $document);
        }

        return false;
    }
}

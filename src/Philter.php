<?php

declare(strict_types=1);

namespace Indgy;

use InvalidArgumentException;

/**
 * A PHP fluent input sanitiser.
 * Philter will sanitise any untrusted scalar value by chaining methods together, 
 * finally calling toString() toInt() or toFloat() to return the filtered input.
 *
 * @author Ian Grindley
 */
class Philter
{
    /**
     * @var Array - A list of filters to apply
     */
    private $filters;
    /**
     * @var Mixed - The initial value passed from the Request input
     */
    private $var;


    /**
     * The constructor requires the untrusted input.
     * Optionally a boolean to skip trimming and removing unprintable characters
     * @param Scalar $var - The variable to be filtered
     * @param Boolean $raw - If true Philter will not Automatically trim spaces and remove unprintable characters
     */
    public function __construct($var, Bool $raw=false)
    {
        mb_internal_encoding("UTF-8");
        mb_regex_encoding("UTF-8");

        $this->setVar($var);
        $this->filters = [];
        if (false === $raw) {
            $this->utf8()->stripUnprintable()->trim();
        }
    }
    /**
     * Set the variable to be manipulated
     *
     * @param Mixed $var
     * @return Filter
     */
    private function setVar($var): Philter
    {
        if ( ! is_null($var) && ! is_scalar($var)) {
            throw new InvalidArgumentException('Philter cannot filter a non scalar value, pass strings, integers, floats or booleans only');
        }
        $this->var = $var;

        return $this;
    }
    /**
     * Apply the filters and return the processed variable
     *
     * @return Mixed - The processed variable
     */
    private function process()
    {
        $var = $this->var;
        foreach ($this->filters as $callable) {
            $var = $callable($var);
        }

        return $var;
    }
    /**
     * Return the variable cast as a Boolean
     *
     * @return Boolean
     */
    public function toBool(): ?Bool
    {
        return (bool) $this->process();
    }
    /**
     * Return the variable cast as a Float
     *
     * @param Integer|null $decimals - Limit the number of decimal places
     * @return Float
     */
    public function toFloat(?Int $decimals=null): ?Float
    {
        if (is_null($decimals)) {
            $decimals = PHP_FLOAT_DIG;
        }

        return (float) sprintf("%.{$decimals}F", $this->var);
    }
    /**
     * Return the variable cast as an Integer
     *
     * @return Integer
     */
    public function toInt(): ?Int
    {
        return (int) $this->process();
    }
    /**
     * Return the variable cast as a String
     *
     * @return string
     */
    public function toString(): ?String
    {
        return (string) $this->process();
    }
    
    /*
     *  Philters
     */
    
    /**
     * Removes any characters that are not in the allow list
     *
     * @param String $allowed = A string containing the allowed characters 
     * @return Philter
     */
    public function allow(String $allowed): Philter
    {
        $this->filters[] = function($v) use ($allowed) {
            // skip filtering null
            if (is_null($v)) return $v;
            
            $regex = sprintf("/[^%s]/iu", $allowed);
            return preg_replace($regex, "", $v);
        };

        return $this;
    }
    /**
     * Removes any non alphabetical characters
     *
     * @param String $allowed = An optional string containing individual allowed characters 
     * @return Philter
     */
    public function alpha(?String $allowed=null): Philter
    {
        return $this->allow(sprintf("a-z%s", $allowed));
    }
    /**
     * Removes any non alpha-numeric characters
     *
     * @param String $allowed = An optional string containing individual allowed characters 
     * @return Philter
     */
    public function alphanum(?String $allowed=null): Philter
    {
        return $this->allow(sprintf("a-z0-9%s", $allowed));
    }
    /**
     * Accepts a user defined closure
     *
     * @param Closure $closure - The user defined closure
     * @return Philter
     */
    public function apply($closure): Philter
    {
        $this->filters[] = $closure;
        return $this;
    }
    /**
     * Removes any non-ascii characters, transliterating as necessary
     *
     * @return Philter
     */
    public function ascii(): Philter
    {
        $map = [
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'Ae',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae',
            'ß'=>'Ss',
            'Þ'=>'B',
            'þ'=>'b',
            'Ç'=>'C',
            'ç'=>'c', 
            'Ð'=>'Dj',
            'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',
            'ƒ'=>'f',
            'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',
            'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',
            'Ñ'=>'N',
            'ñ'=>'n',
            'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
            'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o',
            'Š'=>'S', 'š'=>'s', 'ś' => 's',
            'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U',
            'ù'=>'u', 'ú'=>'u', 'û'=>'u',
            'Ý'=>'Y',
            'ý'=>'y',
            'ÿ'=>'y',
            'Ž'=>'Z', 'ž'=>'z',

        ];
        $this->filters[] = function($v) use ($map) {
            // skip filtering null
            if (is_null($v)) return $v;

            return preg_replace('/[\x00-\x1F\x7F]/u', '', strtr($v, $map));
        };

        return $this;
    }
    /**
     * Filters the variable, ensuring it is between $min and $max
     *
     * @param Int $min 
     * @param Int $max 
     * @return Philter
     */
    public function between(Int $min, Int $max): Philter
    {
        $this->filters[] = function($v) use ($min, $max) {
            // skip filtering null
            if (is_null($v)) return $v;

            return ((int) $v >= $min && (int) $v <= $max) ? $v : null;
        };

        return $this;
    }
    /**
     * Checks that the variable contains the string in $match
     *
     * @param String $match - The string to match
     * @param Bool $match_case - Set true to match case
     * @return Philter
     */
    public function contains(String $match, Bool $match_case=false): Philter
    {
        $this->filters[] = function($v) use ($match, $match_case) {
            // skip filtering null
            if (is_null($v)) return $v;

            if ($match_case) {
                return (mb_strstr($v, $match)) ? $v : null;
            }

            return (mb_stristr($v, $match)) ? $v : null;
        };

        return $this;
    }
    /**
     * Shortens the length to $len characters
     *
     * @param Int $length - The number of characters to leave in the string
     * @return Philter
     */
    public function cut(?Int $length): Philter
    {
        $length = (is_null($length)) ? 255 : $length;
        if ($length < 0) {
            throw new InvalidArgumentException("The length passed to Philter::cut() should be greater than zero");
        }
        $this->filters[] = function($v) use ($length) {
            // skip filtering null
            if (is_null($v)) return $v;

            return mb_substr($v, 0 , $length);
        };

        return $this;
    }
    /**
     * Sets a default value to be returned if the variable is null
     *
     * @param Mixed $default 
     * @return Philter
     */
    public function default($default): Philter
    {
        $this->filters[] = function($v) use ($default) {
            return (empty($v)) ? $default : $v;
        };

        return $this;
    }
    /**
     * Removes any non numeric characters
     *
     * @param String $allowed = A string containing individual allowed characters 
     * @return Philter
     */
    public function digits(?String $allowed=null): Philter
    {
        return $this->allow(sprintf("0-9%s", $allowed));
    }
    /**
     * Filter to check if the value is in the provided array of values
     *
     * @param Array $values - The values to check
     * @param String $match_case - Compare values in a case sensitive
     * @return Philter
     */
    public function in(Array $values, $match_case=false): Philter
    {
        if (false === $match_case) {
            $values = array_map(function($value) {
                return (is_string($value)) ? mb_strtolower($value) : "$value";
            }, $values);
        }

        $this->filters[] = function($v) use ($values, $match_case) {
            return (in_array($v, $values)) ? $v : null;
        };

        return $this;
    }
    /**
     * Check the input is greater than the value of max, sets var to null if less than $Min
     *
     * @param Int $min - The lowest value allowed to pass through the filter
     * @return Philter
     */
    public function min(Int $min): Philter
    {
        $this->filters[] = function($v) use ($min) {
            // skip filtering null
            if (is_null($v)) return $v;

            return ((int) $v >= $min) ? $v : null;
        };

        return $this;
    }
    /**
     * Check the input is less than the value of max, sets var to null if greater than $max
     *
     * @param Int $max - The highest value allowed to pass through the filter
     * @return Philter
     */
    public function max(Int $max): Philter
    {
        $this->filters[] = function($v) use ($max) {
            // skip filtering null
            if (is_null($v)) return $v;

            return ((float) $v <= $max) ? $v : null;
        };

        return $this;
    }
    /**
     * Removes any non numeric characters, allows typical currency markup + or - commas and decimals
     *
     * @param String $allowed = A string containing individual allowed characters 
     * @return Philter
     */
    public function numeric(?String $allowed=null): Philter
    {
        return $this->allow(sprintf("0-9\-\+\,\.%s", $allowed));
    }
    /**
     * Trims the leading and trailing characters from the variable
     *
     * @param String $char 
     * @return Philter
     */
    public function trim(?String $char=null): Philter
    {
        $char = (is_null($char)) ? ' ' : $char;
        $this->filters[] = function($v) use ($char) {
            // skip filtering null
            if (is_null($v)) return $v;

            return trim($v, $char);
        };

        return $this;
    }
    /**
     * Trims the leftmost character matching $char
     *
     * @param String $char 
     * @return Philter
     */
    public function ltrim(?String $char=null): Philter
    {
        $char = (is_null($char)) ? ' ' : $char;
        $this->filters[] = function($v) use ($char) {
            // skip filtering null
            if (is_null($v)) return $v;

            return ltrim($v, $char);
        };

        return $this;
    }
    /**
     * Trims the rightmost character matching $char
     *
     * @param String $char 
     * @return Philter
     */
    public function rtrim(?String $char=null): Philter
    {
        $char = (is_null($char)) ? ' ' : $char;
        $this->filters[] = function($v) use ($char) {
            // skip filtering null
            if (is_null($v)) return $v;

            return rtrim($v, $char);
        };

        return $this;
    }
    /**
     * Convert the string to UTF-8 transliterating if possible
     *
     * @param Bool $ignore - Discard unrepresentable characters
     * @return Philter
     */
    public function utf8(Bool $ignore=false): Philter
    {
        $this->filters[] = function($v) use ($ignore) {
            // skip filtering null
            if (is_null($v)) return $v;

            $opt = ($ignore) ? "IGNORE" : "TRANSLIT";

            return iconv("UTF-8", "UTF-8//$opt", $v);
        };

        return $this;
    }


    /*
     *  HTML methods
     */


    /**
     * Removes the majority of HTML tags leaving only a basic set without attributes
     *
     * @param String $allowed_tags - An optional set of tags to allow
     * @return Philter
     */
    public function stripAttributes(?String $allowed_tags=null): Philter
    {
        $this->filters[] = function($v) {

            $dom = new DOMDocument;
            $dom->loadHTML(htmlentities($v));
            $xpath = new DOMXPath($dom);
            $nodes = $xpath->query('//@*');

            foreach ($nodes as $node) {
                $node->parentNode->removeAttribute($node->nodeName);
            }

            $v = $dom->saveHTML();
            return $v;

        };

        return $this;
    }
    /**
     * Removes all HTML and javascript
     *
     * @return Philter
     */
    public function stripHtml(): Philter
    {
        $this->filters[] = $this->stripTags();
        $this->filters[] = $this->stripJavascript();

        return $this;
    }
    /**
     * Removes all javascript
     *
     * @return Philter
     */
    public function stripJavascript(): Philter
    {
        $this->filters[] = function($v) {

            $js = "(0x[0-9a-f]+|\\x[0-9a-f]+)";
            $v = preg_replace("/$js/u", "", $v);

            return $v;
        };

        return $this;
    }
    /**
     * Removes the majority of HTML tags leaving only a basic set without attributes
     *
     * @param String $allowed_tags - An optional set of tags to allow
     * @return Philter
     */
    public function stripTags(?String $allowed_tags=null): Philter
    {
        $this->filters[] = function($v) use ($allowed_tags) {
            // remove html tags
            $default = '<a><b><br><dd><div><em><h1><h2><h3><h4><h5><h6><i><li><ol><p><small><span><strong><ul>';
            $v = strip_tags($v, $tags.$allowed);

            return $v;

        };

        return $this;
    }


    /**
     * Removes any unprintable characters, this filter is processed by default
     *
     * @return Philter
     */
    public function stripUnprintable(): Philter
    {
        $this->filters[] = function($v) {
            // $regex = sprintf('/[^\w\s0-9\n\r\t\.%s]/i', $allowed_chars);
            // return preg_replace($regex, '', $v);
            // $v = filter_var((string) $v, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

            $v = preg_replace(['/\r\n?/', '/[^\P{C}\t\n]+/u'], ["\n", ''], $v);

            return $v;

            return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u', '', $v);
            return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v);
            return preg_replace('/[\x00-\x1F\x7F-\xA0\xAD]/u', '', $v);
            
        };

        return $this;
    }
}

/**
 * Shortcut to return a new Philter instance
 * @param Scalar $var - The variable to be filtered
 * @param Boolean $raw - If true Philter will not Automatically trim spaces and remove unprintable characters
 * @return Indgy\Philter
 */
function philter($var, Bool $raw=false): Philter {
    return new Philter($var, $raw);
}


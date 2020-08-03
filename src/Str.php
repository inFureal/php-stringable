<?php


namespace Infureal;


use BadMethodCallException;
use Exception;
use Infureal\Str\Stringable;

class Str
{

    protected static $macro = [];

    protected function __construct()
    {
    }

    static function of(string $str) {
        return new Stringable($str);
    }

    static function lower(string $str, $encoding = null) {
        return static::of(mb_strtolower($str, $encoding));
    }

    static function upper(string $str, $encoding = null) {
        return static::of(mb_strtoupper($str, $encoding));
    }

    static function split(string $str, int $length = 1) {
        return str_split($str, $length);
    }

    static function replace(string $str, $search, $replace, $registerSensitive = true) {
        $res = call_user_func($registerSensitive ? 'str_replace' : 'str_ireplace', $search, $replace, $str);
        return static::of($res);
    }

    static function trim(string $str, $charlist = " \t\n\r\0\x0B") {
        return static::of(trim($charlist));
    }

    static function ltrim(string $str, $charlist = " \t\n\r\0\x0B") {
        return static::of(ltrim($str, $charlist));
    }

    static function rtrim(string $str, $charlist = " \t\n\r\0\x0B") {
        return static::of(rtrim($str, $charlist));
    }

    static function explode(string $str, $delimiter, $limit = null) {
        return explode($delimiter, $str, $limit);
    }

    static function upperFirst(string $str) {
        return static::of(ucfirst($str));
    }

    static function lowerFirst(string $str) {
        return static::of(lcfirst($str));
    }

    static function md5(string $str, bool $rawOutput = false) {
        return static::of(md5($str, $rawOutput));
    }

    static function levenshtein(string $str, string $search): int {
        return levenshtein($str, $search);
    }

    static function levenshteinClosest(string $str, array $search) {
        $closest = -1;
        $find = null;

        $str = static::of($str);

        foreach ($search as $word) {

            if (0 == $length = static::levenshtein($str, $word))
                return $word;

            if ($length <= $closest || $closest < 0) {
                $find = $word;
                $closest = $length;
            }
        }

        return static::of($find);
    }

    static function nl2br(string $str, bool $xhtml = true) {
        return static::of(nl2br($str, $xhtml));
    }

    static function isSimilar(string $str, string $search, float $similarPercent = 100) {
        similar_text($str, $search, $prc);
        return $prc >= $similarPercent;
    }

    static function soundex(string $str) {
        return soundex($str);
    }

    static function soundLike(string $str, string $search) {
        return self::soundex($str) == self::soundex($search);
    }

    static function repeat(string $str, int $count) {
        return static::of(str_repeat($str, $count));
    }

    static function shuffle(string $str) {
        return static::of(str_shuffle($str));
    }

    static function wordCount(string $str) {
        return str_word_count($str);
    }

    static function equal(string $str, string $search, $registerSensitive = true) {
        return call_user_func($registerSensitive ? 'strcmp' : 'strcasecmp', $str, $search);
    }

    static function length(string $str, $encoding = null) {
        return mb_strlen($str, $encoding);
    }

    static function flip(string $str) {
        return static::of(strrev($str));
    }

    static function before(string $str, string $search) {
        return static::of(strstr($str, $search, true));
    }

    static function after(string $str, string $search) {
        return static::of(substr( strstr($str, $search), strlen($search) ));
    }

    static function between(string $str, string $from, string $to) {
        return static::beforeLast( static::after($str, $from), $to );
    }

    static function beforeLast(string $str, string $search) {
        return static::of($str)
            ->flip()
            ->after( Str::flip($search) )
            ->flip();
    }

    static function afterLast(string $str, string $search) {
        return static::of($str)
            ->flip()
            ->before( Str::flip($search) )
            ->flip();
    }

    static function has(string $str, string $search) {
        return substr_count($str, $search) > 0;
    }

    static function hasAll(string $str, array $search) {

        foreach ($search as $word)
            if (!self::has($str, $word))
                return false;

        return true;
    }

    static function upperWords(string $str, $delimiters = " \t\r\n\f\v") {
        return static::of( ucwords($str, $delimiters) );
    }

    static function pregReplace(string $str, $pattern, $replace) {
        return static::of( preg_replace($pattern, $replace, $str) );
    }

    static function snake(string $str, string $delimiter = '_') {

        $str = static::of($str);

        if (ctype_lower($str))
            return $str;

        return $str
            ->upperWords()
            ->pregReplace('/\s+/u', '')
            ->pregReplace('/(.)(?=[A-Z])/u', '$1'.$delimiter)
            ->lower();
    }

    static function kebab($str) {
        return static::snake($str, '-');
    }

    static function words(string $str, $words = 100, $end = '...') {
        $str = static::of($str);
        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $str, $matches);

        if (! isset($matches[0]) || $str->length() === static::length($matches[0]))
            return $str;

        return static::of( $str->rtrim($matches[0]) . $end );
    }

    static function random(int $length = 16) {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

    static function title(string $str, $encoding = 'UTF-8') {
        return static::of(mb_convert_case($str, MB_CASE_TITLE, $encoding));
    }

    static function studly(string $str, array $delimiters = []) {
        return static::of($str)
            ->kebab()
            ->replace(['-', '_'] + $delimiters, ' ')
            ->upperWords()
            ->replace(' ', '');
    }

    static function camel(string $str) {
        return static::of($str)
            ->studly()
            ->lowerFirst();
    }

    static function isClass(string $str, bool $autoload = true) {
        return class_exists($str, $autoload);
    }

    static function cut(string $str, $start, $length = null, $encoding = 'UTF-8') {
        return static::of( mb_substr($str, $str, $length, $encoding) );
    }

    static function macro(string $name, callable $callback) {

        $name = (string)Str::camel($name);

        if (method_exists($class = static::class, $name) || in_array($name, static::$macro))
            throw new Exception("Method $name already exists in $class.");

        static::$macro[$name] = $callback;
    }

    static function __callStatic($name, $arguments)
    {

        if (!in_array($name, self::$macro))
            throw new BadMethodCallException("Method $name not found in " . static::class . '.');

        return call_user_func([static::class, $name], ... $arguments);
    }

}

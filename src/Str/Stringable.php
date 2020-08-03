<?php


namespace Infureal\Str;


use BadMethodCallException;
use Infureal\Str;
use ReflectionClass;

/**
 * Class Stringable
 * @package Infureal\Str
 *
 * @method self lower()
 * @method self upper()
 * @method self upperFirst()
 * @method self lowerFirst()
 * @method self shuffle()
 * @method self flip()
 * @method self studly(array $delimiters = [])
 * @method self cut($start, $length = null, $encoding = 'UTF-8')
 * @method self title($encoding = 'UTF-8')
 * @method self md5(bool $rawOutput = false)
 * @method self trim($charlist = " \t\n\r\0\x0B")
 * @method self ltrim($charlist = " \t\n\r\0\x0B")
 * @method self rtrim($charlist = " \t\n\r\0\x0B")
 * @method self replace($search, $replace)
 * @method self nl2br(bool $xhtml = true)
 * @method self repeat(int $count)
 * @method self before(string $search)
 * @method self after(string $search)
 * @method self beforeLast(string $search)
 * @method self afterLast(string $search)
 * @method self pregReplace($pattern, $replace)
 * @method self upperWords($delimiters = " \t\r\n\f\v")
 * @method self snake(string $delimiter = '_')
 * @method self kebab()
 * @method self camel()
 * @method self words($words = 100, $end = '...')
 *
 * @method array split(int $length = 1)
 * @method array explode($delimiter, $limit = null)
 *
 * @method int levenshtein(string $search)
 * @method int wordCount()
 * @method int length($encoding = null)
 *
 * @method string levenshteinClosest(array $search)
 * @method string soundex()
 *
 * @method bool isSimilar(string $search, float $similarPercent = 100)
 * @method bool soundLike(string $search)
 * @method bool equal(string $search, $registerSensitive = true)
 * @method bool has(string $search)
 * @method bool hasAll(array $search)
 * @method bool isClass(bool $autoload = true)
 */
class Stringable
{

    protected $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __call($name, $arguments)
    {
        $reflection = new ReflectionClass(Str::class);

        if (!$reflection->hasMethod($name))
            throw new BadMethodCallException("Method $name not found.");

        array_unshift($arguments, $this->string);
        return call_user_func_array([Str::class, $name], $arguments);
    }

    public function __toString(): string
    {
        return $this->string;
    }

}

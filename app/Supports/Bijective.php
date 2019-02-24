<?php
namespace App\Supports;

class Bijective
{
    /**
     * Encode ID
     *
     * @param int $i
     * @return string The encoded value
     */
    public static function encode(int $i)
    {
        if ($i == 0) {
            return self::alphabets(0);
        }

        $result = [];
        $base = count(self::alphabets());

        while ($i > 0) {
            $result[] = self::alphabets($i % $base);
            $i = floor($i / $base);
        }

        $result = array_reverse($result);
        return join("", $result);
    }

    /**
     * Decode ID
     *
     * @param string $input
     * @return int
     */
    public static function decode($input)
    {
        $i = 0;
        $base = count(self::alphabets());
        $input = str_split($input);

        foreach ($input as $char) {
            $pos = array_search($char, self::alphabets());
            $i = $i * $base + $pos;
        }

        return $i;
    }

    /**
     * Alphabets
     *
     * @param  int|null $pos
     * @return char|array
     */
    public static function alphabets(int $pos = null)
    {
        $_alphabets = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

        return $_alphabets[$pos] ?? $_alphabets;
    }
}

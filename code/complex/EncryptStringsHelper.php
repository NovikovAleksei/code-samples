<?php

/**
 * EncryptStringsHelper
 *
 * Helps to encode / decode emails and phones
 */
class EncryptStringsHelper
{
    private static array $dictionary = [
        // English letters
        'a' => 101, 'b' => 102, 'c' => 103, 'd' => 104, 'e' => 105, 'f' => 106, 'g' => 107, 'h' => 108, 'i' => 109,
        'j' => 110, 'k' => 111, 'l' => 112, 'm' => 113, 'n' => 114, 'o' => 115, 'p' => 116, 'q' => 117, 'r' => 118,
        's' => 119, 't' => 120, 'u' => 121, 'v' => 122, 'w' => 123, 'x' => 124, 'y' => 125, 'z' => 126,
        'A' => 201, 'B' => 202, 'C' => 203, 'D' => 204, 'E' => 205, 'F' => 206, 'G' => 207, 'H' => 208, 'I' => 209,
        'J' => 210, 'K' => 211, 'L' => 212, 'M' => 213, 'N' => 214, 'O' => 215, 'P' => 216, 'Q' => 217, 'R' => 218,
        'S' => 219, 'T' => 220, 'U' => 221, 'V' => 222, 'W' => 223, 'X' => 224, 'Y' => 225, 'Z' => 226,

        // German
        'ä' => 127, 'ö' => 128, 'ü' => 129, 'ß' => 130,
        'Ä' => 227, 'Ö' => 228, 'Ü' => 229, 'ẞ' => 230,

        //numbers
        '0' => 800, '1' => 801, '2' => 802, '3' => 803, '4' => 804, '5' => 805, '6' => 806, '7' => 807, '8' => 808,
        '9' => 809,

        // special characters
        '!' => 901, '#' => 902, '$' => 903, '%' => 904, '&' => 905, '\'' => 906, '*' => 907, '+' => 908, '-' => 909,
        '/' => 910, '=' => 911, '?' => 912, '^' => 913, '`' => 914, '_' => 915, '{' => 916, '|' => 917, '}' => 918,
        '~' => 919, '"' => 920, '(' => 921, ')' => 922, ',' => 923, ':' => 924, ';' => 925, '<' => 926, '>' => 927,
        '@' => 928, '[' => 929, '\\' => 930, ']' => 931, '.' => 932, ' ' => 933

    ];

    public static function encode_string(string $value): string
    {
        return self::work_on_string($value);
    }

    public static function decode_string(string $value): string
    {
        return self::work_on_string($value, 3);
    }

    private static function work_on_string(string $value, int $length = 1): string
    {
        $map = $length === 1 ? self::$dictionary : array_flip(self::$dictionary);
        $char_array = mb_str_split($value, $length);
        $result = "";
        foreach ($char_array as $item) {
            if (array_key_exists($item, $map)) {
                $result .= $map[$item];
            } else {
                $result .= mb_strlen($item) > 1 ? preg_replace('/\d+/u', '', $item) : "0" . $item . "0";
            }
        }
        return $result;
    }
}

<?php

namespace App\Domains\Shared\Hash;

use Illuminate\Contracts\Hashing\Hasher;

class CustomHasher implements Hasher
{
    /**
     * Hash the given value.
     *
     * @param  string  $hashedValue
     * @return array
     */
    public function info($hashedValue): array
    {
        return [];
    }

    public function make($value, array $options = array()): string
    {
        $salt = $this->randString(6);

        return $salt.md5($salt.$value);
    }

    public static function makeNewPassword($value, array $options = array()): string
    {
        $salt = self::randString(6);

        return $salt.md5($salt.$value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        $salt = substr($hashedValue, 0, 6);
        $password = $salt.md5($salt.$value);

        return $password === $hashedValue;
    }

    public static function generatePassword(int $length = 8): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    public function needsRehash($hashedValue, array $options = []): false
    {
        return false;
    }

    public static function randString($passLen = 10, $passChars = false): string
    {
        static $allChars = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789!@#\$%^&*()";
        $string = "";
        if (is_array($passChars)) {
            while (strlen($string) < $passLen) {
                if (function_exists('shuffle')) {
                    shuffle($passChars);
                }
                foreach ($passChars as $chars) {
                    $n = strlen($chars) - 1;
                    $string .= $chars[mt_rand(0, $n)];
                }
            }
            if (strlen($string) > count($passChars)) {
                $string = substr($string, 0, $passLen);
            }
        } else {
            if ($passChars !== false) {
                $chars = $passChars;
                $n = strlen($passChars) - 1;
            } else {
                $chars = $allChars;
                $n = 61; //strlen($allChars)-1;
            }
            for ($i = 0; $i < $passLen; $i++) {
                $string .= $chars[mt_rand(0, $n)];
            }
        }

        return $string;
    }
}

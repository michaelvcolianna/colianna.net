<?php

namespace TwoFAS\Encryption\Random;

use OutOfRangeException;
use TwoFAS\Encryption\Exceptions\RandomBytesGenerateException;

/**
 * Non-cryptographical random strings generator.
 *
 * @package TwoFAS\Encryption\Random
 */
class RandomGenerator
{
    const LETTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const DIGITS  = '0123456789';
    const SYMBOLS = '!#$%&()*+,-./:;<=>?@[]^_`{|}~';

    /**
     * @param int $size
     *
     * @return Str
     *
     * @throws RandomBytesGenerateException
     */
    public function string($size)
    {
        return $this->getRandom(new Str(self::LETTERS . self::DIGITS . self::SYMBOLS), $size);
    }

    /**
     * @param int $size
     *
     * @return Str
     *
     * @throws RandomBytesGenerateException
     */
    public function alphaNum($size)
    {
        return $this->getRandom(new Str(self::LETTERS . self::DIGITS), $size);
    }

    /**
     * @param int $size
     *
     * @return Str
     *
     * @throws RandomBytesGenerateException
     */
    public function symbols($size)
    {
        return $this->getRandom(new Str(self::SYMBOLS), $size);
    }

    /**
     * @param Str $alphabet
     * @param int    $size
     *
     * @return Str
     *
     * @throws RandomBytesGenerateException
     */
    private function getRandom(Str $alphabet, $size)
    {
        $string = new Str();

        if ($size < 1) {
            return $string;
        }

        while ($string->length() < $size) {
            try {
                $randomBytes = openssl_random_pseudo_bytes(1);

                if (false === $randomBytes) {
                    throw new RandomBytesGenerateException((string) openssl_error_string());
                }

                $index  = ord($randomBytes[0]) % $alphabet->length();
                $string = $string->concat($alphabet->pick($index));
            } catch (OutOfRangeException $e) {

            }
        }

        return $string;
    }
}
<?php

namespace App\Concerns;

trait FloatTrait
{
    /**
     * Trim trailing zeros from a float value
     */
    public function trimZeros(float $value, int $precision = 2): string
    {
        return rtrim(rtrim(number_format($value, $precision, '.', ''), '0'), '.');
    }
}

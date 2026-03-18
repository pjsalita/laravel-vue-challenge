<?php

namespace App\Containers;

use App\Concerns\FloatTrait;
use App\Contracts\Container;
use App\Exceptions\ContainerInsufficientException;
use App\Exceptions\ContainerOverflowException;

abstract class AbstractContainer implements Container
{
    use FloatTrait;

    public function __construct(
        protected string $name,
        protected string $unit,
        protected float $capacity,
        protected float $current = 0.0,
    ) {}

    public function add(float $quantity): void
    {
        if ($this->current + $quantity > $this->capacity) {
            $space = $this->capacity - $this->current;

            throw new ContainerOverflowException(
                sprintf(
                    '%s would overflow. Only %s %s of space remaining (tried to add %s %s).',
                    $this->name,
                    $this->trimZeros($space, 3),
                    $this->unit,
                    $this->trimZeros($quantity, 3),
                    $this->unit,
                )
            );
        }

        $this->current += $quantity;
    }

    public function use(float $quantity): float
    {
        if ($this->current === 0.0) {
            throw new ContainerInsufficientException(
                sprintf('%s container is empty. Please refill container.', $this->name)
            );
        }

        if ($this->current < $quantity) {
            throw new ContainerInsufficientException(
                sprintf(
                    '%s is too low. %s %s needed but only %s %s available.',
                    $this->name,
                    $this->trimZeros($quantity, 3),
                    $this->unit,
                    $this->trimZeros($this->current, 3),
                    $this->unit,
                )
            );
        }

        $this->current -= $quantity;

        return $this->current;
    }

    public function get(): float
    {
        return round($this->current, 3);
    }

    public function empty(): void
    {
        $this->current = 0.0;
    }

    public function getCapacity(): float
    {
        return $this->capacity;
    }

    public function getPercentage(): float
    {
        if ($this->capacity === 0.0) {
            return 0.0;
        }

        return round(($this->current / $this->capacity) * 100, 1);
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function convertToUnit(float $amount, string $unit): float
    {
        return $amount;
    }
}

<?php

use App\Containers\CoffeeContainer;
use App\Exceptions\ContainerInsufficientException;
use App\Exceptions\ContainerOverflowException;

beforeEach(function () {
    $this->capacity = 500.0;
    $this->initial = 100.0;
    $this->container = new CoffeeContainer($this->capacity, $this->initial);
});

test('get returns current amount rounded to 3 decimals', function () {
    expect($this->container->get())->toBe(100.0);

    $this->container->add(33.333333);

    expect($this->container->get())->toBe(133.333);
});

test('add increases current', function () {
    $this->container->add(50.0);

    expect($this->container->get())->toBe(150.0);
});

test('add throws overflow when exceeding capacity', function () {
    $this->container->add(500.0);
})->throws(ContainerOverflowException::class, 'Coffee would overflow. Only 400 g of space remaining (tried to add 500 g).');

test('add allows filling exactly to capacity', function () {
    $this->container->add(400.0);

    expect($this->container->get())->toBe(500.0);
});

test('use decreases current and returns remaining', function () {
    $remaining = $this->container->use(8.0);

    expect($remaining)->toBe(92.0);
    expect($this->container->get())->toBe(92.0);
});

test('use throws when container is empty', function () {
    $empty = new CoffeeContainer(500.0, 0.0);
    $empty->use(8.0);
})->throws(ContainerInsufficientException::class, 'Coffee container is empty. Please refill container.');

test('use throws when quantity exceeds current', function () {
    $this->container->use(150.0);
})->throws(ContainerInsufficientException::class, 'Coffee is too low. 150 g needed but only 100 g available.');

test('empty sets current to zero', function () {
    $this->container->empty();

    expect($this->container->get())->toBe(0.0);
});

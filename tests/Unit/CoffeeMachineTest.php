<?php

use App\Containers\CoffeeContainer;
use App\Containers\WaterContainer;
use App\Enums\Container;
use App\Repositories\ContainerRepository;
use App\Repositories\DrinkRepository;
use App\Services\CoffeeMachine;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->water = new WaterContainer(2.0, 1.0);
    $this->coffee = new CoffeeContainer(500.0, 100.0);
});

afterEach(function () {
    Mockery::close();
});

test('status returns container and drink statuses', function () {
    $containerRepo = Mockery::mock(ContainerRepository::class);
    $containerRepo->shouldReceive('getContainer')
        ->with(Container::WATER)
        ->andReturn($this->water);
    $containerRepo->shouldReceive('getContainer')
        ->with(Container::COFFEE)
        ->andReturn($this->coffee);

    $drinkRepo = Mockery::mock(DrinkRepository::class);
    $drinkRepo->shouldReceive('getActive')->andReturn([
        [
            'slug' => 'espresso',
            'name' => 'Espresso',
            'water' => 24,
            'water_unit' => 'mL',
            'coffee' => 8,
        ],
    ]);

    $service = new CoffeeMachine($containerRepo, $drinkRepo);
    $result = $service->status();

    expect($result)->toHaveKeys(['containers', 'drinks']);
    expect($result['containers'])->toHaveKeys(['water', 'coffee']);
    expect($result['containers']['water']['current'])->toBe(1.0);
    expect($result['containers']['water']['capacity'])->toBe(2.0);
    expect($result['containers']['coffee']['current'])->toBe(100.0);
    expect($result['drinks']['espresso'])->toEqual(['enough_water' => true, 'enough_coffee' => true]);
});

test('fillContainer adds quantity and updates repository', function () {
    $container = new WaterContainer(2.0, 0.5);
    $containerRepo = Mockery::mock(ContainerRepository::class);
    $containerRepo->shouldReceive('getContainer')->with(Container::WATER)->andReturn($container);
    $containerRepo->shouldReceive('update')
        ->once()
        ->with('water', ['current' => 1.0], 'type')
        ->andReturn(null);

    $drinkRepo = Mockery::mock(DrinkRepository::class);

    $service = new CoffeeMachine($containerRepo, $drinkRepo);
    $result = $service->fillContainer(Container::WATER, 0.5);

    expect($result['message'])->toContain('Added');
    expect($result['message'])->toContain('water');
    expect($result['containers']['water']['current'])->toBe(1.0);
});

test('brewDrink uses water and coffee and updates repository', function () {
    $water = new WaterContainer(2.0, 1.0);
    $coffee = new CoffeeContainer(500.0, 100.0);
    $containerRepo = Mockery::mock(ContainerRepository::class);
    $containerRepo->shouldReceive('getContainer')->with(Container::WATER)->andReturn($water);
    $containerRepo->shouldReceive('getContainer')->with(Container::COFFEE)->andReturn($coffee);
    $containerRepo->shouldReceive('update')->twice();

    $drinkRepo = Mockery::mock(DrinkRepository::class);
    $drinkRepo->shouldReceive('findBySlug')->with('espresso')->andReturn([
        'slug' => 'espresso',
        'name' => 'Espresso',
        'water' => 24,
        'water_unit' => 'mL',
        'coffee' => 8,
    ]);

    $service = new CoffeeMachine($containerRepo, $drinkRepo);
    $result = $service->brewDrink('espresso');

    expect($result['message'])->toContain('Brewed Espresso');
    expect($water->get())->toBe(0.976);
    expect($coffee->get())->toBe(92.0);
});

test('brewDrink throws when drink not found', function () {
    $containerRepo = Mockery::mock(ContainerRepository::class);
    $containerRepo->shouldReceive('getContainer')->andReturn($this->water, $this->coffee);
    $drinkRepo = Mockery::mock(DrinkRepository::class);
    $drinkRepo->shouldReceive('findBySlug')->with('unknown')->andReturn(null);

    $service = new CoffeeMachine($containerRepo, $drinkRepo);
    $service->brewDrink('unknown');
})->throws(ModelNotFoundException::class);

test('emptyContainer empties and updates repository', function () {
    $container = new WaterContainer(2.0, 1.0);
    $containerRepo = Mockery::mock(ContainerRepository::class);
    $containerRepo->shouldReceive('getContainer')->with(Container::WATER)->andReturn($container);
    $containerRepo->shouldReceive('update')
        ->once()
        ->with('water', ['current' => 0.0], 'type')
        ->andReturn(null);

    $drinkRepo = Mockery::mock(DrinkRepository::class);

    $service = new CoffeeMachine($containerRepo, $drinkRepo);
    $result = $service->emptyContainer(Container::WATER);

    expect($result['message'])->toContain('emptied');
    expect($container->get())->toBe(0.0);
});

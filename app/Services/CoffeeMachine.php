<?php

namespace App\Services;

use App\Concerns\FloatTrait;
use App\Containers\AbstractContainer;
use App\Enums\Container;
use App\Repositories\ContainerRepository;
use App\Repositories\DrinkRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoffeeMachine
{
    use FloatTrait;

    public function __construct(
        private ContainerRepository $containerRepository,
        private DrinkRepository $drinkRepository,
    ) {}

    public function status()
    {
        $water = $this->containerRepository->getContainer(Container::WATER);
        $coffee = $this->containerRepository->getContainer(Container::COFFEE);

        $drinks = [];

        foreach ($this->drinkRepository->getActive() as $drink) {
            $waterRequired = $water->convertToUnit($drink['water'], $drink['water_unit']);
            $hasWater = $water->get() >= $waterRequired;
            $hasCoffee = $coffee->get() >= $drink['coffee'];
            $drinks[$drink['slug']] = [
                'enough_water' => $hasWater,
                'enough_coffee' => $hasCoffee,
            ];
        }

        return [
            'containers' => [
                'water' => $this->containerStatus($water),
                'coffee' => $this->containerStatus($coffee),
            ],
            'drinks' => $drinks,
        ];
    }

    public function fillContainer(Container $type, float $quantity): array
    {
        $container = $this->containerRepository->getContainer($type);
        $container->add($quantity);
        $this->containerRepository->update($type->value, ['current' => $container->get()], 'type');

        return [
            'message' => sprintf(
                'Added %s %s in %s container',
                $this->trimZeros($quantity, 3),
                $container->getUnit(),
                strtolower($container->getName())
            ),
            'containers' => [
                $type->value => $this->containerStatus($container),
            ],
        ];
    }

    public function brewDrink(string $slug): array
    {
        $drink = $this->drinkRepository->findBySlug($slug);
        $water = $this->containerRepository->getContainer(Container::WATER);
        $coffee = $this->containerRepository->getContainer(Container::COFFEE);

        if ($drink === null) {
            throw new ModelNotFoundException;
        }

        $waterRequired = $water->convertToUnit($drink['water'], $drink['water_unit']);
        $water->use($waterRequired);
        $coffee->use($drink['coffee']);

        $this->containerRepository->update(Container::WATER->value, ['current' => $water->get()], 'type');
        $this->containerRepository->update(Container::COFFEE->value, ['current' => $coffee->get()], 'type');

        return [
            'message' => sprintf('Brewed %s. Enjoy your drink!', $drink['name']),
            'drink' => $drink,
            'containers' => [
                'water' => $this->containerStatus($water),
                'coffee' => $this->containerStatus($coffee),
            ],
        ];
    }

    public function emptyContainer(Container $type): array
    {
        $container = $this->containerRepository->getContainer($type);
        $container->empty();
        $this->containerRepository->update($type->value, ['current' => $container->get()], 'type');

        return [
            'message' => sprintf('%s container emptied.', $container->getName()),
            'containers' => [
                $type->value => $this->containerStatus($container),
            ],
        ];
    }

    private function containerStatus(AbstractContainer $container): array
    {
        return [
            'current' => $container->get(),
            'name' => $container->getName(),
            'capacity' => $container->getCapacity(),
            'percentage' => $container->getPercentage(),
            'unit' => $container->getUnit(),
        ];
    }
}

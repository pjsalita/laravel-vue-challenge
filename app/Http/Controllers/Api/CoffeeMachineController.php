<?php

namespace App\Http\Controllers\Api;

use App\Concerns\ApiResponse;
use App\Enums\Container;
use App\Exceptions\ContainerInsufficientException;
use App\Exceptions\ContainerOverflowException;
use App\Http\Requests\FillContainerRequest;
use App\Repositories\DrinkRepository;
use App\Services\CoffeeMachine;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class CoffeeMachineController
{
    use ApiResponse;

    public function __construct(
        private CoffeeMachine $service,
    ) {}

    public function status(): JsonResponse
    {
        return $this->success($this->service->status(), 'Machine status fetched successfully.');
    }

    public function drinks(DrinkRepository $drinks): JsonResponse
    {
        return $this->success($drinks->getActive(), 'Drinks fetched successfully.');
    }

    public function fill(FillContainerRequest $request, Container $type): JsonResponse
    {
        try {
            $result = $this->service->fillContainer($type, $request->float('quantity'));

            return $this->success($result);
        } catch (ContainerOverflowException $e) {
            return $this->validationError(message: $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return $this->error($e->getMessage() ?? 'An unexpected error occurred.', 500);
        }
    }

    public function brew(string $slug): JsonResponse
    {
        try {
            return $this->created($this->service->brewDrink($slug));
        } catch (ModelNotFoundException $e) {
            return $this->error('Drink not available.', 404);
        } catch (ContainerInsufficientException $e) {
            return $this->error($e->getMessage(), 422);
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return $this->error($e->getMessage() ?? 'An unexpected error occurred.', 500);
        }
    }

    public function empty(Container $type): JsonResponse
    {
        try {
            return $this->success($this->service->emptyContainer($type));
        } catch (Throwable $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return $this->error($e->getMessage() ?? 'An unexpected error occurred.', 500);
        }
    }
}

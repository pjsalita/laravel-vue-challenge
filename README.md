# Blueshores Coffee Machine Challenge

Laravel 12 + Vue 3 (Inertia) application.

## Requirements

- PHP 8.3+
- Composer
- Node.js 24+
- (Optional) Docker & Docker Compose

## Setup

### Docker

1. Copy environment file:
    ```bash
    cp .env.example .env
    ```
2. Generate app key:
    ```bash
    docker compose run --rm app php artisan key:generate
    ```
3. Build and start the app:

    ```bash
    docker compose up -d --build
    ```

4. Run migrations:

    ```bash
    docker exec app php artisan migrate
    ```

5. (Optional) Stop the app once finished:
    ```bash
    docker compose down
    ```

### Local

1. Install dependencies and setup:
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    npm install
    npm run build
    ```
    Or use the composer script:
    ```bash
    composer run setup
    ```
2. Run the dev server:

    ```bash
    composer run dev
    ```

    Or separately: `php artisan serve` and `npm run dev` (in another terminal).

App is available at http://localhost:8000

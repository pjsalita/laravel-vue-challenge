# Blueshores Coffee Machine Challenge

Laravel 12 + Vue 3 (Inertia) application.

---

## Requirements

- Docker & Docker Compose
- PHP 8.3+
- Composer
- Node.js 24+

---

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

### Local (without Docker)

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

---

## Assumptions

1. **Containers start empty.** Containers begin at 0 — fill them before brewing.
2. **Water in milliliters.** The requirement says in `liters`; but will store it in `ml` unit.
3. **Ristretto is not exposed as an endpoint.** Ristretto is listed under Coffee machine requirements but is not listed in the API/UI requirements. Assuming this is a requirement forgot to add in the other parts of the documentation, already prepared the code for it to add later on.
4. **No authentication.** Out of scope for this assessment.
5. **ContainerInterface interface name.** The provided `ContainerInterface.php` file uses `interface Container` which violates PSR-4 Autoloading Standard. Assuming this is a mistake, changed it to `interface ContainerInterface` to comply.
6. **Ports in docker-compose.** Default ports of `Redis(6379)` and `Mysql(3306)` are changed in `docker-compose.yml` to uncommon ports `6400` and `3310` respectively in case the default ports are already in used to avoid conflict. In case of conflict, change to another port or stop other services that uses the conflicting ports.

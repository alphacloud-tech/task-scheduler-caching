# Laravel Weather API with Caching & Task Scheduling

This project demonstrates a Laravel API for fetching weather data with caching and task scheduling using Redis.

## Features

-   Weather data fetching via an external API.
-   Caching the weather data using Redis for faster response.
-   Task scheduling to automatically clear cache at regular intervals.

## Prerequisites

Before setting up the project, make sure you have the following:

-   PHP >= 8.2
-   Composer
-   Laravel >= 10.0
-   Redis server installed and running

## Setup Instructions

### 1. Clone the Repository

First, clone the project to your local machine:

````bash
git clone https://github.com/alphacloud-tech/task-scheduler-caching.git
cd task-scheduler-caching


### 2. Install Dependencies

Install the required Composer packages:

```bash
composer install
````

### 3. Set Up .env Configuration

Copy the `.env.example` to `.env`:

```bash
cp .env.example .env
```

### 4. Configure Redis

#### Install Redis on Your Local Machine

Follow the instructions below to install Redis based on your operating system.

**For Ubuntu/Debian:**

```bash
sudo apt-get update
sudo apt-get install redis-server
```

**For Windows:**

-   Download Redis for Windows from [Redis for Windows](https://sourceforge.net/projects/redis-for-windows.mirror/files).
-   Follow the instructions provided to install Redis.

#### Start Redis

Run the following command to check Redis:

```bash
redis-server --version
```

This will return Redis version`.

```bash
sc query redis
```

If you installed Redis as a service on Windows, you can check its status.

```bash
redis-cli ping PONG
```

This will return "PONG" If Redis is running.

#### Update .env Configuration

In your `.env` file, ensure the following settings for Redis:

```dotenv
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 5. Set Up Cache Configuration

In the `config/cache.php` file, ensure the following settings for Redis:

```php
'default' => env('CACHE_DRIVER', 'file'),

'stores' => [
   'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
    ],
],
```

### 6. Run Database Migrations

Run the following command to migrate your database:

```bash
php artisan migrate
```

### 7. Task Scheduling

To set up task scheduling to clear the cache periodically, open the `app/Console/Kernel.php` file and add the following code in the `schedule()` method:

```php
protected function schedule(Schedule $schedule): void
{
    // Schedule the task to clear weather data cache every two minutes
    $schedule->call(function () {
        Cache::forget('weather_data');
    })->everyTwoMinutes();
}
```

To run the task scheduler, use the following command:

```bash
php artisan schedule:run
```

You can also set up a cron job to run this command every minute:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```


### 8. Use the Weather API

Once everything is set up, you can call the weather API endpoint to retrieve cached weather data:

```bash
GET /api/weather
```

If the weather data is available in the cache, it will be returned from there. Otherwise, it will be fetched from the external weather API and cached.

### 9. Clear Cache

You can manually clear the cache by running the following command:

```bash
php artisan cache:clear
```

Alternatively, the task scheduler will automatically clear the cache every two minutes (as set in the `Kernel.php`).

---

## Additional Resources

-   [Laravel Documentation - Redis](https://laravel.com/docs/8.x/redis)
-   [Redis Documentation](https://redis.io/documentation)

---


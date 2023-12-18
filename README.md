# NewsApp - A Laravel News Aggregator

This Laravel application fetches articles from different news providers, ensuring you stay informed in a clean and user-friendly interface.

## Required Versions
- PHP v8.0.2
- Laravel v9.0

## Running the App

### Without Docker

To run the app without Docker, follow these steps:

1. Clone this repository to your local machine.
2. Install the necessary dependencies using Composer:

    ```shell
    composer install
    ```

3. Create a copy of the `.env.example` file and rename it to `.env`. Configure your database settings in the `.env` file.

4. Generate an application key:

    ```shell
    php artisan key:generate
    ```

5. Migrate Database:

    ```shell
    php artisan migrate
    ```

6. Execute Seeder:

    ```shell
    php artisan db:seed
    ```

7. Execute News Scrappers: Laravel Command schedulers to get the news data, filter out, and store in the database:

    **Manually Execute Scraper:**

    ```shell
    php artisan schedule:run
    ```

8. Start the development server:

    ```shell
    php artisan serve
    ```

### With Docker

To run the app with Docker, ensure you have Docker installed on your machine, and then follow these steps:

1. Clone this repository to your local machine.
2. Open your terminal and navigate to the project directory.
3. Create a copy of the `.env.example` file and rename it to `.env.docker`. Configure your database settings in the `.env` file.

4. Build the Docker image using the provided Dockerfile:

    ```shell
    sudo docker-compose --build
    docker-compose up -d
    ```

5. This will start the Laravel app in a Docker container, and you can access it in your web browser at [`http://localhost:8000`].

6. These will run automatically. If not you can these manually.

    ```shell
    docker exec -it <container-id> php artisan migrate
    docker exec -it <container-id> php artisan db:seed
    docker exec -it <container-id> php artisan schedule:run
    ```

### Setup Cronjob

To set up the scheduler with a cron job, add the following entry to your server's crontab:

```shell
* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1 > /etc/crontabs/www-data

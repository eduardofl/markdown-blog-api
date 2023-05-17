# Markdown blog API

## Setting up
### Build docker images
First step is to build the API and database docker images:

    $ docker build -t blog .
    $ docker build -t blog-db blog-db

### Run containers
    $ docker compose up -d

### Install dependencies
    $ docker exec -it $(docker ps --format '{{.Names}}' | grep 'blog_web') composer install

### Migrate database
    $ docker exec -it $(docker ps --format '{{.Names}}' | grep 'blog_web') php artisan migrate

After executing the steps before correctly, the API should be available in `localhost:8000`. You can test it by acessing this example endpoint http://localhost:8000/api/health-check
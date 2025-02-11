# How to Run the Project

## 1. Start Elasticsearch with Docker
Run the following command to start Elasticsearch using Docker Compose:
```sh
docker-compose up -d
```

## 2. Run Migrations and Seed the Database
Execute the following command to migrate and seed the database:
```sh
php artisan migrate --seed
```

## 3. Index Posts in Elasticsearch
To index posts in Elasticsearch, run:
```sh
php artisan posts:reindex
```


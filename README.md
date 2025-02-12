# How to Run the Project

## 1. Start Elasticsearch with Docker
Run the following command to start Elasticsearch using Docker Compose:
```sh
docker-compose up -d
```

## 2. Add these variables to your .env
You should have these variable in your .env that matches wih docker-compose.yml
1. ELASTICSEARCH_HOST
2. ELASTICSEARCH_PORT
3. ELASTICSEARCH_PASSWORD

## 3. Run Migrations and Seed the Database
Execute the following command to migrate and seed the database:
```sh
php artisan migrate --seed
```

## 4. Index Posts in Elasticsearch
To index posts in Elasticsearch, run:
```sh
php artisan posts:reindex
```


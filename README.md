# Development Setup Instructions

- Add DATABASE_URL="mysql://root:password@127.0.0.1:3306/orders_shop?serverVersion=8.0.37" in .env file.
- Add PRODUCT_SERVICE_API_BASE_URI=http://127.0.0.1:8000/api/v1/ in .env file.

Note: First, you need to run the products service as it will be running on port 8000.

- Install Dependencies
```bash
composer install
```

- Run migrations to create tables in database
```bash
php bin/console doctrine:migrations:migrate
```

- Start application
```bash
symfony server:start
```

## Endpoints

```json
Create orders
POST /api/v1/orders
Content-Type: application/json

{
    "product": "4165f1fd-0b9e-4479-8510-20032f65c435",
    "qty": 10
}

List all orders
GET /api/v1/orders
Content-Type: application/json
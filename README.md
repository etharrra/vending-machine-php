# Vending Machine

A Laravel-based Application for managing a virtual vending machine system. This application handles product management, user authentication, and purchase transactions.

## Live Demo

URL: http://ec2-54-251-177-213.ap-southeast-1.compute.amazonaws.com/

## Features

-   Token-based Authentication using Laravel Sanctum
-   Session-based Authentication using Laravel Breeze
-   Product Management (CRUD operations)
-   Purchase Transaction System
-   Role-based Access Control
-   Pagination Support
-   Error Handling with Consistent Responses
-   Postman Collection for API Testing

## Project Overview

The project is a Laravel-based application for managing a virtual vending machine system. It handles product management, user authentication, and purchase transactions. The project includes features such as token-based authentication, role-based access control, and error handling with consistent responses.

### Key Components

1. **Authentication**:

    - API: The project uses Laravel Sanctum for token-based authentication (`/api/login`)
    - Web: Laravel Breeze handles web authentication with session-based login (`/login`)

2. **Product Management**:

    - API: Full CRUD operations via RESTful endpoints (`/api/products`)
    - Web: Admin interface for product management with forms and views (`/products`)

3. **Purchase Transactions**:

    - API: Purchase endpoints with validation (`/api/products/{id}/purchase`)
    - Web: Interactive purchase forms with real-time validation (`/products/{id}/purchase`)

4. **Role-based Access Control**:
    - API: Token-based permissions for admin/user roles
    - Web: Session-based middleware restricting access by user roles

### Flow Explanation

#### 1. **Authentication**

-   **Routes**: Defined in `web.php` and `api.php`

    -   **Web Routes**:
        -   Users can login via `/login` using **Laravel Breeze** session-based authentication
        -   Users can register via `/register` and logout via `/logout`
    -   **API Routes**:
        -   Login using `/api/login` for token generation
        -   Logout using `/api/logout` to invalidate token

-   **Controller**: `AuthController` handles API token-based authentication

    -   **login**: POST `/api/login` - Validates credentials and returns Sanctum token
    -   **logout**: POST `/api/logout` - Revokes current Sanctum token

-   **Authentication Flow**:
    -   Web: Uses session-based auth with login forms
    -   API: Uses token-based auth with Sanctum

#### 2. **Product Management**

-   **Routes**: Defined in web.php and `api.php`.

    -   **Web Routes**:
        -   Admins can manage products (list, create, edit, update, delete) via routes like `/products`, `/products/create`, `/products/{id}/edit`, etc.
        -   Users can view and purchase products via routes like `/products/{id}/purchase`.
    -   **API Routes**:
        -   Similar CRUD operations and purchase functionality are available via API endpoints like `/api/products`, `/api/products/{id}`, `/api/products/{id}/purchase`, etc.

-   **Controller**: `ProductController` handles the logic for product management.

    -   **index**: Lists products with pagination and sorting functionality via `sort` and `direction` query parameters.
    -   **create**: Shows the form for creating a new product.
    -   **store**: Stores a newly created product.
    -   **edit**: Shows the form for editing a product.
    -   **update**: Updates an existing product.
    -   **destroy**: Deletes a product.
    -   **purchaseView**: Shows the form for purchasing a product.
    -   **purchase**: Handles the purchase of a product, including validation, updating product quantity, and logging the transaction.

-   **Controller**: `ApiProductController` handles API-side product management.
    -   **apiIndex**: GET `/api/products` - Lists products with pagination
    -   **apiShow**: GET `/api/products/{id}` - Shows specific product details
    -   **apiStore**: POST `/api/products` - Creates new product (admin only)
    -   **apiUpdate**: PUT `/api/products/{id}` - Updates existing product
    -   **apiDestroy**: DELETE `/api/products/{id}` - Removes product
    -   **apiPurchase**: POST `/api/products/{id}/purchase` - Handles product purchase with validation, database transaction, and error handling

#### 3. **Purchase Transactions**

-   **Routes**: Defined in web.php and `api.php`.

    -   **Web Routes**:
        -   Users can view and purchase products via routes like `/products/{id}/purchase`.
    -   **API Routes**:
        -   Similar functionality is available via API endpoints like `/api/products/{id}/purchase`.

#### 4. **Role-based Access Control**

-   **Middleware**: `RoleMiddleware` ensures that only users with the appropriate roles can access certain routes.
    -   **User Role**: Can view and purchase products.
    -   **Admin Role**: Can manage products and view transactions.

#### 5. **Error Handling**

-   **Consistent Responses**: The API returns consistent error responses in a JSON format with appropriate HTTP status codes.

#### 6. **Testing**

-   **Unit Tests**: `ProductControllerTest` includes tests for various scenarios like guest access, user purchase, admin product management, etc.
-   **Running Tests**: Use `php artisan test` to run the test suite.

## Requirements

-   PHP 8.2 or higher
-   Composer
-   MySQL 5.7 or higher
-   Laravel 12.x

## Installation

1. Clone the repository:

```bash
git clone https://github.com/etharrra/vending-machine-php.git
cd vending-machine-php
```

2. Install dependencies:

```bash
composer install
```

3. Copy the environment file:

```bash
cp .env.example .env
```

4. Configure your database settings in `.env`

5. Generate application key:

```bash
php artisan key:generate
```

6. Run migrations:

```bash
php artisan migrate
```

7. Start the development server:

```bash
php artisan serve
```

## API Documentation

### Authentication

#### Login

```
POST /api/login
```

Request body:

```json
{
    "email": "user@example.com",
    "password": "password"
}
```

### Products

#### List Products

```
GET /api/products
Authorization: Bearer {token}
```

#### Get Single Product

```
GET /api/products/{id}
Authorization: Bearer {token}
```

#### Create Product

```
POST /api/products
Authorization: Bearer {token}
```

Request body:

```json
{
    "name": "Product Name",
    "price": 1.99,
    "quantity_available": 10
}
```

#### Update Product

```
PUT /api/products/{id}
Authorization: Bearer {token}
```

#### Delete Product

```
DELETE /api/products/{id}
Authorization: Bearer {token}
```

#### Purchase Product

```
POST /api/products/{id}/purchase
Authorization: Bearer {token}
```

Request body:

```json
{
    "quantity": 1
}
```

### Transactions

#### List Transactions

```
GET /api/transactions
Authorization: Bearer {token}
```

#### Get Single Transaction

```
GET /api/transactions/{id}
Authorization: Bearer {token}
```

## Authorization

The API uses two types of abilities for access control:

-   `crud:true` - Allows CRUD operations on products and viewing transactions
-   `purchase:true` - Allows purchasing products

## Error Handling

The API returns consistent error responses in the following format:

```json
{
    "status": "error",
    "message": "Error description",
    "errors": {
        "field": ["Error detail"]
    }
}
```

Common HTTP status codes:

-   200: Success
-   201: Created
-   400: Bad Request
-   401: Unauthorized
-   403: Forbidden
-   404: Not Found
-   422: Validation Error
-   500: Server Error

## Testing

Run the test suite:

```bash
php artisan test
```

## Postman Collection

A Postman collection is included in the repository (`VendingMachine.postman_collection.json`) for testing the API endpoints.

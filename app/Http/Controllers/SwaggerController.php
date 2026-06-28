<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SwaggerController extends Controller
{
    public function index(): View
    {
        return view('swagger');
    }

    public function spec(): JsonResponse
    {
        return response()->json([
            'openapi' => '3.0.3',
            'info' => [
                'title' => config('app.name', 'Ecommerce Backend').' API',
                'description' => 'OpenAPI documentation for the ecommerce backend API.',
                'version' => '1.0.0',
            ],
            'servers' => [
                [
                    'url' => url('/api'),
                    'description' => 'API server',
                ],
            ],
            'tags' => [
                ['name' => 'Authentication'],
                ['name' => 'Products'],
                ['name' => 'Cart'],
            ],
            'paths' => $this->paths(),
            'components' => $this->components(),
        ]);
    }

    private function paths(): array
    {
        return [
            '/register' => [
                'post' => [
                    'tags' => ['Authentication'],
                    'summary' => 'Register a new user',
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => ['$ref' => '#/components/schemas/RegisterRequest'],
                            ],
                        ],
                    ],
                    'responses' => [
                        '201' => [
                            'description' => 'User registered',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/AuthResponse'],
                                ],
                            ],
                        ],
                        '422' => ['$ref' => '#/components/responses/ValidationError'],
                    ],
                ],
            ],
            '/login' => [
                'post' => [
                    'tags' => ['Authentication'],
                    'summary' => 'Log in a user',
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => ['$ref' => '#/components/schemas/LoginRequest'],
                            ],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'User authenticated',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/AuthResponse'],
                                ],
                            ],
                        ],
                        '401' => ['$ref' => '#/components/responses/Unauthorized'],
                        '422' => ['$ref' => '#/components/responses/ValidationError'],
                    ],
                ],
            ],
            '/logout' => [
                'post' => [
                    'tags' => ['Authentication'],
                    'summary' => 'Log out the current user',
                    'security' => [['sanctum' => []]],
                    'responses' => [
                        '200' => [
                            'description' => 'User logged out',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/MessageResponse'],
                                ],
                            ],
                        ],
                        '401' => ['$ref' => '#/components/responses/Unauthenticated'],
                    ],
                ],
            ],
            '/products' => [
                'get' => [
                    'tags' => ['Products'],
                    'summary' => 'List products',
                    'parameters' => [
                        [
                            'name' => 'category_id',
                            'in' => 'query',
                            'required' => false,
                            'schema' => ['type' => 'integer', 'example' => 1],
                        ],
                        [
                            'name' => 'search',
                            'in' => 'query',
                            'required' => false,
                            'schema' => ['type' => 'string', 'example' => 'shirt'],
                        ],
                        [
                            'name' => 'page',
                            'in' => 'query',
                            'required' => false,
                            'schema' => ['type' => 'integer', 'example' => 1],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Paginated product list',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/PaginatedProducts'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            '/products/{product}' => [
                'get' => [
                    'tags' => ['Products'],
                    'summary' => 'Show a product',
                    'parameters' => [
                        [
                            'name' => 'product',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer', 'example' => 1],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Product detail',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/ProductDetail'],
                                ],
                            ],
                        ],
                        '404' => ['$ref' => '#/components/responses/NotFound'],
                    ],
                ],
            ],
            '/cart' => [
                'get' => [
                    'tags' => ['Cart'],
                    'summary' => 'List cart items for the current user',
                    'security' => [['sanctum' => []]],
                    'responses' => [
                        '200' => [
                            'description' => 'Cart items',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'array',
                                        'items' => ['$ref' => '#/components/schemas/Cart'],
                                    ],
                                ],
                            ],
                        ],
                        '401' => ['$ref' => '#/components/responses/Unauthenticated'],
                    ],
                ],
                'post' => [
                    'tags' => ['Cart'],
                    'summary' => 'Add or update a cart item',
                    'security' => [['sanctum' => []]],
                    'requestBody' => [
                        'required' => true,
                        'content' => [
                            'application/json' => [
                                'schema' => ['$ref' => '#/components/schemas/CartRequest'],
                            ],
                        ],
                    ],
                    'responses' => [
                        '201' => [
                            'description' => 'Cart item saved',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/Cart'],
                                ],
                            ],
                        ],
                        '401' => ['$ref' => '#/components/responses/Unauthenticated'],
                        '422' => ['$ref' => '#/components/responses/ValidationError'],
                    ],
                ],
            ],
            '/cart/{cart}' => [
                'delete' => [
                    'tags' => ['Cart'],
                    'summary' => 'Remove a cart item',
                    'security' => [['sanctum' => []]],
                    'parameters' => [
                        [
                            'name' => 'cart',
                            'in' => 'path',
                            'required' => true,
                            'schema' => ['type' => 'integer', 'example' => 1],
                        ],
                    ],
                    'responses' => [
                        '200' => [
                            'description' => 'Cart item removed',
                            'content' => [
                                'application/json' => [
                                    'schema' => ['$ref' => '#/components/schemas/MessageResponse'],
                                ],
                            ],
                        ],
                        '401' => ['$ref' => '#/components/responses/Unauthenticated'],
                        '403' => ['$ref' => '#/components/responses/Forbidden'],
                        '404' => ['$ref' => '#/components/responses/NotFound'],
                    ],
                ],
            ],
        ];
    }

    private function components(): array
    {
        return [
            'securitySchemes' => [
                'sanctum' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'Sanctum token',
                ],
            ],
            'schemas' => [
                'RegisterRequest' => [
                    'type' => 'object',
                    'required' => ['name', 'email', 'password', 'password_confirmation'],
                    'properties' => [
                        'name' => ['type' => 'string', 'example' => 'Jane Doe'],
                        'email' => ['type' => 'string', 'format' => 'email', 'example' => 'jane@example.com'],
                        'password' => ['type' => 'string', 'format' => 'password', 'minLength' => 6, 'example' => 'secret123'],
                        'password_confirmation' => ['type' => 'string', 'format' => 'password', 'example' => 'secret123'],
                    ],
                ],
                'LoginRequest' => [
                    'type' => 'object',
                    'required' => ['email', 'password'],
                    'properties' => [
                        'email' => ['type' => 'string', 'format' => 'email', 'example' => 'jane@example.com'],
                        'password' => ['type' => 'string', 'format' => 'password', 'example' => 'secret123'],
                    ],
                ],
                'AuthResponse' => [
                    'type' => 'object',
                    'properties' => [
                        'user' => ['$ref' => '#/components/schemas/User'],
                        'token' => ['type' => 'string', 'example' => '1|plain-text-token'],
                    ],
                ],
                'MessageResponse' => [
                    'type' => 'object',
                    'properties' => [
                        'message' => ['type' => 'string', 'example' => 'Removed'],
                    ],
                ],
                'User' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'name' => ['type' => 'string', 'example' => 'Jane Doe'],
                        'email' => ['type' => 'string', 'format' => 'email', 'example' => 'jane@example.com'],
                        'email_verified_at' => ['type' => 'string', 'format' => 'date-time', 'nullable' => true],
                        'is_admin' => ['type' => 'boolean', 'example' => false],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                    ],
                ],
                'Category' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'name' => ['type' => 'string', 'example' => 'Clothing'],
                        'slug' => ['type' => 'string', 'example' => 'clothing'],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                    ],
                ],
                'Product' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'category_id' => ['type' => 'integer', 'example' => 1],
                        'name' => ['type' => 'string', 'example' => 'Cotton T-Shirt'],
                        'slug' => ['type' => 'string', 'example' => 'cotton-t-shirt'],
                        'description' => ['type' => 'string', 'nullable' => true, 'example' => 'Comfortable cotton t-shirt.'],
                        'price' => ['type' => 'string', 'example' => '19.99'],
                        'stock' => ['type' => 'integer', 'example' => 25],
                        'image' => ['type' => 'string', 'nullable' => true, 'example' => 'products/shirt.jpg'],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                        'category' => ['$ref' => '#/components/schemas/Category'],
                    ],
                ],
                'ProductDetail' => [
                    'allOf' => [
                        ['$ref' => '#/components/schemas/Product'],
                        [
                            'type' => 'object',
                            'properties' => [
                                'reviews' => [
                                    'type' => 'array',
                                    'items' => ['$ref' => '#/components/schemas/Review'],
                                ],
                            ],
                        ],
                    ],
                ],
                'PaginatedProducts' => [
                    'type' => 'object',
                    'properties' => [
                        'current_page' => ['type' => 'integer', 'example' => 1],
                        'data' => [
                            'type' => 'array',
                            'items' => ['$ref' => '#/components/schemas/Product'],
                        ],
                        'first_page_url' => ['type' => 'string'],
                        'from' => ['type' => 'integer', 'nullable' => true],
                        'last_page' => ['type' => 'integer'],
                        'last_page_url' => ['type' => 'string'],
                        'links' => ['type' => 'array', 'items' => ['type' => 'object']],
                        'next_page_url' => ['type' => 'string', 'nullable' => true],
                        'path' => ['type' => 'string'],
                        'per_page' => ['type' => 'integer', 'example' => 12],
                        'prev_page_url' => ['type' => 'string', 'nullable' => true],
                        'to' => ['type' => 'integer', 'nullable' => true],
                        'total' => ['type' => 'integer'],
                    ],
                ],
                'Review' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'user_id' => ['type' => 'integer', 'example' => 1],
                        'product_id' => ['type' => 'integer', 'example' => 1],
                        'rating' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 5, 'example' => 5],
                        'comment' => ['type' => 'string', 'nullable' => true, 'example' => 'Great product.'],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                        'user' => ['$ref' => '#/components/schemas/User'],
                    ],
                ],
                'CartRequest' => [
                    'type' => 'object',
                    'required' => ['product_id'],
                    'properties' => [
                        'product_id' => ['type' => 'integer', 'example' => 1],
                        'quantity' => ['type' => 'integer', 'minimum' => 1, 'example' => 2],
                    ],
                ],
                'Cart' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => ['type' => 'integer', 'example' => 1],
                        'user_id' => ['type' => 'integer', 'example' => 1],
                        'product_id' => ['type' => 'integer', 'example' => 1],
                        'quantity' => ['type' => 'integer', 'example' => 2],
                        'created_at' => ['type' => 'string', 'format' => 'date-time'],
                        'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                        'product' => ['$ref' => '#/components/schemas/Product'],
                    ],
                ],
                'ErrorResponse' => [
                    'type' => 'object',
                    'properties' => [
                        'message' => ['type' => 'string', 'example' => 'The given data was invalid.'],
                    ],
                ],
                'ValidationError' => [
                    'type' => 'object',
                    'properties' => [
                        'message' => ['type' => 'string', 'example' => 'The given data was invalid.'],
                        'errors' => [
                            'type' => 'object',
                            'additionalProperties' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
                        ],
                    ],
                ],
            ],
            'responses' => [
                'ValidationError' => [
                    'description' => 'Validation failed',
                    'content' => [
                        'application/json' => [
                            'schema' => ['$ref' => '#/components/schemas/ValidationError'],
                        ],
                    ],
                ],
                'Unauthorized' => [
                    'description' => 'Invalid credentials',
                    'content' => [
                        'application/json' => [
                            'schema' => ['$ref' => '#/components/schemas/ErrorResponse'],
                        ],
                    ],
                ],
                'Unauthenticated' => [
                    'description' => 'Missing or invalid bearer token',
                    'content' => [
                        'application/json' => [
                            'schema' => ['$ref' => '#/components/schemas/ErrorResponse'],
                        ],
                    ],
                ],
                'Forbidden' => [
                    'description' => 'Forbidden',
                    'content' => [
                        'application/json' => [
                            'schema' => ['$ref' => '#/components/schemas/ErrorResponse'],
                        ],
                    ],
                ],
                'NotFound' => [
                    'description' => 'Resource not found',
                    'content' => [
                        'application/json' => [
                            'schema' => ['$ref' => '#/components/schemas/ErrorResponse'],
                        ],
                    ],
                ],
            ],
        ];
    }
}

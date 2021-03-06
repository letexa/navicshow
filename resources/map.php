<?php

/**
 * Массив для обозначения медода запроса и прав доступа для url
 * 
 */

return [
    '/category/create' => [
        'method' => 'PUT',
        'access' => \app\model\Role::ADMIN
    ],
    '/category/update' => [
        'method' => 'PATCH',
        'access' => \app\model\Role::ADMIN
    ],
    '/category/delete' => [
        'method' => 'DELETE',
        'access' => \app\model\Role::ADMIN
    ],
    '/article/create' => [
        'method' => 'PUT',
        'access' => \app\model\Role::ADMIN
    ],
    '/article/update' => [
        'method' => 'PATCH',
        'access' => \app\model\Role::ADMIN
    ],
    '/article/delete' => [
        'method' => 'DELETE',
        'access' => \app\model\Role::ADMIN
    ]
];
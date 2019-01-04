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
    ]
];
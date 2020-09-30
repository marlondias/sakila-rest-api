<?php

namespace App;

class Actor extends RESTfulModel
{
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    protected $timestamps = false;

    protected $columnsMetadata = [
        'first_name' => [
            'type' => 'string',
            'orderBy' => [ 'allowed' => true, ],
            'filter' => [
                'allowed' => true, 
                'length' => [1, 100], 
                'methods' => ['equals', 'contains'],
            ],
        ],
        'last_name' => [
            'type' => 'string',
            'orderBy' => [
                'allowed' => true, 
                'default' => 'ASC'
            ],
            'filter' => [
                'allowed' => true, 
                'length' => [1, 100], 
                'methods' => ['equals', 'contains'],
            ],
        ],
        'last_update' => [
            'type' => 'datetime',
            'orderBy' => [
                'allowed' => true, 
                'default' => 'DESC'
            ],
            'filter' => [
                'allowed' => true, 
                'length' => [10, 10], //yyyy-mm-dd 
                'methods' => ['equals', 'lessThan', 'greaterThan'],
            ],
        ],
    ];

}

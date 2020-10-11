<?php

namespace App;

class Actor extends RESTfulModel
{
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    public $timestamps = false;

    protected $columnsMetadata = [
        'first_name' => [
            'type' => 'text',
            'orderBy' => [ 'allowed' => true, ],
            'filter' => [
                'allowed' => true, 
                'length' => [1, 100], 
            ],
        ],
        'last_name' => [
            'type' => 'text',
            'orderBy' => [
                'allowed' => true, 
                'default' => 'ASC'
            ],
            'filter' => [
                'allowed' => true, 
                'length' => [1, 100], 
            ],
        ],
        'last_update' => [
            'type' => 'datetime',
            'orderBy' => [
                'allowed' => true, 
                'default' => 'DESC'
            ],
            'filter' => ['allowed' => true],
        ],
    ];

}

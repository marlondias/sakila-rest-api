<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';
    protected $timestamps = false;

    public $columnsMetadata = [
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

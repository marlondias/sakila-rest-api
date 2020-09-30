<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RESTfulModel extends Model
{

    /**
     * Stores metadata about relevant columns in the model.
     * Must have an array with column names as keys and arrays of attributes as values.
     * Essential attributes are: type, orderBy, filter.
     * 
     * Ex: name => [type => string, orderBy => [allowed => true], filter => [allowed => false] ]
     *
     * @var array
     */
    protected $columnsMetadata = [];

    /**
     * Returns metadata for all columns.
     *
     * @return array
     */
    public function getColumnsMetadata()
    {
        return $this->columnsMetadata;
    }

    /**
     * Returns metadata for a column, searching by its name.
     *
     * @param string $columnName
     * @return array|null
     */
    public function getColumnMetadata($columnName) 
    {
        if (in_array($columnName, $this->columnsMetadata)) {
            return $this->columnsMetadata[$columnName];
        }
        return null;
    }

}

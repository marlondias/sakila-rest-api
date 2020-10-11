<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\RESTfulModel;
use DateTime;

class RESTfulController extends BaseController
{

    /**
     * All possible suffixes for filtering via query.
     * @var array
     */
    protected $filterQueryModifiers = [
        'equalTo' => '',
        'notEqualTo' => 'not',
        'lessThan' => 'lt',
        'lessThanOrEqualTo' => 'lte',
        'greaterThan' => 'gt',
        'greaterThanOrEqualTo' => 'gte',
        'textContains' => 'contains',
        'textStartsWith' => 'begins',
        'textEndsWith' => 'ends',
    ];

    /**
     * Predefined filter suffixes by data type.
     *
     * @var array
     */
    protected $filterMethodsByColumnType = [
        'boolean' => ['equalTo', 'notEqualTo'],
        'number' => ['equalTo', 'notEqualTo', 'lessThan', 'lessThanOrEqualTo', 'greaterThan', 'greaterThanOrEqualTo'],
        'text' => ['equalTo', 'notEqualTo', 'textContains', 'textStartsWith', 'textEndsWith'],
        'date' => ['equalTo', 'notEqualTo', 'lessThan', 'lessThanOrEqualTo', 'greaterThan', 'greaterThanOrEqualTo'],
        'time' => ['equalTo', 'notEqualTo', 'lessThan', 'lessThanOrEqualTo', 'greaterThan', 'greaterThanOrEqualTo'],
        'datetime' => ['equalTo', 'notEqualTo', 'lessThan', 'lessThanOrEqualTo', 'greaterThan', 'greaterThanOrEqualTo'],
    ];

    /**
     * Generates an array with all the possible filter options.
     * Keys are column names, values are arrays of query options for an URL.
     *
     * @param RESTfulModel $model
     * @return array
     */
    public function getFilterOptions(RESTfulModel $model)
    {
        $options = [];

        foreach ($model->getColumnsMetadata() as $columnName => $metadata) {
            if (!$metadata['filter']['allowed']) {
                continue;
            }

            $columnType = $metadata['type'];
            if (!in_array($columnType, array_keys($this->filterMethodsByColumnType))) {
                continue;
            }

            $queryFilters = [];
            foreach ($this->filterMethodsByColumnType[$columnType] as $method) {
                $suffix = $this->filterQueryModifiers[$method];
                if (!empty($suffix)) {
                    $suffix = "[{$suffix}]";
                }
                $queryFilters[] = "{$columnName}{$suffix}=VALUE";
            }

            if (!empty($queryFilters)) {
                $options[$columnName] = $queryFilters;
            }
        }

        return $options;
    }

    /**
     * Validates a filter query, checking if the key is in the expected 
     * format and if the value is suitable for the data type.
     *
     * @param RESTfulModel $model
     * @param string $queryKey
     * @param string $queryValue
     * @return boolean
     */
    public function validateFilterQuery(RESTfulModel $model, $queryKey, $queryValue)
    {
        if (!is_string($queryKey) || strlen($queryKey) == 0) {
            // Query key is not valid
            return false;
        }

        if (!is_string($queryValue) || strlen($queryValue) == 0) {
            // Query value is not valid
            return false;
        }

        $filterOptions = $this->getFilterOptions($model);

        if (empty($filterOptions)) {
            // Model does not allow any filter
            return false;
        }

        $columnName = '';
        foreach ($filterOptions as $column => $options) {
            $index = array_search("{$queryKey}=VALUE", $options);
            if ($index !== false) {
                $columnName = $column;
                break;
            }
        }

        if (empty($columnName)) {
            // Query key has no correspondence in filterOptions
            return false;
        }

        $metadata = $model->getColumnMetadata($columnName);

        if (isset($metadata['filter']['length'])) {
            $lengths = $metadata['filter']['length'];
            if (is_array($lengths) && count($lengths) == 2) {
                $length = strlen($queryValue);
                if ($length < $lengths[0] || $length > $lengths[1]) {
                    // Length of query value is not allowed
                    return false;
                }    
            }
        }

        if (!isset($metadata['type'])) {
            return false; // must have a type
        }

        // Check if value is valid for the column type
        switch ($metadata['type']) {
            case 'boolean':
                if (!in_array(strtolower($queryValue), ['0', '1', 'false', 'true'])) {
                    // Boolean query with non-boolean value
                    return false;
                }
                break;
            case 'number':
                if (!is_numeric($queryValue)) {
                    return false;
                }
                if (floatval($queryValue) != $queryValue && intval($queryValue) != $queryValue) {
                    // Value does not match numeric conversions, useless in numeric query
                    return false;
                }
                break;
            case 'text':
                if (trim($queryValue) !== $queryValue) {
                    // Should not have leading or trailing spaces
                    return false;
                }
                break;
            case 'date':
                $date = DateTime::createFromFormat('Y-m-d', $queryValue);
                if (!is_object($date)) {
                    // Value is invalid as date using YMD format
                    return false;
                }
                break;
            case 'time':
                $timeA = DateTime::createFromFormat('H:i:s', $queryValue);
                $timeB = DateTime::createFromFormat('H:i', $queryValue);
                if (!is_object($timeA) && !is_object($timeB)) {
                    // Value is invalid as time using standard formats
                    return false;
                }
                break;
            case 'datetime':
                $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $queryValue);
                if (!is_object($dateTime)) {
                    // Value is invalid as date/time using YMDHIS format
                    return false;
                }
                break;
            default:
                return false; // All column types must have some validation defined
                break;
        }

        return true;
    }

    /**
     * Generates an array with all the possible 'orderBy' options.
     * Keys are column names, values are arrays of query options for an URL.
     *
     * @return array
     */
    public function getOrderByOptions(Actor $model)
    {
        $options = [];
        foreach ($model->getColumnsMetadata() as $colName => $metadata) {
            if (!$metadata['orderBy']['allowed']) {
                continue;
            }

            $options[$colName] = [
                "orderByAsc={$colName}",
                "orderByDesc={$colName}",
            ];
        }
        return $options;
    }

    public function validateOrderByQuery()
    {
        //TBD
    }

    protected function processMetadata(Request $request)
    {
        // TBD: Processa dados meta enviados na request
        // Retorna em array para uso interno
        return [];
    }

    protected function processQuery(Request $request, Model $model)
    {
        // TBD: Processa dados de filtragem da request

        // Vai usar o request para obter dados de post ou query.
        // Usa o model para obter as colunas acessíveis ao usuário.
        // Com esses dados, vai montar queries do eloquent e obter o resultado.

        // Retorna em array para uso interno
        return [];
    }

    protected function generatePagination($array)
    {
        // TBD: Cria um array com dados úteis para paginação, baseado em array interno
        return [];
    }

    protected function generateHATEOAS($array)
    {
        // TBD: Cria links relevantes para acesso a outros endpoints, quando possível.
        return [];
    }

    /* Ex:
{
data: {},
metadata: {
totalItems: 999
totalWithThisFilter: 50
pagination: {}
links: {}
queryOptions: {}
}
}

 */

}

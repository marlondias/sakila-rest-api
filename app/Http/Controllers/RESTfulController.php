<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\RESTfulModel;

class RESTfulController extends BaseController
{

    /**
     * All possible suffixes for filtering via query.
     * @var array
     */
    protected $filterQueryModifiers = [
        'equalTo' => '',
        'notEqualTo' => 'ne',
        'lessThan' => 'lt',
        'lessThanOrEqualTo' => 'lte',
        'greaterThan' => 'gt',
        'greaterThanOrEqualTo' => 'gte',
        'textContains' => 'contains',
        'textStartsWith' => 'starts',
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

        foreach ($model->columnsMetadata as $columnName => $metadata) {
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
        $columnName = $queryKey;

        $queryModifier = '';
        $regexForQueryModifier = '/^(.+)\[(\w+)\]/';
        $captureGroups = [];
        if (preg_match($regexForQueryModifier, $queryKey, $captureGroups)) {
            $columnName = $captureGroups[1];
            $queryModifier = $captureGroups[2];
        }

        $metadata = $model->getColumnMetadata($columnName);
        if (empty($metadata)) {
            // Column name is not defined in the model metadata
            return false;
        }

        if (! array_key_exists('filter', $metadata)) {
            // Metadata does not define filter
            return false;
        }

        $filterMetadata = $metadata['filter'];
        if (! array_key_exists('allowed', $filterMetadata) || ! $filterMetadata['allowed']) {
            // Column does not allow filters
            return false;
        }

        $allowedFilterMethods = $this->filterQueryModifiers['equalTo'];

        // Checks if filter modifier is valid for the data type
        if (! empty($queryModifier)) {

            $modifierID = array_search($queryModifier, $this->filterQueryModifiers);
            if ($modifierID == false) {
                // Query modifier in not valid
                return false;
            }

            $dataType = $metadata['type'];
            if (in_array($dataType, array_keys($this->filterMethodsByColumnType))) {
                $allowedFilterMethods = $this->filterMethodsByColumnType[$dataType];
            }

            if (!in_array($modifierID, $allowedFilterMethods)) {
                // Suffix is valid but not allowed
                return false;
            }
        }

        // Checks if value's string length is between limits
        if (array_key_exists('length', $filterMetadata) && count($filterMetadata['length']) == 2) {
            $minLength = $filterMetadata['length'][0];
            $maxLength = $filterMetadata['length'][1];
            $length = strlen($queryValue);
            if ($length < $minLength || $length > $maxLength) {
                return false;
            }
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
        foreach ($model->columnsMetadata as $colName => $metadata) {
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

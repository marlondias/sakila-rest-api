<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;


class RESTfulController extends BaseController
{

    /**
     * All possible suffixes for filtering via query.
     * @var array
     */
    protected $filterMethodSuffixes = [
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

    protected $suffixesByColumnType = [
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
     * @return array
     */
    public function getFilterOptions(Actor $model) 
    {
        $options = [];
        
        foreach ($model->columnsMetadata as $colName => $metadata) {
            if (!$metadata['filter']['allowed']) continue;

            $methods = [];
            foreach ($metadata['filter']['methods'] as $method) {
                if (!in_array($method, $this->filterMethodSuffixes)) continue;

                $suffix = $this->filterMethodSuffixes[$method];
                if (!empty($suffix)) { 
                    $suffix = "[{$suffix}]"; 
                }                
                $methods[] = "{$colName}{$suffix}=VALUE";
            }

            $options[$colName] = $methods;
        }

        return $options;
    }


    public function validateFilterQuery(Actor $model, $queryKey, $queryValue) 
    {
        $columnName = '';
        $suffix = '';

        $regexForSuffix = '/^(.+)\[(\w+)\]/';
        $matches = [];
        if (preg_match($regexForSuffix, $queryKey, $matches)) {
            $columnName = $matches[1];
            $suffix = $matches[2];
        } else {
            $columnName = $queryKey;
        }

        $columnsMeta = $model->columnsMetadata;

        // Checks if column name exists
        if (!in_array($columnName, array_keys($columnsMeta))) return false;

        $metadata = $columnsMeta[$columnName];

        // Checks if column allows filters
        if (!$metadata['filter']['allowed']) return false;

        // Checks if filter suffix is valid for the content type
        if (!empty($suffix)) {

            $methodKey = array_search($suffix, $this->filterMethodSuffixes);
            if ($methodKey == false) {
                // Column exists but suffix is invalid
                return false;
            }

            $type = $metadata['type'];
            $allowedMethods = ['equalTo', 'notEqualTo'];
            if (in_array($type, $this->suffixesByColumnType)) {
                $allowedMethods = $this->suffixesByColumnType[$type];
            }

            if (!in_array($methodKey, $allowedMethods)) {
                // Suffix is valid but not allowed
                return false;
            }

        }

        $filterLength = $metadata['filter']['length'];
        if (strlen($queryValue) < $filterLength[0] || strlen($queryValue) > $filterLength[1]) {
            // Size of value string is not valid
            return false;
        }

        return true;
    }


    /**
     * Generates an array with all the possible 'orderBy' options.
     * Keys are column names, values are arrays of query options for an URL.
     * 
     * @return array
     */
    public function getOrderByOptions(Actor $model) {
        $options = [];
        foreach ($model->columnsMetadata as $colName => $metadata) {
            if (!$metadata['orderBy']['allowed']) continue;
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




    protected function processMetadata (Request $request) {
        // TBD: Processa dados meta enviados na request
        // Retorna em array para uso interno
        return [];
    }

    protected function processQuery(Request $request, Model $model) {
        // TBD: Processa dados de filtragem da request

        // Vai usar o request para obter dados de post ou query.
        // Usa o model para obter as colunas acessíveis ao usuário.
        // Com esses dados, vai montar queries do eloquent e obter o resultado.
        
        // Retorna em array para uso interno
        return [];
    }

    protected function generatePagination($array) {
        // TBD: Cria um array com dados úteis para paginação, baseado em array interno
        return [];
    }

    protected function generateHATEOAS($array) {
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

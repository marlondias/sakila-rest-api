<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;


class RESTfulController extends BaseController
{

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
            }
        }

    */

}

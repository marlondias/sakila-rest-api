<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;

class ActorController extends RESTfulController
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // request is for filters
        return 'read all entities';
    }


    /**
     * Creates a resource based on request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request is for creation
        return 'create one entity';
    }


    /**
     * Returns the specified resource, if found.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return "read entity {$id}";
    }


    /**
     * Modify the specified resource, if found.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modify($id, Request $request)
    {
        return "modify entity {$id}";
    }

    /**
     * Delete the specified resource, if found.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        return "delete entity {$id}";
    }

    /**
     * Used when the method is not allowed on some endpoint.
     *
     * @return \Illuminate\Http\Response
     */
    public function notAllowed()
    {
        return '405: Method not allowed.';
    }


}

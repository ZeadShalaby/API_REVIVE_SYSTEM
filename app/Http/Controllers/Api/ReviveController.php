<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviveController extends Controller
{
    //
     /**
     * todo Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * todo Show the form for creating a new resource.
     * ! only admin can add a new revive hardware
     */
    public function newrevive()
    {
        //
    }

    /**
     *todo Store a newly created resource in storage.
     * !hardware to do this insert 
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * todo Display the specified resource with date not id.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * todo Remove the specified resource from storage.
     * ! only admin can do this
     */
    public function destroy(string $id)
    {
        //
    }

    
    /**
     * todo restore index the specified resource from storage.
     */
    public function restoreindex()
    {
       //
    }

     /**
     * todo  restore the specified resource from storage.
     */
    public function restore()
    {
       //
    }
    
    /**
     * todo Autocomplete Search the specified resource from storage.
     */
    public function autocolmpletesearch()
    {
       //
    }

}
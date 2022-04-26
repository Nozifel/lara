<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCRPRequest;
use App\Http\Requests\UpdateCRPRequest;
use App\Models\CRP;

class CRPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCRPRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCRPRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CRP  $cRP
     * @return \Illuminate\Http\Response
     */
    public function show(CRP $cRP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCRPRequest  $request
     * @param  \App\Models\CRP  $cRP
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCRPRequest $request, CRP $cRP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CRP  $cRP
     * @return \Illuminate\Http\Response
     */
    public function destroy(CRP $cRP)
    {
        //
    }
}

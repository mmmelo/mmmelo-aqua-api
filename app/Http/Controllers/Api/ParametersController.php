<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Life;
use App\Models\Parameters;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Param;

class ParametersController extends Controller
{
    private $parameters;

    public function __construct( Parameters $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Parameters $parameters
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->successResponse( Parameters::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only( $this->parameters->getStoreFields());
        Validator::make( $data, Parameters::rules())->validate();
        try {

//            $life = Life::with('parameters')->findOrFail($data['life_id']);
//            $params = new Parameters($data);
//            $params = $life->parameters()->save($params);
//            return $this->successResponse( $this->parameters->life()->save());

            $life = Life::findOrFail( $data['life_id'])->parameters()->updateOrCreate(['life_id'=>$data['life_id']],$data);

            return $this->successResponse( $life);
            $this->successResponse( $life);
        } catch (\Exception $e){
            return $this->errorResponse( $e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function show(Parameters $parameters)
    {
        return $this->successResponse( $parameters->life()->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function edit(Parameters $parameters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameters $parameters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parameters  $parameters
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameters $parameters)
    {
        //
    }
}

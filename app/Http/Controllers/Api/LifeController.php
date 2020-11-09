<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Life;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LifeController extends Controller
{

    private $life;

    public function __construct(Life $life)
    {
        $this->life = $life;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $life = Life::all();
        return $this->successResponse( $life);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only( $this->life->getFillable());
        Validator::make( $data, Life::rules())->validate();
        try {
            return $this->successResponse($this->life->create($data));
        } catch ( QueryException $e) {
            return $this->queryError( $e);
        } catch ( \Exception $e) {
            return $this->errorResponse( $e->getMessage(), ['code'=> $e->getCode()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->errorResponse( Response::$statusTexts[500]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Life  $life
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->successResponse( Life::findOrFail($id)->only($this->life->getFillable()));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Life  $life
     * @return \Illuminate\Http\Response
     */
    public function edit(Life $life)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Life  $life
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Life $life)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Life  $life
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Life $life)
    {
        return $this->successResponse($life->delete());
    }

    public function parameters( $id) {
        return $this->successResponse( Life::with( 'parameters')->find( $id));
    }
}

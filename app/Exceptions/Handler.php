<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

     use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Only for the API
        if( $request->is('api/*')) {
            return $this->handleApiExceptions( $request, $exception);
        }
        return parent::render($request, $exception);
    }

    private function handleApiExceptions( $request, Throwable $exception) {

        if ( $exception instanceof NotFoundHttpException) {
            return $this->errorResponse( "The Specified URL or Route doesn't exist!", [],404);
        }

        if($exception instanceof QueryException){
            $errorCode = $exception->errorInfo[1];
            if($errorCode == 1451){
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource', 409);

            }
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse( 'Data not found!', [], 404);
        }

        if ($exception instanceof ValidationException) {
            return $this->errorResponse( $exception->getMessage(), $exception->validator->getMessageBag(), 422);
        }

        return $this->errorResponse( $exception->getMessage(), ['code'=>$exception->getCode()], 404);
    }
}

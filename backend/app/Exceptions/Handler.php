<?php

namespace App\Exceptions;

use http\Client\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    public const LOGICAL_ERROR = 'LOGICAL';

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\Response|Application|Response|ResponseFactory
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): \Illuminate\Http\Response|Application|Response|ResponseFactory
    {
        if ($this->shouldReturnJson($request, $e)) {
            if ($e instanceof LogicException) {
                return $this->apiLogicalException($e);
            }
        }

        return parent::render($request, $e);
    }

    /**
     * @param LogicException $e
     * @return \Illuminate\Http\Response|Application|ResponseFactory
     */
    private function apiLogicalException(
        LogicException $e
    ): \Illuminate\Http\Response|Application|ResponseFactory {
        return response([
            'code' => Handler::LOGICAL_ERROR,
            'message' => $e->getMessage(),
        ], Response::HTTP_BAD_REQUEST);
    }
}

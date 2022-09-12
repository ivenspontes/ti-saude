<?php

namespace App\Exceptions;

use App;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Psr\Log\LogLevel;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\Response|JsonResponse|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        if ($request->expectsJson()) {
            if ($e instanceof ModelNotFoundException)
                return new JsonResponse([
                    'message' => "Unable to locate the {$this->prettyModelNotFound($e)} you requested."
                ], 404);
        }

        if ($e instanceof ModelNotFoundException)
            throw new NotFoundHttpException("Unable to locate the {$this->prettyModelNotFound($e)} you requested.");

        return parent::render($request, $e);
    }

    /**
     * @param Throwable $exception
     * @return string
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function prettyModelNotFound(Throwable $exception): string
    {
        try {
            return Str::lower(
                ltrim(
                    preg_replace(
                        '/[A-Z]/',
                        ' $0',
                        (new ReflectionClass($exception->getModel()))->getShortName()
                    )
                )
            );
        } catch (ReflectionException $e) {
            report($e);
        }
        return 'resource';
    }
}

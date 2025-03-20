<?php

use App\Http\Middleware\EnforceJsonResponse;
use App\Services\ExceptionApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prependToGroup("api", EnforceJsonResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $apiResponse = new ExceptionApiResponse();

        $exceptions->render(
            fn(ValidationException $exception) => $apiResponse->respondValidationErrors($exception)
        );

        $exceptions->render(
            fn(PostTooLargeException $exception) => $apiResponse->respondError(
                "Size of attached file should be less ".ini_get("upload_max_filesize")."B",
                $exception,
                400
            )
        );

        $exceptions->render(
            fn(AccessDeniedHttpException $exception) => $apiResponse->respondForbidden(
                "You do not have permission to perform this action!")
        );

        $exceptions->render(
            fn(AuthenticationException $exception) => $apiResponse->respondUnAuthorized(
                "Unauthenticated or Token Expired, Please Login!")
        );

        $exceptions->render(
            fn(ThrottleRequestsException $exception) => $apiResponse->respondError(
                "Too Many Requests,Please Slow Down", $exception, 429)
        );

        $exceptions->render(fn(ModelNotFoundException $exception) => $apiResponse->respondNotFound(
            'Entry not found for the '.strtolower(str_replace('App\\Models\\', "", $exception->getModel())),
            $exception)
        );

        $exceptions->render(
            fn(NotFoundHttpException $exception) => $apiResponse->respondNotFound(
                "The requested route or resource could not be found",
                $exception)
        );

        $exceptions->render(
            fn(QueryException $exception) => $apiResponse->respondQueryException($exception)
        );
    })
//    ->withSchedule(function (Schedule $scheduler) {})
    ->create();

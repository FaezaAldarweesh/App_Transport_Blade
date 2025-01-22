<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        Log::error('Exception occurred', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'exception' => $e
        ]);

        // Not Found Exception (Model or Route)
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->formatErrorResponse('لم يتم العثور على النموذج المطلوب.', 404);
        }


        // Method Not Allowed
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->formatErrorResponse('لا يُسمح بطريقة HTTP لهذا المسار.', 405);
        }
        // Access Denied
        if ($e instanceof UnauthorizedHttpException || $e instanceof AccessDeniedHttpException || $e instanceof UnauthorizedException) {
            return $this->formatErrorResponse('لا يجوز لك القيام بهذا الإجراء.', 403);
        }

        if ($e instanceof AuthorizationException) {
            return $this->formatErrorResponse('ليس لديك الإذن للوصول إلى هذا المورد.', 403);
        }

        if ($e instanceof AuthenticationException) {
            return $this->formatErrorResponse('لا يوجد مصادقة، الرجاء تسجيل الدخول.', 401);
        }

        // Too Many Requests
        if ($e instanceof ThrottleRequestsException) {
            return $this->formatErrorResponse('هناك الكثير من الطلبات على التطبيق. يرجى التمهل.', 429);
        }

        // Bad Request
        if ($e instanceof BadRequestHttpException) {
            return $this->formatErrorResponse('طلب خاطئ. يرجى التحقق من إدخالك.', 400);
        }

        // Unsupported Media Type
        if ($e instanceof UnsupportedMediaTypeHttpException) {
            return $this->formatErrorResponse('نوع الوسائط غير مدعوم.', 415);
        }

        // Query Exception
        if ($e instanceof QueryException) {
            return $this->formatErrorResponse('حدث خطأ في استعلام قاعدة البيانات.', 500);
        }

        // Exception
        if ($e instanceof \Exception) {
            return $this->formatErrorResponse($e->getMessage(), 500);
        }

        // General Unexpected Errors
        if (config('app.debug')) {
            return parent::render($request, $e); // Default Laravel error page for debugging
        }

        return $this->formatErrorResponse('حدث خطأ غير متوقع.', 500);
    }

    /**
     * Format the error response for JSON output.
     */
    protected function formatErrorResponse(string $message, int $statusCode, $errors = null)
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}

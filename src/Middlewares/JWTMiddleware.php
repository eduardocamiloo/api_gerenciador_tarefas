<?php

namespace Src\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

// Ainda não funciona.
class JWTMiddleware {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        // ....

        return $handler->handle($request);
    }
}
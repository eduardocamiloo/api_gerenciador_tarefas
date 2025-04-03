<?php

namespace Src\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;

class RemoveLastBar {
    public function __invoke(Request $request, RequestHandler $handler): Response {
        $objetoUri = $request->getUri();
        $rotaRequisitada = $objetoUri->getPath();

        if ($rotaRequisitada !== '/' && substr($rotaRequisitada, -1) === '/') {
            return $handler->handle($request->withUri($objetoUri->withPath(rtrim($rotaRequisitada, '/'))));
        }

        return $handler->handle($request);
    }
}
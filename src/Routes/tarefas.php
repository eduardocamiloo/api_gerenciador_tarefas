<?php

use Slim\App;
use Src\Controllers\Tarefas;

return function (App $app) {
    $app->get("/tarefas", [Tarefas::class, "index"]);
    $app->post("/tarefas", [Tarefas::class, "create"]);
    $app->get("/tarefas/{id_tarefa}", [Tarefas::class, "getByid"]);
    $app->delete("/tarefas/{id_tarefa}", [Tarefas::class, "delete"]);
    $app->patch("/tarefas/{id_tarefa}", [Tarefas::class, "update"]);
}

?>

<?php

namespace Src\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Src\Models\Tarefa;
use Rakit\Validation\Validator;

final class Tarefas
{
    /*
        C = Create
        R = Read
        U = Update
        D = Destroy
    */

    public function index(Request $request, Response $response)
    {
        $tarefasModel = new Tarefa();
        $allTarefas = $tarefasModel->all();

        $response->getBody()->write(json_encode(["data" => $allTarefas]));

        return $response->withHeader("Content-Type", "application/json");
    }

    public function getById(Request $request, Response $response, array $args)
    {
        $idTarefa = filter_var($args["id_tarefa"], FILTER_SANITIZE_NUMBER_INT);

        if ($idTarefa) {
            $tarefasModel = new Tarefa();
            $selectedTarefa = $tarefasModel->getById($idTarefa);

            if ($selectedTarefa) {
                $response->getBody()->write(json_encode(["data" => $selectedTarefa]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(["error" => "Tarefa não encontrada"]));
                return $response->withStatus(404)->withHeader("Content-Type", "application/json");
            }
        } else {
            $response->getBody()->write(json_encode(["error" => "ID da tarefa é inválido"]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }
    }

    public function create(Request $request, Response $response)
    {
        $validator = new Validator();
        $validator->setMessages(require "lang/pt.php");

        $postParams = $request->getBody()->getContents();
        $postParams = json_decode($postParams, true);
        $postParams = filter_var_array($postParams, FILTER_SANITIZE_SPECIAL_CHARS);
        $data = [];

        $data["title"] = filter_var($postParams["title"] ?? "", FILTER_SANITIZE_SPECIAL_CHARS);
        $data["description"] = filter_var($postParams["description"] ?? "", FILTER_SANITIZE_SPECIAL_CHARS);
        $data["isCompleted"] = filter_var($postParams["isCompleted"] ?? "0", FILTER_SANITIZE_NUMBER_INT);

        $validation = $validator->make($data, [
            "title" => "required|min:3|max:255",
            "description" => "required|min:3|max:255",
            "isCompleted" => "required|boolean"
        ]);

        $validation->setAliases([
            "title" => "Título",
            "description" => "Descrição",
            "isCompleted" => "Status"
        ]);

        $validation->validate();

        if (!$validation->fails()) {
            $tarefasModel = new Tarefa();

            $tarefaIsCreated = $tarefasModel->create($data);

            if ($tarefaIsCreated) {
                $response->getBody()->write(json_encode(["message" => "Tarefa criada com sucesso!"]));
                return $response->withHeader("Content-Type", "application/json")->withStatus(201);
            } else {
                $response->getBody()->write(json_encode(["error" => "Não foi possível criar a tarefa"]));
                return $response->withStatus(500)->withHeader("Content-Type", "application/json");
            }
        } else {
            $response->getBody()->write(json_encode(["error" => ["message" => "Os dados recebidos não são válidos para a criação de uma tarefa", "errors" => $validation->errors()->firstOfAll()]]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }
    }

    public function update(Request $request, Response $response, array $args)
    {
        $idTarefa = filter_var($args["id_tarefa"], FILTER_SANITIZE_NUMBER_INT);
        $patchParams = $request->getBody()->getContents();
        $patchParams = json_decode($patchParams, true) ?? null;

        if(!$patchParams) {
            $response->getBody()->write(json_encode(["error" => "Nenhum parâmetro para atualização foi informado"]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        $patchParams = filter_var_array($patchParams, FILTER_SANITIZE_SPECIAL_CHARS);

        $selectedParams = "";

        if(isset($patchParams["title"])) {
            $selectedParams .= "title = :title";
        }
        if(isset($patchParams["description"])) {
            $selectedParams .= ($selectedParams) ? ", description = :description" : "description = :description";
        }
        if(isset($patchParams["isCompleted"])) {
            $selectedParams .= ($selectedParams) ? ", isCompleted = :isCompleted" : "isCompleted = :isCompleted";
        }

        if(!$selectedParams) {
            $response->getBody()->write(json_encode(["error" => "Nenhum parâmetro válido para atualização foi informado"]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        $selectedParams .= ", updated_at = NOW()";

        if($idTarefa) {
            $tarefasModel = new Tarefa();
            $selectedTarefaToUpdate = $tarefasModel->update($idTarefa, $selectedParams, $patchParams);

            if ($selectedTarefaToUpdate) {
                $response->getBody()->write(json_encode(["message" => "Tarefa atualizada com sucesso!"]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(["error" => "Não foi possível atualizar a tarefa"]));
                return $response->withStatus(500)->withHeader("Content-Type", "application/json");
            }
        } else {
            $response->getBody()->write(json_encode(["error" => "ID da tarefa é inválido"]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $idTarefa = filter_var($args["id_tarefa"], FILTER_SANITIZE_NUMBER_INT);

        if ($idTarefa) {
            $tarefasModel = new Tarefa();

            $tarefaIsDeleted = $tarefasModel->delete($idTarefa);

            if ($tarefaIsDeleted) {
                $response->getBody()->write(json_encode(["message" => "Tarefa deletada com sucesso!"]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(["error" => "Não foi possível deletar a tarefa"]));
                return $response->withStatus(500)->withHeader("Content-Type", "application/json");
            }
        } else {
            $response->getBody()->write(json_encode(["error" => "ID da tarefa é inválido"]));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }
    }
}

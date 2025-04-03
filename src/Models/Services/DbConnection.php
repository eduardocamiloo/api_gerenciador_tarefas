<?php

namespace Src\Models\Services;

use PDO;
use PDOException;

/**
 * Classe abstrata para guardar a conexão com o banco de dados.
 * - Pega os dados do DB no .env e guarda a conexão.
 */
abstract class DbConnection {
    /** Guarda a conexão com o banco de dados. @var object */
    public object $connection;

    /** Recebe o ENV do HOST do DB. @var string */
    private string $dbHost;

    /** Recebe o ENV da PORTA do DB. @var string */
    private string $dbPort;

    /** Recebe o ENV do NOME do DB. @var string */
    private string $dbName;

    /** Recebe o ENV do USERNAME do usuário do DB. @var string */
    private string $dbUser;

    /** Recebe o ENV do PASSWORD do usuário do DB. @var string */
    private string $dbPassword;

    /**
     * Faz a definição de atributos com os dados que estão no .env.
     */
    public function __construct() {
        // Definição dos atributos.
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbPort = $_ENV['DB_PORT'];
        $this->dbName = $_ENV['DB_NAME'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPassword = $_ENV['DB_PASS'];
    }

    /**
     * Instancia o PDO e guarda a conexão em um atributo.
     *
     * @return object|bool
     */
    public function getConnection():object|bool {
        // Tenta fazer a conexão com um try-catch.
        try{
            // Instancia do PDO.
            $this->connection = new PDO("mysql:host=$this->dbHost;port=$this->dbPort;dbname=$this->dbName", $this->dbUser, $this->dbPassword);

            // Retorna a conexão para o uso nas Models.
            return $this->connection;
        } catch (PDOException $e) {
            // Caso a conexão não seja bem sucedida, gerar um log de emergência, pois o banco de dados não está conectado.
            return false;
        }
    }
}
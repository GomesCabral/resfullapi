<?php

    declare(strict_types=1);

    // VAI CHAMAR AS MINHAS CLASSES AUTOMATICAMENTE
    require dirname(__DIR__) . "/vendor/autoload.php";

    set_exception_handler("ErrorHandler::handleException");

    // CONNECTAR A DB COM phpdotenv
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    // CARREGA AS VARIAVEIS PARA PHP ENV SUPER GLOBAL
    $dotenv->load();

    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    $parts = explode("/", $path);

    $resource = $parts[4];

    $id = $parts[5] ?? null;


    if($resource != "tasks"){
        
        // header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
        http_response_code(404);
        exit;
    }

    // NO RESPONSE DO HEADER, O CONTENT TYPE VEM EM JSON
    header("Content-Type: application/json; charset=UTF-8");

    // $database = new Database("localhost", "api_db", "root", "");
    // $database->getConnection();

    $database = new Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]);
    
    $task_gateway = new TaskGateway($database);

    $controller = new TaskController($task_gateway);
    $controller->processRequest($_SERVER['REQUEST_METHOD'], $id);
?>
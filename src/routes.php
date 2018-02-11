<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    $this->logger->info("Slim-Skeleton '/' route");

    $sexo = new Sexo($this->db);

    $this->logger->info(json_encode($sexo->lista()));

    // Render index view
    return $this->renderer->render($response, 'default.php', $args);
});

$app->get('/inicial',function ($request, $response, $args){ //Página Inicial
	$this->logger->info("'/inicial' route");

	return $this->renderer->render($response, 'inicial.php', $args);
});

$app->get('/cadastrar',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/cadastrar' route");
	$sexo = new Sexo($this->db);
	$result = $sexo->lista();

    return $this->renderer->render($response, 'cadastrar.php', ['sexo' => $result]);
       
});

$app->post('/insert',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/insert' route");
	
	/*$allPostPutVars = $request->getParsedBody();
	foreach($allPostPutVars as $key => $param){
	   $this->logger->info("Key: " . $key . " Param: " . $param);
	}
	
	$this->logger->info($allPostPutVars['insert_nascimento']);*/

    return $this->renderer->render($response, 'cadastrar.php', ['type' => $response]);
       
});

?>

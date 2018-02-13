<?php

use Slim\Http\Request;
use Slim\Http\Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    $this->logger->info("Slim-Skeleton '/' route");

    return $this->renderer->render($response, 'default.php');
});

$app->get('/inicial',function ($request, $response, $args){ //Página Inicial
	$this->logger->info("'/inicial' route");

	return $this->renderer->render($response, 'inicial.php', $args);
});

$app->get('/cadastrar',function ($request, $response, $args) { //Exibir opções para cadastrar
	$this->logger->info("'/cadastrar' route");
	$sexo = new Sexo($this->db);
	$result = $sexo->lista();

    return $this->renderer->render($response, 'cadastrar.php', ['sexo' => $result]);
       
});

$app->post('/insert',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/insert' route");

	$pessoa = new Pessoa($this->db);
	$endereco = new Endereco($this->db);
	
	$form = $request->getParsedBody();

	//monta obj endereco
	$this->logger->info("Monta obj endereço ");
	$endereco->cep = $form['insert_cep'];
	$endereco->logradouro = $form['insert_logradouro'];
	$endereco->bairro = $form['insert_bairro'];
	$endereco->cidade = $form['insert_cidade'];
	$endereco->estado = $form['insert_estado'];

	//insert endereço
	$e = $endereco->insert();

	$this->logger->info("Inseriu endereço: " . $e);

	//monta obj pessoa
	$this->logger->info("Monta obj pessoa ");
	$pessoa->id_endereco = $endereco->getID($form['insert_cep']);
	$pessoa->nome = $form['insert_nome'];
	$pessoa->nascimento = $form['insert_nascimento'];
	$pessoa->cpf = $form['insert_cpf'];
	$pessoa->email = $form['insert_email'];
	$pessoa->end_numero = $form['insert_end_numero'];
	$pessoa->id_sexo = $form['insert_id_sexo'];

	//inserir pessoa
	$e = $pessoa->insert();

	$this->logger->info("Inseriu pessoa: " . $e);


	$result = Array("message" => "", "error" => "");
	$result["message"] = ($e != 'ok' ? 'Erro ao realizar cadastro. Verifique se email já foi cadastrado anteriormente.' : 'Cadastro realizado com sucesso.');
	$result["error"] = $e;

    return json_encode($result);
       
});

$app->post('/enviaEmailCadastro',function ($request, $response, $args) { //Enviar email para usuários recém-cadastrados
	$this->logger->info("'/enviar email' route");

	$emailUser = $request->getParsedBody();

	if(empty($this->email['Username']) && empty($this->email['Password'])){
		$this->logger->info('Configurações de email não configuradas. Mensagem não enviada.');
	}
	else{
		try{
		    //Create a new PHPMailer instance
			$mail = new PHPMailer();

			$mail->CharSet = 'UTF-8';

			$mail->isSMTP();
			$mail->Host = $this->email['Host'];
			$mail->Port = $this->email['Port'];
			$mail->SMTPSecure = $this->email['SMTPSecure'];
			$mail->SMTPAuth = $this->email['SMTPAuth'];
			$mail->Username = $this->email['Username'];
			$mail->Password = $this->email['Password'];
			$mail->setFrom($this->email['setFrom'][0], $this->email['setFrom'][1]);
			$mail->addReplyTo($this->email['addReplyTo'][0], $this->email['addReplyTo'][0]);

			$this->logger->info("configurou sender");

			$mail->addAddress($emailUser['email'], $emailUser['nome']);

			$this->logger->info("configurou receiver");

		    $mail->isHTML(true);
		    $mail->Subject = 'Sistema CRUD Aparece 2018';
		    $mail->Body    = "
		        <p>Olá, " . $emailUser['nome'] . ".</p>
		        <p>            
		        Parabéns, seu cadastro foi realizado com sucesso.
		        </p>
		       ";

		    $mail->send();
		    $this->logger->info('Mensagem enviada');
		} 
		catch (Exception $e) { 
		        $this->logger->info('Mailer Error: ' . $mail->errorMessage());
		}
	}

       
});

$app->get('/listar',function ($request, $response, $args){ //Lista de usuários
	$this->logger->info("'/listar' route");

	$relatorio = new Relatorio($this->db);

	$result = $relatorio->lista();

	return $this->renderer->render($response, 'listar.php', ['users' => $result]);
});

$app->get('/editar',function ($request, $response, $args){ //Exibir opções de usuários para serem editados
	$this->logger->info("'/editar' route");

	$pessoa = new Pessoa($this->db);

	$resultNome = $pessoa->listaNomeCPFPor("nome");
	$resultCPF = $pessoa->listaNomeCPFPor("cpf");

	return $this->renderer->render($response, 'editar.php', ['pessoasNome' => $resultNome, 'pessoasCPF' => $resultCPF]);
});

$app->get('/deletar',function ($request, $response, $args){ //Exibir opções de usuários para serem editados
	$this->logger->info("'/deletar' route");

	$pessoa = new Pessoa($this->db);

	$resultNome = $pessoa->listaNomeCPFPor("nome");
	$resultCPF = $pessoa->listaNomeCPFPor("cpf");

	return $this->renderer->render($response, 'deletar.php', ['pessoasNome' => $resultNome, 'pessoasCPF' => $resultCPF]);
});

$app->post('/procuraPessoa',function ($request, $response, $args){ //Exibir opções de usuário
	$this->logger->info("'/procuraPessoa' route");

	$form = $request->getParsedBody();

	if($form['id'] != "-1"){
		$pessoa = new Pessoa($this->db);
		$endereco = new Endereco($this->db);
		$sexo = new Sexo($this->db);

		$resultPessoa = $pessoa->selectSingle($form['id']);
		$resultEndereco = $endereco->selectSingle($resultPessoa['id_endereco']);
		$resultSexo = $sexo->lista();

		return $this->renderer->render($response, 'editar_pessoa.php', ['pessoa' => $resultPessoa, 'endereco' => $resultEndereco, 'sexo' => $resultSexo]);
	}
	else{
		return $this->renderer->render($response, 'blank.php');
	}
});

$app->post('/procuraPessoaDelete',function ($request, $response, $args){ //Exibir opções de usuário
	$this->logger->info("'/procuraPessoaDelete' route");

	$form = $request->getParsedBody();

	if($form['id'] != "-1"){
		$pessoa = new Pessoa($this->db);
		$endereco = new Endereco($this->db);
		$sexo = new Sexo($this->db);

		$resultPessoa = $pessoa->selectSingle($form['id']);
		$resultEndereco = $endereco->selectSingle($resultPessoa['id_endereco']);
		$resultSexo = $sexo->lista();

		return $this->renderer->render($response, 'deletar_pessoa.php', ['pessoa' => $resultPessoa, 'endereco' => $resultEndereco, 'sexo' => $resultSexo]);
	}
	else{
		return $this->renderer->render($response, 'blank.php');
	}
});

$app->post('/update',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/insert' route");

	$pessoa = new Pessoa($this->db);
	$endereco = new Endereco($this->db);
	
	$form = $request->getParsedBody();

	//monta obj endereco
	$this->logger->info("Monta obj endereço ");
	$endereco->cep = $form['update_cep'];
	$endereco->logradouro = $form['update_logradouro'];
	$endereco->bairro = $form['update_bairro'];
	$endereco->cidade = $form['update_cidade'];
	$endereco->estado = $form['update_estado'];

	//insert endereço
	$e = $endereco->insert();

	$this->logger->info("Atualizou endereço: " . $e);

	//monta obj pessoa
	$this->logger->info("Monta obj pessoa ");

	$this->logger->info("Sexo:  " . $form['update_id_sexo']);

	$pessoa->id_endereco = $endereco->getID($form['update_cep']);
	$pessoa->nome = $form['update_nome'];
	$pessoa->nascimento = $form['update_nascimento'];
	$pessoa->cpf = $form['update_cpf'];
	$pessoa->email = $form['update_email'];
	$pessoa->end_numero = $form['update_end_numero'];
	$pessoa->id_sexo = $form['update_id_sexo'];
	$pessoa->ativo = ($form['update_ativo'] == "on" ? 1 : 0);

	//atualizar pessoa
	$e = $pessoa->update($form['update_id']);

	$this->logger->info("Atualizou pessoa: " . $e);


	$result = Array("message" => "", "error" => "");
	$result["message"] = ($e != 'ok' ? 'Erro ao realizar atualização.' : 'Atualização realizada com sucesso.');
	$result["error"] = $e;

    return json_encode($result);
       
});

$app->delete('/delete/{id}',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/delete' route");

	$pessoa = new Pessoa($this->db);

	$this->logger->info("id: " . $args['id']);
	
	//deletar pessoa
	$e = $pessoa->delete($args['id']);

	$this->logger->info("Deletou pessoa: " . $e);


	$result = Array("message" => "", "error" => "");
	$result["message"] = ($e != 'ok' ? 'Erro ao excluir.' : 'Exclusão realizada com sucesso.');
	$result["error"] = $e;

    return json_encode($result);
       
});

$app->get('/relatorios/sexo/[{cidade}]',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/relatorio sexo' route");

	$relatorio = new Relatorio($this->db);

	$cidade = (( empty($args['cidade']) || $args['cidade'] == "-1")  ? null : $args['cidade']);

	$this->logger->info("cidade: " . $cidade);
	
	//relatorio sexo
	$result = $relatorio->countSexo($cidade);

	$this->logger->info("Contou sexo");

	return $this->renderer->render($response, 'relatorios_sexo.php', ['countSexo' => $result]);
       
});

$app->get('/relatorios/inativo/[{cidade}]',function ($request, $response, $args) { //Cadastrar Usuários
	$this->logger->info("'/relatorio inativo' route");

	$relatorio = new Relatorio($this->db);

	$cidade = (( empty($args['cidade']) || $args['cidade'] == "-1")  ? null : $args['cidade']);

	$this->logger->info("cidade: " . $cidade);
	
	//relatorio inativo
	$result = $relatorio->countInativo($cidade);

	$this->logger->info("Contou inativo");

	return $this->renderer->render($response, 'relatorios_inativo.php', ['countInativo' => $result]);
       
});

$app->get('/relatorios',function ($request, $response, $args){ //Exibir opções de usuários para serem editados
	$this->logger->info("'/relatorios' route");

	$endereco = new Endereco($this->db);

	$result = $endereco->listaCidade();

	return $this->renderer->render($response, 'relatorios.php', ['cidades' => $result]);
});

?>

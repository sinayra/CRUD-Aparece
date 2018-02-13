<?php

use Slim\Http\Request;
use Slim\Http\Response;

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

///////////////// ARRUMAR EMAIL /////////////////
$app->post('/enviaEmailCadastro',function ($request, $response, $args) { //Enviar email para usuários recém-cadastrados
	$this->logger->info("'/enviar email' route");

	$emailUser = $request->getParsedBody();

    $mail = new PHPMailer;

    try {

    //Tell PHPMailer to use SMTP
	$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 2;
	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';
	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;
	//Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	//Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = "sinayra.moreira@gmail.com";
	//Password to use for SMTP authentication
	$mail->Password = "Inu-Yasha1";
	//Set who the message is to be sent from
	$mail->setFrom('from@example.com', 'First Last');
	//Set an alternative reply-to address
	$mail->addReplyTo('replyto@example.com', 'First Last');
	//Set who the message is to be sent to
	$mail->addAddress('whoto@example.com', 'John Doe');

    $mail->isHTML(true);

    $mail->Subject = 'Sistema CRUD Aparece 2018';
    $mail->Body    = "
        <p>Olá, " . $emailUser['nome'] . "</p>,
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

?>

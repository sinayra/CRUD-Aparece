<?php
//Autoload
require_once __DIR__ . '/vendor/autoload.php';

/////// Configuração ///////
$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' =>'./logs/app.log',
        ],
    ],
];

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";
$config['db']['dbname'] = "aparece";

//Instanciando objeto
$app = new \Slim\App($config);

//Container
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = new \Slim\Views\PhpRenderer('templates/');


/////// Rotas ///////

$app->get('/',function ($request, $response, $args){ //index.php
    $this->logger->addInfo('index');
    $this->view->render($response, 'default.php');
});

$app->get('/inicial',function ($request, $response, $args){ //Página Inicial
        $this->logger->addInfo('Página inicial');
        $pessoa = new \controllers\Pessoa($this->db);
        $result = $pessoa->teste();

       $this->view->render($response, 'inicial.php', ['result' => $result]);
});

$app->get('/cadastrar',function ($request, $response, $args) { //Cadastrar Usuários
        $this->logger->addInfo('Cadastrar');
        //$sexo = new \controllers\Sexo($this->db);

        $sth = $this->db->prepare("SELECT * FROM sexo");
        $this->logger->addInfo("sth: " . $result);

            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);


        $this->logger->addInfo($result);

        $this->view->render($response, 'cadastrar.php', ['result' => $result]);
});

$app->get('/listar',function ($request, $response, $args) { //Listar Usuários
        $this->logger->addInfo('Listar');
        $sth = $this->db->prepare("SELECT * FROM sexo");
        $sth->execute();
        $todos = $sth->fetchAll();

        $this->logger->addInfo($todos);

        $this->view->render($response, 'listar.php', ['result' => $todos]);
});

$app->get('/editar',function ($request, $response, $args) { //Editar Usuários
        $this->logger->addInfo('Editar');
        $pessoa = new \controllers\Pessoa($this->db);
        $result = $pessoa->teste();


        $this->view->render($response, 'editar.php', ['result' => $result]);
});

$app->get('/deletar',function ($request, $response, $args){ //Deletar Usuários
        $this->logger->addInfo('Deletar');
        $pessoa = new \controllers\Pessoa($this->db);
        $result = $pessoa->teste();


        $this->view->render($response, 'deletar.php', ['result' => $result]);
});

$app->get('/relatorios',function ($request, $response, $args) { //Deletar Usuários
        $this->logger->addInfo('Relatórios');
        $pessoa = new \controllers\Pessoa($this->db);
        $result = $pessoa->teste();


        $this->view->render($response, 'relatorios.php', ['result' => $result]);
});

/*
//Listando todas
$app->get('/pessoas/', function() use ($app){
    (new \controllers\Pessoa($app))->lista();
});

//get pessoa
$app->get('/pessoas/:id', function($id) use ($app){
    (new \controllers\Pessoa($app))->get($id);
});

//nova pessoa
$app->post('/pessoas/', function() use ($app){
    (new \controllers\Pessoa($app))->nova();
});

//edita pessoa
$app->put('/pessoas/:id', function($id) use ($app){
    (new \controllers\Pessoa($app))->editar($id);
});

//apaga pessoa
$app->delete('/pessoas/:id', function($id) use ($app){
    (new \controllers\Pessoa($app))->excluir($id);
});
*/
//Rodando aplicação
$app->run();
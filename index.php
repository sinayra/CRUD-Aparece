<?php
//Autoload
require_once __DIR__ . '/vendor/autoload.php';

//config
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

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'aparece_usr';
$config['db']['pass']   = '123456';
$config['db']['dbname'] = 'aparece';

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

$Pessoa = new \controllers\Pessoa($container['db']);


/////// Rotas ///////

$app->get('/',function ($request, $response, $args) use ($Pessoa, $container){ //index.php
        $this->logger->addInfo('Página inicial');
        $result = $Pessoa->teste();

        $container['view']->render($response, 'default.php', ['result' => $result]);
});

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

//Rodando aplicação
$app->run();
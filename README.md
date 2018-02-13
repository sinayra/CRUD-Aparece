# Processo Seletivo Aparece Brasil

Sistema de cadastro, busca, remoção e atualização de usuários utilizando PHP, MySQL, HTML, CSS e Javascript. Esse sistema CRUD possui uma tela de exibição de relatórios.

## Para rodar localmente

Certifique-se que o Apache e o MySQL estão rodando através do painel de controle do XAMPP.

Coloque os códigos-fonte deste projeto em uma nova pasta dentro da pasta *path/to/xampp/htdocs*. 

Na pasta *path/to/xampp/htdocs/CRUD_Aparece/src*, existe um arquivo de configuração **settings.php**, onde deverá ser editado de acordo com as configurações do banco e do email. Por padrão, as configurações de enviar utiliza o servidor do GMail, bastando adicionar um *Username* e um *Password* nos campos indicados entre aspas.

```
//Database settings
'db' =>[
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'dbname' => 'aparece'
],

// Email settings
'email' => [
    'Port' => 587,
    'Host' => 'smtp.gmail.com',
    'SMTPSecure' => 'tls',
    'SMTPAuth' => true,
    'Username' => 'xxxxxxxxxx@gmail.com',
    'Password' => 'xxxxxxxxxx',
    'setFrom' => ['admin@aparecefake.com.br', 'Fake Admin'],
    'addReplyTo' => ['replyto@aparecefake.com.br', 'Fake Admin Reply']
],
```

Na pasta raiz do projeto, inicialize o servidor PHP com
```
composer start
```

Acesse o sistema com o URL
```
http://localhost:8080/
```

### Pré-requisitos

- [Xampp PHP 7.2.1](https://www.apachefriends.org/pt_br/download.html)
- [Composer](https://getcomposer.org/download/)

Na pasta raiz, execute o Composer para instalar todas as demais depedências
```
composer install
```

## Informações adicionais

### Ambiente de desenvolvimento

- Sistema Operacional: Windows 10 64bits
- Versão PHP: 7.2.1
- Versão Xampp: 3.2.2
- Versão Composer: 1.6.3

## Desenvolvido com

* [Slim v2](https://www.slimframework.com) - Micro-framework utilizado
* [Bootstrap - Example Dashboard](https://getbootstrap.com/docs/4.0/examples/dashboard/) - Tema utilizado
* [Slim Skeleton](https://github.com/slimphp/Slim-Skeleton) - Setup

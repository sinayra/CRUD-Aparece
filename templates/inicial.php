<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1>Página Inicial</h1>
</div>

  <h4>Modelo relacional</h4>
   <img src="img/banco.png" class="img-rounded" alt="Modelo relacional"> 

   <h4>Funcionalidades</h4>
   <p>
    <ul>
      <li>Arquitetura MVC;</li>
      <li>Cadastro, atualização, visualização e remoção de usuários;</li>
      <li>Endereços baseados pelo CEP utilizando API VIACep com o plugin <a href="https://github.com/arthurfigueiredo/autocomplete-address">autocomplete-address</a>; e</li>
      <li>Filtros de pesquisa de cidades para visualização de relatórios.</li>
    </ul>
   </p>

   <h4>Cadastrar Usuários</h4>
   <p>Página responsável pelo cadastro de usuários e atualização de endereços, ativando usuário no momento do cadastro e enviando um email de confirmação de cadastro, utilizando a biblioteca PHPMailer. Se cep não está cadastrado no sistema, então insere-se novo endereço. Se email já está cadastrado no sistema, exibe-se uma mensagem de erro.</p>

   <h4>Editar Usuários</h4>
   <p>Exibe uma busca de usuários por nome ou por CPF para, em seguida, permitir alteração nos dados cadastrais do usuário, incluindo a possibilidade de ativação ou desativação.</p>

   <h4>Deletar Usuários</h4>
   <p>Exibe uma busca de usuários por nome ou por CPF para, em seguida, exibir dados do usuário em modo somente leitura e permite a exclusão do usuário. Não há como reverter esse processo.</p>

   <h4>Listar Usuários</h4>
   <p>Exibe todos usuários por ordem de tempo de cadastro no sistema.</p>

   <h4>Relatórios</h4>
   <p>Exibe dois relatórios: quantidade de cadastratado por sexo e quantidade de usuários ativos e inativos. Ambos os relatórios permitem filtro por cidade. As cores do primeiro relatório são geradas randomicamente.</p>

   <h4>Limitações</h4>
   <p>
    <ul>
      <li>Não foi realizada validação de cpf e email;</li>
      <li>Não foi criado uma página para adicionar, remover e editar tipos de sexo; e</li>
      <li>Não foi realizado uma pesquisa por nome e por cpf utilizando autocomplete.</li>  
    </ul>
   </p>


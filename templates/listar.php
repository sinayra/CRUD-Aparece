<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h2>Lista de Usuários</h2>
</div>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Sexo</th>
        <th>CPF</th>
        <th>Idade</th>
        <th>Email</th>
        <th>Endereço</th>
        <th>Cidade (Estado)</th>
        <th>Ativo</th>
      </tr>
    </thead>
    <tbody>
     <?php 
        for ($i=0; $i < count($users); $i++) {
          ?>
          <tr>
            <td><?=$i + 1 ?></td>
            <td><?=$users[$i]['nome'] ?></td>
            <td><?=$users[$i]['sexo'] ?></td>
            <td><?=$users[$i]['cpf'] ?></td>
            <td><?=$users[$i]['idade'] ?></td>
            <td><?=$users[$i]['email'] ?></td>
            <td><?=$users[$i]['endereco'] ?></td>
            <td><?=$users[$i]['cidade'] ?> (<?=$users[$i]['estado'] ?>)</td>
            <td>
              <?php
                if(boolval ($users[$i]['ativo'])){
                  ?>
                    <span data-feather="check"></span>
                  <?php
                }
                else{
                  ?>
                   <span data-feather="x"></span>
                  <?php
                }
              ?>
            </td>
          </tr>
          <?php
        }
      ?>
    </tbody>
  </table>
</div>

<script>
  feather.replace()
</script>

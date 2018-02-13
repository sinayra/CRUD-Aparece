<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h2>Excluir usuário cadastrado</h2>
</div>

<h4>Procurar por nome ou cpf</h4>
<div id="search_delete">
  <div class="row">
    <div class="col-sm-4">
      <form id="search_frm_delete_nome">
        <label for="search_delete_nome">Nome</label>
        <select name="nome">
          <option value="-1"></option>
           <?php 
              foreach ($pessoasNome as $p) {
                ?>
                <option value="<?=$p['id']?>"><?=$p['nome']?></option>
                <?php
              }
            ?>
        </select>
      </form>
    </div>
    <div class="col-sm-4">
      <form id="search_frm_delete_cpf">
        <label for="search_delete_cpf">CPF</label>
        <select name="cpf">
          <option value="-1"></option>
           <?php 
              foreach ($pessoasCPF as $p) {
                ?>
                <option value="<?=$p['id']?>"><?=$p['cpf']?></option>
                <?php
              }
            ?>
        </select>
      </form>
    </div>
</div> 
</div>

<div id="searched_delete">

</div>


<script type="text/javascript">
  $('#search_delete select').change(function(){
    $.ajax({
          type: "POST",
          url: '/procuraPessoaDelete',
          data: {
            'id' : $(this).val()
          },
          success: function (data)
          {
            console.log("carregou");
             $('#searched_delete').html(data);
          }
      });
  });
</script>
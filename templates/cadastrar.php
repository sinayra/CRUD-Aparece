<?php
//echo json_encode($data);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Cadastrar</h1>
</div>

<form>

  <div class="form-group">
    <label for="insert_nome">Nome</label>
    <input type="text" class="form-control" name="insert_nome" placeholder="Nome completo">
  </div>

  <div class="form-group">
    <label for="insert_sexo">Sexo</label>
    <select class="form-control" name="insert_sexo" disabled>
      <option selected>Brasil</option>
    </select>
  </div>

  <div class="form-group">
    <label for="insert_email">Email</label>
    <input type="email" class="form-control" name="insert_email" placeholder="nome@exemplo.com">
  </div>
  <div class="form-group">
    <label for="insert_nascimento">Data de nascimento</label>
    <input class="datepicker form-control"  name="insert_nascimento" data-provide="datepicker">
  </div>
  <div class="form-group">
    <label for="insert_cpf">CPF</label>
    <input type="text" class="form-control" name="insert_cpf" placeholder="CPF">
  </div>
  <div class="form-group">
    <label for="insert_pais">País</label>
     <select class="form-control" name="insert_pais" disabled>
      <option selected>Brasil</option>
    </select>
  </div>
  <div class="form-group">
    <label for="insert_cep">CEP</label>
    <input type="text" class="form-control" name="insert_cep" placeholder="CEP">
  </div>
  <div class="form-group">
    <label for="insert_estado">Estado</label>
    <input name="insert_estado" class="form-control" disabled data-autocomplete-state/>
  </div>
  <div class="form-group">
    <label for="insert_cidade">Cidade</label>
    <input name="insert_cidade" class="form-control" disabled data-autocomplete-city/>
  </div>
  <div class="form-group">
    <label for="insert_bairro">Bairro</label>
    <input name="insert_bairro" class="form-control" disabled data-autocomplete-neighborhood/>
  </div>
  <div class="form-group">
    <label for="insert_endereco">Endereço</label>
    <input name="insert_endereco" class="form-control" disabled data-autocomplete-address/>
  </div>
  <div class="form-group">
    <label for="insert_numero">Número</label>
    <input type="number" class="form-control" name="insert_numero" placeholder="Nº">
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

<script type="text/javascript">
  $('.datepicker').datepicker();
  var teste = $("input[name=insert_cep]").autocompleteAddress({
      address: "input[name=insert_endereco]",
      neighborhood: "input[name=insert_bairro]",
      city: "input[name=insert_cidade]",
      state: "input[name=insert_estado]"
    });

</script>
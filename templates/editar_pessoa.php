<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom"></div>
  <h4>Editar <?=$pessoa['nome']?></h4>

<form id="frm_update">

  <div class="form-check">
    <?php 
      $check = (boolval ($pessoa['ativo']) ? "checked" : "");
    ?>
    <input type="checkbox" class="form-check-input" name="update_ativo" <?=$check?>>
    <label for="update_ativo">Ativo</label>
  </div>

  <div class="form-group">
    <label for="update_nome">Nome</label>
    <input type="text" class="form-control" name="update_nome" value="<?=$pessoa['nome']?>">
  </div>

  <div class="form-group">
    <label for="update_sexo">Sexo</label>
    <select class="form-control" name="update_id_sexo">
      <?php 
        foreach ($sexo as $s) {
          $selected = "";
          if($s['id'] == $pessoa['id_sexo']){
            $selected = "selected";
          }
          ?>
          <option value="<?=$s['id']?>" <?=$selected?> ><?=$s['tipo']?></option>
          <?php
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="update_email">Email</label>
    <input type="email" class="form-control" name="update_email" value="<?=$pessoa['email']?>">
  </div>
  <div class="form-group">
    <label for="update_nascimento">Data de nascimento</label>
    <input type="date" class="form-control"  name="update_nascimento" value="<?=$pessoa['nascimento']?>">
  </div>
  <div class="form-group">
    <label for="update_cpf">CPF</label>
    <input type="text" class="form-control" name="update_cpf" value="<?=$pessoa['cpf']?>">
  </div>
  <div class="form-group">
    <label for="update_cep">CEP</label>
    <input type="text" class="form-control" name="update_cep" value="<?=$endereco['cep']?>">
  </div>
  <div class="form-group">
    <label for="update_logradouro">Endereço</label>
    <input name="update_logradouro" class="form-control" value="<?=$endereco['logradouro']?>" readonly data-autocomplete-address/>
  </div>
   <div class="form-group">
    <label for="update_end_numero">Número</label>
    <input type="text" class="form-control" name="update_end_numero" value="<?=$pessoa['end_numero']?>">
  </div>
  <div class="form-group">
    <label for="update_bairro">Bairro</label>
    <input name="update_bairro" class="form-control" value="<?=$endereco['bairro']?>" readonly data-autocomplete-neighborhood/>
  </div>
  <div class="form-group">
    <label for="update_cidade">Cidade</label>
    <input name="update_cidade" class="form-control" value="<?=$endereco['cidade']?>" readonly data-autocomplete-city/>
  </div>
   <div class="form-group">
    <label for="update_estado">Estado</label>
    <input name="update_estado" class="form-control" value="<?=$endereco['estado']?>" readonly data-autocomplete-state/>
  </div>

  <input type="hidden" name="update_id" value="<?=$pessoa['id']?>">

  <button type="submit" class="btn btn-primary">Atualizar</button>
</form>



<script type="text/javascript">
  $('input[name=update_cep]').mask('00000-000');
  $('input[name=update_cpf]').mask('000.000.000-00', {reverse: true});

  $("input[name=update_cep]").autocompleteAddress({
    address: "input[name=update_endereco]",
    neighborhood: "input[name=update_bairro]",
    city: "input[name=update_cidade]",
    state: "input[name=update_estado]"
  });


  $( "#frm_update" ).submit(function( e ) {
      e.preventDefault();
      var url = "/update";
      var dados = $(this).serialize() + "&update_ativo=" + $( "input[name=update_ativo]:checked" ).val();

      $.ajax({
          type: "POST",
          url: url,
          data: dados,
          success: function (data)
          {
              var mensagem = JSON.parse(data);
              var messageText = mensagem.message;
              var messageAlert = (mensagem.error == "ok" ? "alert-success" : "alert-danger");

              var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
              
              if (data) {
                  $('#msg').html(alertBox);
                  

                  $('html,body').animate({
                      scrollTop: $("#msg").offset().top - 60}, 'slow');
              }
          }
      });
  
  });
</script>
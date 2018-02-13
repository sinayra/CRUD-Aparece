<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom"></div>
  <h4>Excluir <?=$pessoa['nome']?></h4>

<form id="frm_delete">

  <div class="form-check">
    <?php 
      $check = (boolval ($pessoa['ativo']) ? "checked" : "");
    ?>
    <input type="checkbox" class="form-check-input"  name="delete_ativo" <?=$check?> disabled>
    <label for="delete_ativo">Ativo</label>
  </div>

  <div class="form-group">
    <label for="delete_nome">Nome</label>
    <input type="text" class="form-control" name="delete_nome" value="<?=$pessoa['nome']?>" readonly>
  </div>

  <div class="form-group">
    <label for="delete_sexo">Sexo</label>
    <select class="form-control" name="delete_id_sexo" readonly>
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
    <label for="delete_email">Email</label>
    <input type="email" class="form-control" name="delete_email" value="<?=$pessoa['email']?>" readonly>
  </div>
  <div class="form-group">
    <label for="delete_nascimento">Data de nascimento</label>
    <input type="date" class="form-control"  name="delete_nascimento" value="<?=$pessoa['nascimento']?>" readonly>
  </div>
  <div class="form-group">
    <label for="delete_cpf">CPF</label>
    <input type="text" class="form-control" name="delete_cpf" value="<?=$pessoa['cpf']?>" readonly>
  </div>
  <div class="form-group">
    <label for="delete_cep">CEP</label>
    <input type="text" class="form-control" name="delete_cep" value="<?=$endereco['cep']?>" readonly>
  </div>
  <div class="form-group">
    <label for="delete_logradouro">Endereço</label>
    <input name="delete_logradouro" class="form-control" value="<?=$endereco['logradouro']?>" readonly data-autocomplete-address/>
  </div>
   <div class="form-group">
    <label for="delete_end_numero">Número</label>
    <input type="text" class="form-control" name="delete_end_numero" value="<?=$pessoa['end_numero']?>" readonly>
  </div>
  <div class="form-group">
    <label for="delete_bairro">Bairro</label>
    <input name="delete_bairro" class="form-control" value="<?=$endereco['bairro']?>" readonly data-autocomplete-neighborhood/>
  </div>
  <div class="form-group">
    <label for="delete_cidade">Cidade</label>
    <input name="delete_cidade" class="form-control" value="<?=$endereco['cidade']?>" readonly data-autocomplete-city/>
  </div>
   <div class="form-group">
    <label for="delete_estado">Estado</label>
    <input name="delete_estado" class="form-control" value="<?=$endereco['estado']?>" readonly data-autocomplete-state/>
  </div>

  <input type="hidden" name="delete_id" value="<?=$pessoa['id']?>">

  <button type="submit" class="btn btn-primary">Excluir</button>
</form>



<script type="text/javascript">


  $( "#frm_delete" ).submit(function( e ) {
      e.preventDefault();
      var url = "/delete/" + $('input[name=delete_id]').val();

      console.log($('input[name=delete_id]').val());

      $.ajax({
          type: "DELETE",
          url: url,
          success: function (data)
          {
              var mensagem = JSON.parse(data);
              var messageText = mensagem.message;
              var messageAlert = (mensagem.error == "ok" ? "alert-success" : "alert-danger");

              var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
              
              if (data) {
                  $('#msg').html(alertBox);
                  

                  $('html,body').animate({
                      scrollTop: $("#msg").offset().top - 60}, 'slow', function(){
                        loadMain('/deletar');
                      });
                      
              }
          }
      });
  
  });
</script>
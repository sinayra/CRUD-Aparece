
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Cadastrar</h1>
</div>

<form id="frm_insert">

  <div class="form-group">
    <label for="insert_nome">Nome</label>
    <input type="text" class="form-control" name="insert_nome" placeholder="Nome completo">
  </div>

  <div class="form-group">
    <label for="insert_id_sexo">Sexo</label>
    <select class="form-control" name="insert_id_sexo">
      <?php 
        foreach ($sexo as $s) {
          ?>
          <option value="<?=$s['id']?>"><?=$s['tipo']?></option>
          <?php
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label for="insert_email">Email</label>
    <input type="email" class="form-control" name="insert_email" placeholder="nome@exemplo.com">
  </div>
  <div class="form-group">
    <label for="insert_nascimento">Data de nascimento</label>
    <input type="date" class="form-control"  name="insert_nascimento">
  </div>
  <div class="form-group">
    <label for="insert_cpf">CPF</label>
    <input type="text" class="form-control" name="insert_cpf" placeholder="CPF">
  </div>
  <div class="form-group">
    <label for="insert_pais">País</label>
     <select class="form-control" name="insert_pais" readonly>
      <option selected>Brasil</option>
    </select>
  </div>
  <div class="form-group">
    <label for="insert_cep">CEP</label>
    <input type="text" class="form-control" name="insert_cep" placeholder="CEP">
  </div>
  <div class="form-group">
    <label for="insert_logradouro">Endereço</label>
    <input name="insert_logradouro" class="form-control" readonly data-autocomplete-address/>
  </div>
   <div class="form-group">
    <label for="insert_end_numero">Número</label>
    <input type="text" class="form-control" name="insert_end_numero" placeholder="Casa nº">
  </div>
  <div class="form-group">
    <label for="insert_bairro">Bairro</label>
    <input name="insert_bairro" class="form-control" readonly data-autocomplete-neighborhood/>
  </div>
  <div class="form-group">
    <label for="insert_cidade">Cidade</label>
    <input name="insert_cidade" class="form-control" readonly data-autocomplete-city/>
  </div>
   <div class="form-group">
    <label for="insert_estado">Estado</label>
    <input name="insert_estado" class="form-control" readonly data-autocomplete-state/>
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>



<script type="text/javascript">
  $('input[name=insert_cep]').mask('00000-000');
  $('input[name=insert_cpf]').mask('000.000.000-00', {reverse: true});

  $("input[name=insert_cep]").autocompleteAddress({
    address: "input[name=insert_endereco]",
    neighborhood: "input[name=insert_bairro]",
    city: "input[name=insert_cidade]",
    state: "input[name=insert_estado]"
  });
  

  $( "#frm_insert" ).submit(function( e ) {
      e.preventDefault();
      var url = "/insert";

      $.ajax({
          type: "POST",
          url: url,
          data: $(this).serialize(),
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

              if(mensagem.error == "ok"){ //enviar email


                var nome = $('#frm_insert input[name="insert_nome"]').val();
                var email = $('#frm_insert input[name="insert_email"]').val();

                $('#frm_insert')[0].reset();

                $.ajax({ 
                  type: "POST",
                  url: "/enviaEmailCadastro",
                  data: {
                    nome : nome,
                    email : email
                  }
                });
              }
          }
      });
  
  });
</script>
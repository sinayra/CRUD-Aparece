
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Cadastrar</h1>
</div>

<form id="frm_insert">

  <div class="messages"></div>

  <div class="form-group">
    <label for="insert_nome">Nome</label>
    <input type="text" class="form-control" name="insert_nome" placeholder="Nome completo">
  </div>

  <div class="form-group">
    <label for="insert_sexo">Sexo</label>
    <select class="form-control" name="insert_sexo">
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
    <label for="insert_estado">Estado</label>
    <input name="insert_estado" class="form-control" readonly data-autocomplete-state/>
  </div>
  <div class="form-group">
    <label for="insert_cidade">Cidade</label>
    <input name="insert_cidade" class="form-control" readonly data-autocomplete-city/>
  </div>
  <div class="form-group">
    <label for="insert_bairro">Bairro</label>
    <input name="insert_bairro" class="form-control" readonly data-autocomplete-neighborhood/>
  </div>
  <div class="form-group">
    <label for="insert_endereco">Endereço</label>
    <input name="insert_endereco" class="form-control" readonly data-autocomplete-address/>
  </div>
  <div class="form-group">
    <label for="insert_numero">Número</label>
    <input type="number" class="form-control" name="insert_numero" placeholder="Nº">
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

<script type="text/javascript">

  $("input[name=insert_cep]").autocompleteAddress({
      address: "input[name=insert_endereco]",
      neighborhood: "input[name=insert_bairro]",
      city: "input[name=insert_cidade]",
      state: "input[name=insert_estado]"
    });

  $( "#frm_insert" ).submit(function( e ) {
    if (!e.isDefaultPrevented()) {
      var url = "insert";

      // POST values in the background the the script URL
      $.ajax({
          type: "POST",
          url: url,
          data: $(this).serialize(),
          success: function (data)
          {
              // data = JSON object that contact.php returns

              // we recieve the type of the message: success x danger and apply it to the 
              var messageAlert = 'alert-' + data.type;
              var messageText = data.message;

              // let's compose Bootstrap alert box HTML
              var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
              
              // If we have messageAlert and messageText
              if (messageAlert && messageText) {
                  // inject the alert to .messages div in our form
                  $('#frm_insert').find('.messages').html(alertBox);
                  // empty the form
                  $('#frm_insert')[0].reset();
              }
          }
      });
      return false;
  }
  });
</script>
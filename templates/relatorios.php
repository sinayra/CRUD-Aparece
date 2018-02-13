<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
  <h1 class="h2">Relatórios</h1>
</div>

<div id="relatorios_cidade">
  <div class="row">
    <div class="col-sm-6">
      <form id="search_frm_cidade">
        <label for="search_cidade">Cidade</label>
        <select name="cidade">
          <option value="-1">Todas</option>
           <?php 
              foreach ($cidades as $c) {
                ?>
                <option value="<?=$c['cidade']?>"><?=$c['cidade']?></option>
                <?php
              }
            ?>
        </select>
      </form>
    </div>
  </div> 
</div>

<div class="row">
  <div class="col-md-6">
    <div id="relatorios_sexo"></div>
  </div>
  <div class="col-md-6">
    <div id="relatorios_inativo"></div>
  </div>
</div>

<script type="text/javascript">
  function exibeGraficos(cidade){

    $.ajax({
          type: "GET",
          url: '/relatorios/sexo/' + cidade,
          success: function (data)
          {
             $('#relatorios_sexo').html(data);
          }
      });

    $.ajax({
          type: "GET",
          url: '/relatorios/inativo/' + cidade,
          success: function (data)
          {
             $('#relatorios_inativo').html(data);
          }
      });
  }

  exibeGraficos('-1');

  $('#relatorios_cidade select').change(function(){

    exibeGraficos($(this).val());

  });
  
</script>
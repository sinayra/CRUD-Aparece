
  <h4>Usuários ativos e inativos</h4>

  <?php 
    if($countInativo['qtd_ativos'] == 0 && $countInativo['qtd_inativos'] == 0){
      ?>
        <h5>Não há dados</h5>
      <?php
    }
    else{
  ?>

 <div class="row">
  <div class="col-md-6">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Ativos</th>
            <th>Inativos</th>
          </tr>
        </thead>
        <tbody>
          
        <tr>
          <td><?=$countInativo['qtd_ativos']?></td>
          <td><?=$countInativo['qtd_inativos']?></td>
        </tr>

        </tbody>
      </table>
    </div>
  </div>

  <div class="col-md-6">
    <canvas id="relatorio_inativo_donut"></canvas>
  </div>
</div> 




<!-- Graphs -->

<script>

  var cores = ['rgb(77,66,255)', 'rgb(204,204,204)'];


  var inativoCanvas = document.getElementById("relatorio_inativo_donut");
  var inativoData = {
    labels: [
      "Ativos",
      "Inativos"
    ],
    datasets: [
        {
            data: [
              <?=$countInativo['qtd_ativos']?>,
              <?=$countInativo['qtd_inativos']?>
              ],
            backgroundColor: cores
        }]
};

var pieChart = new Chart(inativoCanvas, {
  type: 'pie',
  data: inativoData
});
</script>
<?php 
  }
?>
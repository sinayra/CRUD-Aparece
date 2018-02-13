
  <h4>Sexo dos usuários cadastrados</h4>

  <?php 
    if(empty($countSexo)){
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
            <th>Sexo</th>
            <th>Quantidade</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            for ($i=0; $i < count($countSexo); $i++) { 
              ?>
              <tr>
                <td><?=$countSexo[$i]['tipo']?></td>
                <td><?=$countSexo[$i]['qtd']?></td>
              </tr>
              <?php
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-md-6">
    <canvas id="relatorio_sexo_donut"></canvas>
  </div>
</div> 




<!-- Graphs -->

<script>
  function randomRGB() {
      var r = Math.floor(Math.random() * 255);
      var g = Math.floor(Math.random() * 255);
      var b = Math.floor(Math.random() * 255);
      return "rgb(" + r + "," + g + "," + b + ")";
   };

  var cores = [];
  <?php
    for ($i=0; $i < count($countSexo); $i++) { 
      echo 'cores.push(randomRGB());';
    }
  ?>


  var sexoCanvas = document.getElementById("relatorio_sexo_donut");
  var sexoData = {
    labels: [
      <?php
        for ($i=0; $i < count($countSexo); $i++) { 
          echo '"' . $countSexo[$i]['tipo'] . '"';

          if($i < count($countSexo) - 1){
            echo ',';
          }
        }
      ?>
    ],
    datasets: [
        {
            data: [
              <?php
                for ($i=0; $i < count($countSexo); $i++) { 
                  echo '"' . $countSexo[$i]['qtd'] . '"';

                  if($i < count($countSexo) - 1){
                    echo ',';
                  }
                }
              ?>
              ],
            backgroundColor: cores
        }]
};

var pieChart = new Chart(sexoCanvas, {
  type: 'pie',
  data: sexoData
});
</script>
<?php 
  }
?>
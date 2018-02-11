<?php 
header('Content-Type: application/json; charset=utf-8');
//echo json_encode($data);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>Processo Seletivo 2018 Aparece Brasil</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Processo Seletivo 2018 <br /> Aparece Brasil</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">

    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  Página Inicial <span class="sr-only">(atual)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="user-plus"></span>
                  Cadastrar Usuários
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Listar Usuários
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="user-check"></span>
                  Editar Usuários
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="user-minus"></span>
                  Deletar Usuários
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="pie-chart"></span>
                  Relatórios
                </a>
              </li>
             
            </ul>
<!--
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Saved reports</span>
              <a class="d-flex align-items-center text-muted" href="#">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Current month
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Last quarter
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Social engagement
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="file-text"></span>
                  Year-end sale
                </a>
              </li>
            </ul>
        -->
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">

        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="templates/js/jquery-3.3.1.min.js" ></script>
    <script>window.jQuery</script>
    <script src="templates/js/popper.min.js"></script>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="templates/js/Chart.min.js"></script>
    <script src="templates/js/rendererFunctions.js"></script>

    <!-- Icons -->
    <script src="templates/js/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <script type="text/javascript">

    	$(function() {
		    loadMain('/inicial');
		});

    	$('a.nav-link').click(function(e){  //Navegação
    		var antigo = $('.nav-link .active');
    		var txt;
    		
    		$('.sr-only').remove();
    		antigo.removeClass('active');
    		txt = $(this).text().replace(/\s/g,'');

			$(this).addClass('active');
			$(this).append('<span class="sr-only">(atual)</span>');

			switch(txt){
				case "CadastrarUsuários":
					loadMain('/cadastrar');
					break;
				case "ListarUsuários":
					loadMain('/listar');
					break;
				case "EditarUsuários":
					loadMain('/editar');
					break;
				case "DeletarUsuários":
					loadMain('/deletar');
					break;
				case "Relatórios":
					loadMain('/relatorios');
					break;
				default:
					loadMain('/inicial');
			}
			
			e.preventDefault();
		});

    	
    </script>
  </body>
</html>
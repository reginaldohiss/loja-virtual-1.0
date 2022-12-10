<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Administrativo</title>
    <link href="/painel/assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
	<nav class="navbar navbar-inverse">
      <div class="container">
        <div id="navbar">
          <ul class="nav navbar-nav navbar-left">
            <li class="active"><a href="/painel">Home</a></li>
            <li><a href="/painel/categorias">Categorias</a></li>
            <li><a href="/painel/produtos">Produtos</a></li>            
            <li><a href="/painel/vendas">Vendas</a></li>
            <li><a href="/painel/usuarios">Usuários</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          	<li><a href="/painel/login/sair">Sair</a></li>
          </ul>
        </div>
      </div>
    </nav>

	<div class="container">
		<?php $this->loadViewInTemplate($viewName, $viewData); ?>
	</div>
	<div class="rodape"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/painel/assets/js/bootstrap.min.js"></script>
  </body>
</html>
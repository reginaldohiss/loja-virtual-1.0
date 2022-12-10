<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Administrativo</title>
    <link href="/painel/assets/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
	   
    <div class="container">
      <form method="POST" class="form-signin" style="max-width:300px;margin:auto">
        <h2 class="form-signin-heading">Login no Painel</h2>

        <?php if(isset($aviso) && !empty($aviso)): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo $aviso; ?>
        </div>
        <?php endif; ?>

        <label for="inputText" class="sr-only">Usuário</label>
        <input type="text" name="usuario" id="inputText" class="form-control" placeholder="Usuário" required autofocus><br/>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required><br/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
      </form>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/painel/assets/js/bootstrap.min.js"></script>
  </body>
</html>
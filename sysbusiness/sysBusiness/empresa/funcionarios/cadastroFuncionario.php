<?php
	require_once '../../php_action/db_connection.php';

	session_start();

  if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

	$errosCadastroFuncionario=array();

  try{

	  if(isset($_POST['btn-funcionario'])):
		  $nomeFuncionario  = $_POST['nomeFuncionario'];
		  $emailFuncionario = $_POST['emailFuncionario'];
		  $senhaFuncionario = $_POST['senhaFuncionario'];
		  $repetirSenhaFuncionario  = $_POST['repetirSenhaFuncionario'];

      $stmtEmailFuncionario=$pdo->prepare('SELECT * FROM cad_usuario WHERE email=:emailFuncionario');
      $stmtEmailFuncionario->bindParam(':emailFuncionario',$emailFuncionario);
      $stmtEmailFuncionario->execute();

      $stmtEmailEmpresa=$pdo->prepare('SELECT * FROM cad_empresa WHERE email=:emailFuncionario');
      $stmtEmailEmpresa->bindParam(':emailFuncionario',$emailFuncionario);
      $stmtEmailEmpresa->execute();

			if(($stmtEmailFuncionario->rowCount()>0)||($stmtEmailEmpresa->rowCount()>0)):
				$errosCadastroFuncionario[]="Esse email já esta cadastrado";
			endif;

			if($repetirSenhaFuncionario!==$senhaFuncionario):
				$errosCadastroFuncionario[]="As senhas precisam ser iguais!";
			endif;

			if(empty($erros)):
        $senhaFuncionario=base64_encode($senhaFuncionario);

        $stmtCadastroFuncionario=$pdo->prepare('INSERT INTO cad_usuario (nome,email,senha,id_empresa) VALUES (:nomeFuncionario,:emailFuncionario,:senhaFuncionario,:codEmpresa)');
        $stmtCadastroFuncionario->bindParam(':nomeFuncionario',$nomeFuncionario);
        $stmtCadastroFuncionario->bindParam(':emailFuncionario',$emailFuncionario);
        $stmtCadastroFuncionario->bindParam(':senhaFuncionario',$senhaFuncionario);
        $stmtCadastroFuncionario->bindParam(':codEmpresa',$_SESSION['id_usuario']);

        $stmtCadastroFuncionario->execute();

        header('Location:funcionarios.php');

			endif;
	
	  endif;

  }catch(PDOException $e){
    $errosCadastroFuncionario[]=$e->getMessage();
  }finally{
    $pdo=null;
  }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../imagens/favicon.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/css.css">
  <script src="https://kit.fontawesome.com/fece0716a5.js" crossorigin="anonymous"></script>
	<title>Novo funcionário</title>
</head>
<body>

		<div class="container">

			<br>

            <div class="jumbotron gray-color">    
              <div class="display-4">Novo Funcionário</div><br>

              <hr>
              <br>

              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="row">

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <i class="fas fa-user-alt"></i>
                      <label for="nomeFuncionario">Nome</label>
                      <input type="text" class="form-control" id="nomeFuncionario" name="nomeFuncionario" minlength="2" required>
                    </div>
                  </div>

				          <div class="col-md-6 md-3">
                    <div class="form-group">
                      <i class="fas fa-envelope"></i>
                      <label for="emailFuncionario">Email</label>
                      <input type="email" placeholder="example@email.com" class="form-control" id="emailFuncionario" name="emailFuncionario" aria-describedby="emailHelp" required> 
                    </div>
                  </div>
               
                </div>

                <div class="row">

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <i class="fas fa-key"></i>
                      <label for="senhaEmpresa">Senha</label>
                      <input type="password" placeholder="xxxxxxxx" class="form-control" id="senhaFuncionario" name="senhaFuncionario" minlength="8" required>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <i class="fas fa-key"></i>
                      <label for="repetirSenhaFuncionario">Repetir senha</label>
                      <input type="password" placeholder="xxxxxxxx" class="form-control" id="repetirSenhaFuncionario" name="repetirSenhaFuncionario" minlength="8" required>
                    </div>
                  </div>

                </div>

                <?php
			            if(!empty($errosCadastroFuncionario)):
				            foreach($errosCadastroFuncionario as $erro):
					            echo $erro."<br>";
				            endforeach;
			            endif;
		            ?>

                <br>
                  
                <p align="right">
                  <button type="submit" class="btn btn-success" name="btn-funcionario" data-toggle="modal" data-target="#modal1">Cadastrar</button>
                </p>

              </form>
          
            </div>
        </div>

		

		<br>

		

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>
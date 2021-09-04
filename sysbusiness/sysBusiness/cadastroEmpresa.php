<?php
	require_once 'php_action/db_connection.php';

	session_start();

	$errosCadastroEmpresa=array();

  try{

	  if(isset($_POST['btn-empresa'])):

		  $nomeEmpresa = $_POST['nomeEmpresa'];
		  $emailEmpresa = $_POST['emailEmpresa'];
		  $senhaEmpresa = $_POST['senhaEmpresa'];
		  $repetirSenhaEmpresa = $_POST['repetirSenhaEmpresa'];
      $telefoneEmpresa = $_POST['telefone'];

		  $resultadoEmailEmpresa=$pdo->prepare('SELECT * FROM cad_empresa WHERE email=:emailEmpresa');
      $resultadoEmailEmpresa->bindParam(':emailEmpresa',$emailEmpresa);
      $resultadoEmailEmpresa->execute();

      $resultadoEmailFuncionario=$pdo->prepare('SELECT * FROM cad_empresa WHERE email=:emailFuncionario');
      $resultadoEmailFuncionario->bindParam(':emailFuncionario',$emailEmpresa);
      $resultadoEmailFuncionario->execute();

			if(($resultadoEmailEmpresa->rowCount()>0)||($resultadoEmailFuncionario->rowCount()>0)):
				$errosCadastroEmpresa[]="Esse email já está cadastrado";
			endif;

			if($repetirSenhaEmpresa!==$senhaEmpresa):
				$errosCadastroEmpresa[]="As senhas precisam ser iguais!";
			endif;

			if(empty($erros)):

        $senhaEmpresa=base64_encode($senhaEmpresa);

				$cadastraEmpresa=$pdo->prepare('INSERT INTO cad_empresa (nome,email,senha,telefone) VALUES (:nomeEmpresa,:emailEmpresa,:senhaEmpresa,:telefoneEmpresa)');
        $cadastraEmpresa->bindParam(':nomeEmpresa',$nomeEmpresa);
        $cadastraEmpresa->bindParam(':emailEmpresa',$emailEmpresa);
        $cadastraEmpresa->bindParam(':senhaEmpresa',$senhaEmpresa);
        $cadastraEmpresa->bindParam(':telefoneEmpresa',$telefoneEmpresa);
        $cadastraEmpresa->execute();

        $procuraEmpresa=$pdo->prepare('SELECT * FROM cad_empresa WHERE email=:emailEmpresa');
        $procuraEmpresa->bindParam(':emailEmpresa',$emailEmpresa);
        $procuraEmpresa->execute();
        $dados=$procuraEmpresa->fetch();

        $_SESSION['logado']=true;
        $_SESSION['id_usuario']=$dados['idEmpresa'];

        header('Location:empresa/homeEmpresa.php');

			endif;
	
	  endif;
  
  }catch(PDOException $e){
    $errosCadastroEmpresa[]="Não foi possível cadastrar projeto";
  }finally{
    $pdo=null;
  }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>SysBusiness</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="imagens/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="css/css.css">
        <script src="https://kit.fontawesome.com/fece0716a5.js" crossorigin="anonymous"></script>
    </head>

    <body style="background-color: rgba(0,0,0,0.025)">
        
        <nav class="navbar navbar-expand-lg navbar-dark orange-color">

            <a href="../index.html"> 
              <img src="imagens/sysbusinesslogo.jpg" width=232.8px>
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">   
                <li class="nav-item" > 
                   <a class="nav-link" href="login.php" >Login</a>
                </li>
              </ul>
            </div>
                          
        </nav>

        <div class="container">
            <div class="jumbotron gray-color">    
                <div class="display-4">Cadastro</div><br>
                    <p class="lead text-left">Crie uma conta para sua empresa.</p> </h1>
                <hr>
                <br>

              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="row">

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <i class="fas fa-user-alt"></i>
                      <label for="nomeEmpresa">Nome</label>
                      <input type="text" class="form-control" id="nomeEmpresa" name="nomeEmpresa" minlength="3" required>
                    </div>
                  </div>

                  <div class="col-md-6 md-3">
                    <div class="form-group">
                      <i class="fas fa-phone-alt"></i>
                      <label for="telefone">Telefone</label>
                      <input type="tel" placeholder="(xx)xxxx-xxxx" class="form-control" id="telefone" name="telefone" required> 
                    </div>
                  </div>
                
                </div>

                <div class="row">

                  <div class="col-md-12 md-3">
                    <div class="form-group">
                      <i class="fas fa-envelope"></i>
                      <label for="emailEmpresa">Email</label>
                      <input type="email" placeholder="example@email.com" class="form-control" id="emailEmpresa" name="emailEmpresa" aria-describedby="emailHelp" required> 
                    </div>
                  </div>
                
                </div>

                <div class="row">

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <i class="fas fa-key"></i>
                      <label for="senhaEmpresa">Senha</label>
                      <input type="password" placeholder="xxxxxxxx" class="form-control" id="senhaEmpresa" name="senhaEmpresa" minlength="8" required>
                    </div>
                  </div>

                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <i class="fas fa-key"></i>
                      <label for="repetirSenhaEmpresa">Repetir senha</label>
                      <input type="password" placeholder="xxxxxxxx" class="form-control" id="repetirSenhaEmpresa" name="repetirSenhaEmpresa" minlength="8" required>
                    </div>
                  </div>

                </div>

                <?php
			            if(!empty($errosCadastroEmpresa)):
				              foreach($errosCadastroEmpresa as $erro):
					              echo $erro;
				              endforeach;
			            endif;
		            ?>

                <br>
                  
                <p align="right">
                  <button type="submit" class="btn btn-success" name="btn-empresa" data-toggle="modal" data-target="#modal1">Cadastrar</button>
                </p>

              </form>
          
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
        
    </body>
</html>

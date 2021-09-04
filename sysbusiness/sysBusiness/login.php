<?php

	require_once 'php_action/db_connection.php';
	
	session_start();

    $errosLogin=array();

    try{

	    if(isset($_POST['btn-entrar'])):
        
		    $email = $_POST['email'];
		    $senha = $_POST['senha'];
		    $tipoUsuario = $_POST['tipoUsuario'];

		    if($tipoUsuario=="funcionario"):
                $procuraUsuario=$pdo->prepare('SELECT * FROM cad_usuario WHERE email=:email');
		    else:
                $procuraUsuario=$pdo->prepare('SELECT * FROM cad_empresa WHERE email=:email');		
		    endif;

            $procuraUsuario->bindParam(':email',$email);

            $procuraUsuario->execute();

		    $dados=$procuraUsuario->fetch();
		
		    if($procuraUsuario->rowCount()==1):

                if($senha==base64_decode($dados['senha'])):
				    $_SESSION['logado']=true;

					    if($tipoUsuario=="funcionario"):
						    $_SESSION['id_usuario']=$dados['id'];
						    header('Location:funcionario/tarefas.php');
					    else:
						    $_SESSION['id_usuario']=$dados['id'];
						    header('Location:empresa/projeto/projeto.php');
					    endif;

                else:
                    $errosLogin[]="Senha inválida(s)";
			    endif;

		    else:
			    $errosLogin[]="Usuário inválido";
		    endif;
        
	    endif;

    }catch(PDOException $e){
        $errosLogin[]="Não foi possível fazer login, tente mais tarde";
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
    </head>

    <body class="gray-color">

        <div class="container">

            <div class="row" >

                <div class="col-md-3">
                </div>

                <div class="col-md-6 d-flex align-items-center min-vh-100" >
                    <div class="jumbotron " style="background-color: white" > 
                        
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                            <a href="../index.html"> 
                                <img src="imagens/sysbusinesslogo2.jpg" width="40%" height="100%">
                            </a>
                            
                            <hr><br>

                            <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>

                            <br>

                            <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha" required>
                            
                            <br>

                            <div class="form-check">
                                Usuário
                                <br> 
                                <input type="radio" id="tipoUsuario" name="tipoUsuario" value="funcionario" required> Funcionário
                                |
                                <input type="radio" id="tipoUsuario" name="tipoUsuario" value="empresa"> Empresa
                            </div>

                            <?php
			                    if(!empty($errosLogin)):
				                    foreach($errosLogin as $erro):
					                    echo $erro;
				                    endforeach;
			                    endif;
		                    ?>
                        
                            <br><br>
                         
                            <button type="submit" class="btn btn-outline-success" name="btn-entrar" style="width:100%;" data-toggle="modal" style="" data-target="#modal1">Entrar</button>
                            
                            <br><br><br>

                            <p align="center">
                                <a href="novaSenha.php">Esqueceu sua senha?</a> |
                                <a href="cadastroEmpresa.php">Cadastre-se</a>
                            </p>

                        </form> 

                    </div>
                </div>
                
                <div class="col-md-3">
                </div>
            </div>
            
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
        
    </body>
</html>

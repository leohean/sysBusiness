<?php

	require_once '../php_action/db_connection.php';
	
	session_start();

    $errosNovaSenha=array();

    try{

	    if(isset($_POST['btn-nova-senha'])):
        
		    $email=$_POST['email'];
		    $novaSenha=$_POST['novaSenha'];
            $repetirNovaSenha=$_POST['repetirNovaSenha'];
		    $tipoUsuario=$_POST['tipoUsuario'];

		    if($tipoUsuario=="funcionario"):
                $stmtEmailUsuario=$pdo->prepare('SELECT * FROM cad_usuario WHERE email=:email'); 

                $stmtNovaSenha=$pdo->prepare('UPDATE cad_usuario SET senha=:novaSenha WHERE email=:email');
		    else:
                $stmtEmailUsuario=$pdo->prepare('SELECT * FROM cad_empresa WHERE email=:email');

                $stmtNovaSenha=$pdo->prepare('UPDATE cad_empresa SET senha=:novaSenha WHERE email=:email');
		    endif;

            $stmtEmailUsuario->bindParam(':email',$email); 
            $stmtEmailUsuario->execute();

            if($stmtEmailUsuario->rowCount()==1):
                if($novaSenha==$repetirNovaSenha):
                    $stmtNovaSenha->bindParam(':email',$email);
                    $stmtNovaSenha->bindParam(':novaSenha',base64_encode($novaSenha));

                    $stmtNovaSenha->execute();
                    header('Location:../login.php');
                else:
                    $errosNovaSenha[]="As senhas precisam ser iguais!";
                endif;
            else:
                $errosNovaSenha[]="Esse email não está cadastrado";
            endif;
 
	    endif;

    }catch(PDOException $e){
        $errosNovaSenha[]="Não foi possível alterar a senha";
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
        <link rel="shortcut icon" href="../imagens/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/css.css">
    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-dark orange-color">  
                 
                <a href="../../index.html"> 
                    <img src="../imagens/sysbusinesslogo.jpg" width=232.8px>
                </a>
                 
                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 
                 <div class="collapse navbar-collapse" id="navbarNav">
                   <ul class="navbar-nav ml-auto">  
                     <li class="nav-item">
                         <a class="nav-link" href="cadastroEmpresa.php">Cadastre-se</a>
                     </li>
                     <li class="nav-item"> 
                        <a class="nav-link" href="login.php">Login</a>
                     </li>
                   </ul>
                 </div>                   
        </nav>

        <div class="container">

            <div class="row" >

                <div class="col-md-3">
                </div>

                <div class="col-md-6">
                    <div class="jumbotron " class="gray-color"> 
                        
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                            <div class="display-4">
                                Nova Senha
                            </div>

                            <br><br> 
                            
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="example@email.com" id="email" name="email" required>

                            <br>

                            <label for="senha">Nova senha</label>
                            <input type="password" class="form-control" placeholder="xxxxxxxx" id="novaSenha" name="novaSenha" required>

                            <br>

                            <label for="senha">Repetir nova senha</label>
                            <input type="password" class="form-control" placeholder="xxxxxxxx" id="repetirNovaSenha" name="repetirNovaSenha" required>
                            
                            <br>

                            <div class="form-check">
                                Usuário
                                <br> 
                                <input type="radio" id="tipoUsuario" name="tipoUsuario" value="funcionario" required> Funcionário
                                |
                                <input type="radio" id="tipoUsuario" name="tipoUsuario" value="empresa"> Empresa
                            </div>

                            <?php
			                    if(!empty($errosNovaSenha)):
				                    foreach($errosNovaSenha as $erro):
					                    echo $erro."<br>";
				                    endforeach;
			                    endif;
		                    ?>
                        
                            <br>

                            <p align="right">
                                <button type="submit" class="btn btn-success" name="btn-nova-senha" data-toggle="modal" data-target="#modal1">Finalizar</button>
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

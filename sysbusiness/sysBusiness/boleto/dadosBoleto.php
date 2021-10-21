<?php

	require_once '../php_action/db_connection.php';
	
	session_start();

    $errosDadosBoleto=null;

    try{

	    if(isset($_POST['btn-dados-boleto'])):
        
            $_SESSION['nome']=$_POST['nome'];
            $_SESSION['cpf']=$_POST['cpf'];
            $_SESSION['valor']=$_POST['valor'];

            header('Location:boleto.php');
 
	    endif;

    }catch(PDOException $e){
        $errosDadosBoleto="frhrhgrgr";
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
                                Dados
                            </div>

                            <br><br> 
                            
                            <label for="email">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>

                            <br>

                            <label for="senha">CPF:</label>
                            <input type="text" class="form-control" placeholder="xxx.xxx.xxx.xx" id="cpf" name="cpf" required>

                            <br>

                            <label for="valor">Valor:</label>
                            <input type="text" class="form-control" id="valor" name="valor" required>

                            <?php
			                    if(!empty($errosDadosBoleto)):
				                    foreach($errosDadosBoleto as $erro):
					                    echo $erro."<br>";
				                    endforeach;
			                    endif;
		                    ?>
                        
                            <br>

                            <p align="right">
                                <button type="submit" class="btn btn-success" name="btn-dados-boleto" data-toggle="modal" data-target="#modal1">Finalizar</button>
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

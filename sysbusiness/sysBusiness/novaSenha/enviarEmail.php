<?php

	require_once '../php_action/db_connection.php';
    require_once '../PHPMailer/src/Exception.php';
    require_once '../PHPMailer/src/PHPMailer.php';
    require_once '../PHPMailer/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	
	session_start();

	    if(isset($_POST['btn-enviar-email'])):

            $email=$_POST['email'];

            $procuraEmail=$pdo->prepare("SELECT * FROM cad_empresa INNER JOIN cad_usuario WHERE cad_empresa.email=:email OR cad_usuario.email=:email");
            $procuraEmail->bindParam(":email",$email);
            $procuraEmail->execute();

            if($procuraEmail->rowCount()>0):

                try{
        
                    $mailer=new PHPMailer();

                    $mailer->isSMTP();
                    $mailer->Host="smtp.gmail.com";
                    $mailer->SMTPAuth="true";
                    $mailer->SMTPSecure="tls";
                    $mailer->Port="587";

                    $mailer->Username="sysbusinessofficial@gmail.com";
                    $mailer->Password="@sysBusinessOfficial2021";
                    $mailer->Subject="Nova Senha";
                    $mailer->setFrom("sysbusinessofficial@gmail.com");
                    $mailer->Body='Acesse o link para trocar a sua senha: https://sysbusiness.000webhostapp.com/sysBusiness/novaSenha.php';
                    $mailer->addAddress($email);

                    $mailer->Send();

                    $mailer->smtpClose();

                    $resultadoEnvioEmail="Email enviado com sucesso, por favor agora cheque a sua caixa de mensagens";

                }catch(PDOException $e){
                    $resultadoEnvioEmail="Não foi possível enviar um email";
                }finally{
                    $pdo=null;
                }
            else:
                $resultadoEnvioEmail="Esse email não esta cadastrado";
            endif;
 
	    endif;
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
                         <a class="nav-link" href="../cadastroEmpresa.php">Cadastre-se</a>
                     </li>
                     <li class="nav-item"> 
                        <a class="nav-link" href="../login.php">Login</a>
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

                            <?php
			                    if(!empty($resultadoEnvioEmail)):
					               echo $resultadoEnvioEmail."<br>";
			                    endif;
		                    ?>
                        
                            <br>

                            <p align="right">
                                <button type="submit" class="btn btn-success" name="btn-enviar-email" data-toggle="modal" data-target="#modal1">Enviar</button>
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

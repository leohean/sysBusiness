<?php

	require_once '../php_action/db_connection.php';

	session_start();

	if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    if(isset($_POST['btn-entrar-tarefa'])):
        $_SESSION['id_etapa']=$_POST['idEtapa'];
		header('Location:homeTarefa.php');
	endif;

    $errosHomeFuncionario=array();

    try{
        $etapasFuncionario=$pdo->prepare('SELECT * FROM mov_usuario_etapa WHERE id_usuario=:idUsuario');
        $etapasFuncionario->bindParam(":idUsuario",$_SESSION['id_usuario']);
        $etapasFuncionario->execute();

    }catch(PDOException $e){
        $errosHomeFuncionario[]="Não foi possível conectar ao banco de dados";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/barraLateral.css">
    <script src="https://kit.fontawesome.com/fece0716a5.js" crossorigin="anonymous"></script>
    <title>Minhas tarefas</title>

    <style type="text/css">

        .flex{
	        max-width: 100%;
	        margin: 0 auto;
	        display: flex;
	        flex-wrap: wrap;
        }

        .item {
	        height: 150px;
	        width: 100%;
            margin: 10px;
            border-radius:10px;
	        background-color: rgb(235, 235, 235);
	        text-align: center;
        }

        @media(max-width:480px){
            .item {
	            width: 100%;
            } 
        }

    </style>
    
</head>
<body>

    <input type="checkbox" id="chec">
    <label for="chec" class="fixed">
        <img src="../imagens/menu.png" width="35px">
    </label>
    <nav>
        <ul>
            <li><a href="../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i>Sair</a></li>
        </ul>
    </nav>

    <div class="top">

        <div class="container">

            <br>

            <div class="display-4">Minhas tarefas</div>

            <br>

            <?php
                    
                    try{
                        

                        if($etapasFuncionario->rowCount()):
                        while($dados=$etapasFuncionario->fetch()):
                            $stmtDadosEtapas=$pdo->prepare('SELECT * FROM cad_etapa WHERE id=:idEtapa');
                            $stmtDadosEtapas->bindParam(':idEtapa',$dados['id_etapa']);
                            $stmtDadosEtapas->execute();
                            $dadosEtapa=$stmtDadosEtapas->fetch();
                ?>
                
	            <div class="item">

                    <?php echo $dadosEtapa['nome']; ?>
                    
                    <hr>
                    <br>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" value="<?php echo $dadosEtapa['id']; ?>" name="idEtapa">
                        <button type="submit" class="btn" name="btn-entrar-tarefa" style="margin-top:25px;" data-toggle="modal" style="" data-target="#modal1">Entrar</button>
                    </form>
                
                </div>

                <br>

	            <?php
                        endwhile;
                        endif;

                    }catch(PDOException $e){
                        $erroHomeProjeto[]="Não foi possível carregar as suas tarefas";
                    }
                    finally{
                        $pdo=null;
                    }
                ?>

        </div>
        
    <div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>
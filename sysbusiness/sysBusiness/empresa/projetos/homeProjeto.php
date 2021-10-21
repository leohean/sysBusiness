<?php
	require_once '../../php_action/db_connection.php';

	session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    $erroHomeProjeto=array();

    try{

	    $stmtDadosProjeto=$pdo->prepare('SELECT * FROM mov_projeto WHERE id=:idProjeto');
	    $stmtDadosProjeto->bindParam(':idProjeto',$_SESSION['id_projeto']);
	    $stmtDadosProjeto->execute();

	    $dados=$stmtDadosProjeto->fetch();

    }catch(PDOException $e){
        $erroHomeProjeto[]="Não foi possível conectar ao banco de dados";
    }

    if(isset($_POST['btn-entrar-etapa'])):
        $_SESSION['id_etapa']=$_POST['idEtapa'];
		header('Location:homeTarefa.php');
	endif;

    if(isset($_POST['btn-excluir-etapa'])):

        try{
            $stmtExcluirEtapasProjeto=$pdo->prepare('DELETE FROM cad_etapa WHERE id=:idEtapa');
            $stmtExcluirEtapasProjeto->bindParam(':idEtapa',$_POST['idEtapa']);
            $stmtExcluirEtapasProjeto->execute();

            $stmtExcluirEtapasProjeto=$pdo->prepare('DELETE FROM mov_usuario_etapa WHERE id_etapa=:idEtapa');
            $stmtExcluirEtapasProjeto->bindParam(':idEtapa',$_POST['idEtapa']);
            $stmtExcluirEtapasProjeto->execute();
            
        }catch(PDOException $e){

        }

    endif;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../imagens/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="../../css/css.css">
    <link rel="stylesheet" href="../../css/barraLateral.css">
    <script src="https://kit.fontawesome.com/fece0716a5.js" crossorigin="anonymous"></script>

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

    <title><?php echo $dados['nome']; ?></title>
</head>
<body>

    <input type="checkbox" id="chec">
    <label for="chec" class="fixed">
        <img src="../../imagens/menu.png" width="35px">
    </label>
    <nav>
        <ul>
            <li><a href="projetos.php" class="link"><i class="fas fa-clipboard"></i> Meus projetos</a></li>
            <li><a href="../funcionarios/funcionarios.php" class="link"><i class="fas fa-user-friends"></i> Funcionarios</a></li>
            <li><a href="../../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i>Sair</a></li>
        </ul>
    </nav>

    <div class="top">

        <hr>

        <div class="container">

            <div class="flex">

                <div class="display-4">Etapas <a href="cadastroEtapa.php" style="text-decoration: none; color:black;"><i class="fas fa-plus-circle"></i></a></i></div><br>
                

                <?php

                    try{
                        $stmt=$pdo->prepare('SELECT * FROM cad_etapa WHERE id_projeto=:idProjeto');
                        $stmt->bindParam(':idProjeto',$_SESSION['id_projeto']);
                        $stmt->execute();

                        if($stmt->rowCount()):
                        while($dados=$stmt->fetch()):
                ?>
                
	            <div class="item">
                    <?php echo $dados['nome']; ?>

                    <a data-toggle="modal" data-target="#modalExemplo<?php echo $dados['id']; ?>"><i class="fas fa-trash-alt"></i></a>

                    <div class="modal fade" id="modalExemplo<?php echo $dados['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Etapa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Deseja mesmo excluir <?php echo $dados['nome']; ?>?
                                </div>
                                <div class="modal-footer">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <input type="hidden" name="idEtapa" value="<?php echo $dados['id']; ?>">
                                        <button type="submit" class="btn btn-danger" name="btn-excluir-etapa">Excluir</button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <br>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" value="<?php echo $dados['id']; ?>" name="idEtapa">
                        <button type="submit" class="btn" name="btn-entrar-etapa" style="margin-top:25px;" data-toggle="modal" style="" data-target="#modal1">Entrar</button>
                    </form>
                
                </div>

                <br>

	            <?php
                        endwhile;
                        endif;

                    }catch(PDOException $e){
                        $erroHomeProjeto[]="Não foi possível carregar os dados dos seus projetos";
                    }
                    finally{
                        $pdo=null;
                    }
                ?>

                </div>

        </div>

    <div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>


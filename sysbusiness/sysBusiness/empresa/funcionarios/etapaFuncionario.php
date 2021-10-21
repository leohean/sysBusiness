<?php
	require_once '../../php_action/db_connection.php';

	session_start();

    $_SESSION['bomdia']=$_GET['idFuncionario'];

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    $erroHomeProjeto=array();

    try{

	    $stmtFuncionario=$pdo->prepare('SELECT * FROM cad_usuario WHERE id=:idFuncionario');
	    $stmtFuncionario->bindParam(':idFuncionario',$_GET['idFuncionario']);
	    $stmtFuncionario->execute();

	    $dadosFuncionario=$stmtFuncionario->fetch();
        

    }catch(PDOException $e){
        $erroHomeProjeto[]="Não foi possível conectar ao banco de dados";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../imagens/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
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
    
    <title><?php echo $dadosFuncionario['nome']; ?></title>
</head>
<body>

    <input type="checkbox" id="chec">
    <label for="chec" class="fixed">
        <img src="../../imagens/menu.png" width="35px">
    </label>
    <nav>
        <ul>
            <li><a href="../projetos/projetos.php" class="link"><i class="fas fa-clipboard"></i> Meus projetos</a></li>
            <li><a href="funcionarios.php" class="link"><i class="fas fa-user-friends"></i> Funcionarios</a></li>
            <li><a href="../../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i>Sair</a></li>
        </ul>
    </nav>

    <div class="top">

        <hr>

        <div class="container">

            <br>

		    <div class="display-4"><?php echo $dadosFuncionario['nome']; ?><a href="novaEtapaFuncionario.php?id_usuario=<?php echo $_SESSION['id_usuario'];?>" style="text-decoration: none; color:black;"> <i class="fas fa-plus-circle"></i></a></i></div>
            
            <br>

            <div class="flex">

                <br>

                <?php

                    try{
                        $stmtEtapas=$pdo->prepare('SELECT * FROM mov_usuario_etapa WHERE id_usuario=:idFuncionario');
                        $stmtEtapas->bindParam(':idFuncionario',$_GET['idFuncionario']);
                        $stmtEtapas->execute();

                        if($stmtEtapas->rowCount()):
                        while($idEtapa=$stmtEtapas->fetch()):
                            $stmtDadosEtapas=$pdo->prepare('SELECT * FROM cad_etapa WHERE id=:idEtapa');
                            $stmtDadosEtapas->bindParam(':idEtapa',$idEtapa['id_etapa']);
                            $stmtDadosEtapas->execute();
                            $dadosEtapa=$stmtDadosEtapas->fetch();

                ?>
                
	            <div class="item">
                    <?php echo $dadosEtapa['nome']; ?>
                    <a data-toggle="modal" data-target="#modalExemplo<?php echo $dadosEtapa['id']; ?>"><i class="fas fa-trash-alt"></i></a>
                    
                    <hr>
                    
                    <div class="modal fade" id="modalExemplo<?php echo $dadosEtapa['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Etapa</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Deseja mesmo excluir <?php echo $dadosEtapa['nome']; ?>?
                                </div>
                                <div class="modal-footer">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <input type="hidden" name="idEtapa" value="<?php echo $dadosEtapa['id']; ?>">
                                        <button type="submit" class="btn btn-danger" name="btn-excluir-etapa">Excluir</button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                
                </div>

                <br>

	            <?php
                        endwhile;
                        endif;

                    }catch(PDOException $e){
                        $erroHomeProjeto[]="Não foi possível carregar os dados das etapas";
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


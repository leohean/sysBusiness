<?php
    require_once "../../php_action/db_connection.php";

    session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    if(isset($_POST['btn-adicionar-etapa-funcionario'])):
        $resultadoEtapaFuncionario=$pdo->prepare("SELECT * FROM mov_usuario_etapa WHERE id_usuario=:idUsuario AND id_etapa=:idEtapa");
        $resultadoEtapaFuncionario->bindParam(':idUsuario',$_SESSION['bomdia']);
        $resultadoEtapaFuncionario->bindParam(':idEtapa',$_POST['idEtapa']);
        $resultadoEtapaFuncionario->execute();

        if($resultadoEtapaFuncionario->rowCount()==0):
            $adicionarEtapaFuncionario=$pdo->prepare('INSERT INTO mov_usuario_etapa (id_usuario, id_etapa) VALUES (:idUsuario,:idEtapa)');
            $adicionarEtapaFuncionario->bindParam(':idUsuario',$_SESSION['bomdia']);
            $adicionarEtapaFuncionario->bindParam(':idEtapa',$_POST['idEtapa']);
            $adicionarEtapaFuncionario->execute();
        endif;
    endif;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" href="../../imagens/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <title>Funcionarios</title>
</head>
<body>

    <input type="checkbox" id="chec">
    
    <label for="chec" class="fixed">
        <img src="../../imagens/menu.png" width="35px">
    </label>

    <nav>
        <ul>
            <li><a href="../projetos/projetos.php" class="link"><i class="fas fa-clipboard"></i> Meus projetos</a></li>
            <li><a href="../../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
        </ul>
    </nav>

    
    <div class="top">

        <hr>

        <div class="container">
        
            <div class="display-4">Etapas</div>
            
            <br>

                        <tbody>

                            <?php
                                try{
                                    $stmtProjetoEmpresa=$pdo->prepare('SELECT * FROM mov_projeto WHERE id_empresa=:id_empresa');
                                    $stmtProjetoEmpresa->bindParam(':id_empresa',$_SESSION['id_usuario']);
                                    $stmtProjetoEmpresa->execute();

                                    if($stmtProjetoEmpresa->rowCount()):
                                        while($dadosProjeto=$stmtProjetoEmpresa->fetch()):
                                            $stmtEtapasProjeto=$pdo->prepare('SELECT * FROM cad_etapa WHERE id_projeto=:id_projeto');
                                            $stmtEtapasProjeto->bindParam(':id_projeto',$dadosProjeto['id']);
                                            $stmtEtapasProjeto->execute();

                                            if($stmtEtapasProjeto->rowCount()):
                                                while($dadosEtapa=$stmtEtapasProjeto->fetch()):
                                        
                            ?>

                            <div class="item">

                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <?php echo $dadosEtapa['nome']; ?>
                                    <input type="hidden" name="idEtapa" value="<?php echo $dadosEtapa['id']; ?>">
                                    <button style="background:transparent; border: none !important;" type="submit" name="btn-adicionar-etapa-funcionario"><i class="fas fa-plus-circle"></i></button></i>
                                </form>  
                    
                                <hr>
                    
                
                            </div>

                            <br>

                            

                                                  
                            

                            <?php 
                                                endwhile;
                                            endif;

                                        endwhile;
                                    endif;

                                }catch(PDOException $e){
                                    $erroEmpresaFuncionario="Não foi possível carregar seus projetos";
                                }finally{
                                    $pdo=null;
                                }
                            ?>
                    
                </div>

            </div>
            
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>

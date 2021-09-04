<?php
    require_once "../../php_action/db_connection.php";

    session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    if(isset($_POST['btn-adicionar-etapa-funcionario'])):
        $oi=1;
        $stmtAdicionarEtapaFuncionario=$pdo->prepare('INSERT INTO mov_usuario_etapa (id_usuario, id_etapa) VALUES (:idUsuario,:idEtapa)');
        $stmtAdicionarEtapaFuncionario->bindParam(':idUsuario',$_SESSION['bomdia']);
        $stmtAdicionarEtapaFuncionario->bindParam(':idEtapa',$_POST['idEtapa']);
        $stmtAdicionarEtapaFuncionario->execute();
    endif;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="shortcut icon" href="../imagens/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/css.css">
	<link rel="stylesheet" href="../../css/barraLateral.css">
    <script src="https://kit.fontawesome.com/fece0716a5.js" crossorigin="anonymous"></script>
    <title>Funcionarios</title>
</head>
<body>

    <input type="checkbox" id="chec">
    
    <label for="chec" class="fixed">
        <img src="../../imagens/menu.png" width="35px">
    </label>

    <nav>
        <ul>
            <li><a href="homeEmpresa.php" class="link"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="projeto.php" class="link"><i class="fas fa-clipboard"></i> Meus projetos</a></li>
            <li><a href="../../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
        </ul>
    </nav>

    
    <div class="top">

        <hr>

        <div class="container">
        
            <div class="display-4">Etapas </div>
            
            <br>

                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead class="thead orange-color">
                            <th scope="col">Nome</th>
                            <th scope="col">Adicionar</th>
                        </thead>

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

                            <tr>
                                <td><?php echo $dadosEtapa['nome']; ?></td>

                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="idEtapa" value="<?php echo $dadosEtapa['id']; ?>">
                                    <td><button style="background:transparent; border: none !important;" type="submit" name="btn-adicionar-etapa-funcionario"><i class="fas fa-plus-circle"></i></button></i></td>
                                </form>                   
                            </tr>

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

                            <tr>
                                <td align="center">- / -</td>
                                <td align="center">- / -</td>
                            <tr>

                        </tbody>

                    </table>
                    
                </div>

            </div>
            
        </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>

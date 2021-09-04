<?php
    require_once "../../php_action/db_connection.php";

    session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    if(isset($_POST['btn-excluir-funcionario'])):
        $stmtExcluirFuncionario=$pdo->prepare("DELETE FROM cad_usuario WHERE id=:idFuncionario");
        $stmtExcluirFuncionario->bindParam(":idFuncionario",$_POST['idFuncionario']);
        $stmtExcluirFuncionario->execute();
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
            <li><a href="../projeto/projeto.php" class="link"><i class="fas fa-clipboard"></i> Meus projetos</a></li>
            <li><a href="../../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
        </ul>
    </nav>

    
    <div class="top">

        <hr>

        <div class="container">
        
            <div class="display-4">Funcionários <a href="cadastroFuncionario.php" style="text-decoration: none; color:black;"><i class="fas fa-plus-circle"></i></a></i></div><br>

                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead class="thead orange-color">
                            <th scope="col">Nome</th> 
                            <th scope="col">Email</th>
                            <th scope="col">Tarefas</th>
                            <th scope="col" class="center">Excluir</th>    
                        </thead>

                        <tbody>

                            <?php
                                try{

                                    $stmtFuncionarios=$pdo->prepare('SELECT * FROM cad_usuario WHERE id_empresa=:aux');
                                    $stmtFuncionarios->bindParam(':aux',$_SESSION['id_usuario']);
                                    $stmtFuncionarios->execute();

                                    if($stmtFuncionarios->rowCount()):
                                        while($dados=$stmtFuncionarios->fetch()):
                            ?>

                            <tr>
                                <td><?php echo $dados['nome']; ?></td>
                                <td><?php echo $dados['email']; ?></td>

                                
                                <td><a href="etapaFuncionario.php?idFuncionario=<?php echo $dados['id']; ?>"><i class="fas fa-clipboard"></i></a></td>
                                <td align="center"><a data-toggle="modal" data-target="#modalExemplo<?php echo $dados['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>

                                <div class="modal fade" id="modalExemplo<?php echo $dados['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Excluir Funcionário</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Deseja mesmo excluir o <?php echo $dados['nome']; ?>?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                                    <input type="hidden" name="idFuncionario" value="<?php echo $dados['id']; ?>">
                                                    <button type="submit" class="btn btn-danger" name="btn-excluir-funcionario">Excluir</button>
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </tr>

                            <?php 
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

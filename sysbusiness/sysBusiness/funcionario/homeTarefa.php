<?php
	require_once '../php_action/db_connection.php';

	session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    $errosHomeTarefa=array();

    try{

	    $stmtDadosEtapa=$pdo->prepare('SELECT * FROM cad_etapa WHERE id=:idEtapa');
	    $stmtDadosEtapa->bindParam(':idEtapa',$_SESSION['id_etapa']);
	    $stmtDadosEtapa->execute();

	    $dados=$stmtDadosEtapa->fetch();

    }catch(PDOException $e){
        $errosHomeTarefa[]="Não foi possível conectar ao banco de dados";
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

    <title><?php echo $dados['nome']; ?></title>
</head>
<body>

    <input type="checkbox" id="chec">
    <label for="chec" class="fixed">
        <img src="../imagens/menu.png" width="35px">
    </label>
    <nav>
        <ul>
            <li><a href="tarefas.php" class="link"><i class="fas fa-clipboard"></i> Minhas Tarefas</a></li>
            <li><a href="../php_action/logout.php" class="link"><i class="fas fa-sign-out-alt"></i>Sair</a></li>
        </ul>
    </nav>

    <div class="top">

        <hr>

        <div class="container">

            <br>

		    <div class="display-4"><?php echo $dados['nome'] ?></div>
            
            <br>

            <div class="flex">

                <?php
                    echo $dados['descri'];
                ?>

        </div>

    <div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>


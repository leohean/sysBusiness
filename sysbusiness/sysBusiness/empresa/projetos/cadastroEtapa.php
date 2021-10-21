<?php
    require_once '../../php_action/db_connection.php';

    session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    $errosEtapa=array();

    try{

        if(isset($_POST['btn-etapa'])):
            $nomeEtapa = $_POST['nomeEtapa'];
            $dataInicioEtapa = $_POST['dataInicioEtapa'];
            $dataFimEtapa = $_POST['dataFimEtapa'];
            $descricaoEtapa = $_POST['descricaoEtapa'];

            $hoje=date('Y/m/d');

            $stmtNomes=$pdo->prepare('SELECT * FROM cad_etapa WHERE nome=:nomeEtapa AND id_projeto=:codProjeto');
            $stmtNomes->bindParam(':nomeEtapa',$nomeEtapa);
            $stmtNomes->bindParam(':codProjeto',$_SESSION['id_projeto']);
            $stmtNomes->execute();

            if($stmtNomes->rowCount()>0):
                $errosCadastroEtapa[]="Você já tem uma etapa com esse nome";
            endif;

            if((strtotime($dataInicioEtapa)<strtotime($hoje))&&(strtotime($dataFimEtapa)<strtotime($hoje))):
                $errosCadastroEtapa[]="A data da etapa não pode ser menor que a data atual";
            endif;

            if(strtotime($dataInicioEtapa)>strtotime($dataFimEtapa)):
                $errosCadastroEtapa[]="A data de fim do etapa não pode ser menor que a de início";
            endif;

            if(empty($errosEtapa)):

                $stmtEtapa=$pdo->prepare('INSERT INTO cad_etapa(nome,descri,data_inicio,data_fim,id_projeto) VALUES (:nomeEtapa,:descricaoEtapa,:dataInicioEtapa,:dataFimEtapa,:idProjeto)');
            
                $stmtEtapa->bindParam(':nomeEtapa',$nomeEtapa);
                $stmtEtapa->bindParam(':descricaoEtapa',$descricaoEtapa);
                $stmtEtapa->bindParam(':dataInicioEtapa',$dataInicioEtapa);
                $stmtEtapa->bindParam(':dataFimEtapa',$dataFimEtapa);
                $stmtEtapa->bindParam(':idProjeto',$_SESSION['id_projeto']);

                $stmtEtapa->execute();

                header('Location:homeProjeto.php');
            endif;
        
        endif;

    }catch(PDOException $e){
        $errosCadastroEtapa[]=$e;
    }finally{
        $pdo=null;
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagens/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/css.css">
    <script src="https://kit.fontawesome.com/fece0716a5.js" crossorigin="anonymous"></script>
	<title>Novo projeto</title>
</head>
<body>

		<div class="container">

			<br>

            <div class="jumbotron gray-color">    
              <div class="display-4">Nova Etapa</div><br>
              <p class="lead text-left">Crie uma nova etapa para o seu projeto.</p> </h1>

              <hr>
              <br>

              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="row">

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <i class="fas fa-user-alt"></i>
                            <label for="nomeProjeto">Nome</label>
                            <input type="text" class="form-control" id="nomeEtapa" name="nomeEtapa" minlength="2" required>
                        </div>
                    </div>
               
                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <i class="fas fa-calendar"></i>
                            <label for="dataInicioProjeto">Data de início</label>
                            <input type="date" class="form-control" id="dataInicioEtapa" name="dataInicioEtapa" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <i class="far fa-calendar"></i>
                            <label for="dataFimProjeto">Data de fim</label>
                            <input type="date" class="form-control" id="dataFimEtapa" name="dataFimEtapa" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <i class="fas fa-info-circle"></i>
                        <label for="descricaoProjeto" class="form-label">Descrição da Etapa</label>
                        <textarea class="form-control" id="descricaoEtapa" name="descricaoEtapa" rows="3"></textarea>
                    </div>
                </div>

                <?php
			        if(!empty($errosCadastroEtapa)):
				        foreach($errosCadastroEtapa as $erro):
					        echo $erro;
				        endforeach;
			        endif;
		        ?>

                <br>
                
                <p align="right">
                    <button type="submit" class="btn btn-success" name="btn-etapa" data-toggle="modal" data-target="#modal1">Criar</button>                   
                </p>

              </form>
          
            </div>
        </div>

		<br>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</body>
</html>
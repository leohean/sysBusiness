<?php
    require_once '../php_action/db_connection.php';

    session_start();

    if(!isset($_SESSION['logado'])):
		header('Location:../../index.html');
	endif;

    $errosProjeto=array();

    try{

        if(isset($_POST['btn-projeto'])):
            $nomeProjeto = $_POST['nomeProjeto'];
            $dataInicioProjeto = $_POST['dataInicioProjeto'];
            $dataFimProjeto = $_POST['dataFimProjeto'];
            $descricaoProjeto = $_POST['descricaoProjeto'];
            $codEmpresa=$_SESSION['id_usuario'];

            $hoje=date('Y/m/d');

            $stmtNomes=$pdo->prepare('SELECT * FROM mov_projeto WHERE nome=:nomeProjeto AND id_empresa=:codEmpresa');
            $stmtNomes->bindParam(':nomeProjeto',$nomeProjeto);
            $stmtNomes->bindParam(':codEmpresa',$codEmpresa);
            $stmtNomes->execute();

            if($stmtNomes->rowCount()>0):
                $errosProjeto[]="Você já tem um projeto com esse nome";
            endif;

            if((strtotime($dataInicioProjeto)<strtotime($hoje))&&(strtotime($dataFimProjeto)<strtotime($hoje))):
                $errosProjeto[]="A data do projeto não pode ser menor que a data atual";
            endif;

            if(strtotime($dataInicioProjeto)>strtotime($dataFimProjeto)):
                $errosProjeto[]="A data de fim do projeto não pode ser menor que a de início";
            endif;

            if(empty($errosProjeto)):

                $stmtProjeto=$pdo->prepare('INSERT INTO mov_projeto(nome,descri,data_inicio,data_fim,id_Empresa) VALUES (:nomeProjeto,:descricaoProjeto,:dataInicioProjeto,:dataFimProjeto,:codEmpresa)');
            
                $stmtProjeto->bindParam(':nomeProjeto',$nomeProjeto);
                $stmtProjeto->bindParam(':descricaoProjeto',$descricaoProjeto);
                $stmtProjeto->bindParam(':dataInicioProjeto',$dataInicioProjeto);
                $stmtProjeto->bindParam(':dataFimProjeto',$dataFimProjeto);
                $stmtProjeto->bindParam(':codEmpresa',$codEmpresa);

                $stmtProjeto->execute();

                header('Location:projeto.php');
            endif;
        
        endif;

    }catch(PDOException $e){
        $errosProjeto[]=$e->getMessage();
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
              <div class="display-4">Novo Projeto</div><br>

              <hr>
              <br>

              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <div class="row">

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <i class="fas fa-user-alt"></i>
                            <label for="nomeProjeto">Nome</label>
                            <input type="text" class="form-control" id="nomeProjeto" name="nomeProjeto" minlength="2" required>
                        </div>
                    </div>
               
                </div>

                <div class="row">

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <i class="fas fa-calendar"></i>
                            <label for="dataInicioProjeto">Data de início</label>
                            <input type="date" class="form-control" id="dataInicioProjeto" name="dataInicioProjeto" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <i class="far fa-calendar"></i>
                            <label for="dataFimProjeto">Data de fim</label>
                            <input type="date" class="form-control" id="dataFimProjeto" name="dataFimProjeto" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <i class="fas fa-info-circle"></i>
                        <label for="descricaoProjeto" class="form-label">Descrição do projeto</label>
                        <textarea class="form-control" id="descricaoProjeto" name="descricaoProjeto" rows="3"></textarea>
                    </div>
                </div>

                <?php
			        if(!empty($errosProjeto)):
				        foreach($errosProjeto as $erro):
					        echo $erro;
				        endforeach;
			        endif;
		        ?>

                <br>
                
                <p align="right">
                    <button type="submit" class="btn btn-success" name="btn-projeto" data-toggle="modal" data-target="#modal1">Criar</button>                   
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
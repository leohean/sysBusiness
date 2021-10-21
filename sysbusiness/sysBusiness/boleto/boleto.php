<?php

require("../openboleto-master/autoloader.php");

session_start();

use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;

$sacado = new Agente($_SESSION['nome'], $_SESSION['cpf']);
$cedente = new Agente('SysBusiness', 'xxxxx', 'xxxxx', 'xxxxx', 'Limeira', 'SP');

$boleto = new Bradesco(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime('2022-01-01'),
    'valor' => $_SESSION['valor'],
    'sequencial' => 123456789, // Até 11 dígitos
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => 0000, // Até 4 dígitos
    'carteira' => 6, // 3, 6 ou 9
    'conta' => 0000000, // Até 7 dígitos

    // Parâmetros recomendáveis
    //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
    'contaDv' => 1,
    'agenciaDv' => 1,
    'carteiraDv' => 1,
    'descricaoDemonstrativo' => array( // Até 5
        'Doação',
    )

    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'cip' => '000', // Apenas para o Bradesco
    //'moeda' => Bradesco::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    //'especieDoc' => 'ABC',
    //'numeroDocumento' => '123.456.789',
    //'usoBanco' => 'Uso banco',
    //'layout' => 'layout.phtml',
    //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
    //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
    //'descontosAbatimentos' => 123.12,
    //'moraMulta' => 123.12,
    //'outrasDeducoes' => 123.12,
    //'outrosAcrescimos' => 123.12,
    //'valorCobrado' => 123.12,
    //'valorUnitario' => 123.12,
    //'quantidade' => 1,
));

echo $boleto->getOutput();

?>

<html>
    <head>
    </head>
    <body>
        <button onClick="window.print();">Imprimir</button>
        <script type="text/javascript">
            function imprimir(){
                window.print();
            }
        </script>
    </body>
</html>

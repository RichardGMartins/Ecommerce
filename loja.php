<?php 
#Conexão com o banco
include("cabecalholoja.php");
#PASSANDO UMA INSTRUÇÃO AO BANCO DE DADOS
$sql = "SELECT * FROM produtos WHERE prod_ativo = 's'";
$retorno = mysqli_query($link, $sql);
#FORÇA SEMPRE TRAZER 'S' NA VÁRIAVEL PARA UTILIZARMOS NOS RADIO BUTTON
#COLETA O BOTÃO MÉTODO POST VINDO DO HTML
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel= "stylesheet" href="./css/estiloadm.css">
        <title>LOJA</title>
    </head>
    <body>
        <div class="div-form">
            <div class="shopping">
                    <?php
                    #FAZENDO O PREENCHIMENTO DE TABELA USANDO WHILE (ENQUANTO TEM DADOS RODA PREENCHENDO)
                    while ($tbl = mysqli_fetch_array($retorno)) {
                        #Mais aqui eu fecho para trabalhar com HTML SIMULTANEAMENTE
                    ?>
                        <div class="product-card">
                            <h3><img src="data:image/jpeg;base64,<?= $tbl[6] ?>" width="100" height="100" ></h3><!--TRAZ SOMENTE A COLUNA 6 [IMagem] DO BANCO-->
                            <h3><?= $tbl[1] ?></h3> <!--TRAZ SOMENTE A COLUNA 1 [nome] DO BANCO-->
                            <h3>R$<?=  number_format($tbl[4],2,',','.') ?></h3><!--TRAZ SOMENTE A COLUNA 4 [VALOR] DO BANCO-->
                            <?php 
                            if ($tbl[3] > 0 ){
                            ?>
                            <button onclick="location.href='verproduto.php?id=<?=$tbl[0]?>'" class="product-button">Comprar</button>
                            <?php 
                            } else {
                            ?>  
                            <button <?=$tbl[0]?> class="product-button2">Fora de Estoque</button>
                            <?php
                            }
                            ?>
                        </div> 
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
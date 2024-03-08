<?php 
#Conexão com o banco
include("cabecalho.php");
#PASSANDO UMA INSTRUÇÃO AO BANCO DE DADOS
$sql = "SELECT * FROM produtos WHERE prod_ativo = 's'";
$retorno = mysqli_query($link, $sql);
#FORÇA SEMPRE TRAZER 'S' NA VÁRIAVEL PARA UTILIZARMOS NOS RADIO BUTTON
$ativo = "s";
#COLETA O BOTÃO MÉTODO POST VINDO DO HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ativo = $_POST ['ativo'];
    #VERIFICA SE O USUARIO ESTÁ ATIVO PARA LISTAR, SE 'S' LISTA SENÃO, NÃO LISTA E Puxa se todos os Produtos
    if ($ativo == 's') {
        $sql = "SELECT * FROM produtos WHERE prod_ativo = 's'";
        $retorno = mysqli_query($link, $sql); 
    }
    else if ($ativo == 't') {
        $sql = "SELECT * FROM produtos ORDER BY prod_id";
        $retorno = mysqli_query($link, $sql);
    }
    else {
        $sql = "SELECT * FROM produtos WHERE prod_ativo = 'n'";
        $retorno = mysqli_query($link, $sql);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel= "stylesheet" href="./css/estiloadm.css">
        <title>Lista de Produtos</title>
    </head>
    <body>
        <div id="background">
            <form action="listaprodutos.php" method="post">
                <!-- Required é usado para o usuario tentar passar em branco o cadastro e impedir o mesmo -->
                <input type="radio" name ="ativo" class="radio" value="s" required onclick="submit()" <?= $ativo == 's' ? "checked" : "" ?>> ATIVOS 
                <br>
                <input type="radio" name ="ativo" class="radio" value="n" required onclick="submit()" <?= $ativo == 'n' ? "checked" : "" ?>> INATIVOS 
                <br>   
                <input type="radio" name="ativo" class="radio" value="t" required onclick="submit()" <?= $ativo =='t' ? "checked" : "" ?>> TODOS 
            </form>
            <div class="container">
                <table border="1">
                    <tr>
                        <th>NOME</th>
                        <th>DESCRIÇÃO</th>
                        <th>QUANTIDADE ESTOQUE</th>
                        <th>VALOR</th>
                        <th>IMAGEM</th>
                        <th>ALTERAR DADOS</th>
                        <th>ATIVO</th>
                    </tr>
                    <!--INICIO DE PHP + HTML-->
                    <?php
                    #FAZENDO O PREENCHIMENTO DE TABELA USANDO WHILE (ENQUANTO TEM DADOS RODA PREENCHENDO)
                    while ($tbl = mysqli_fetch_array($retorno)) {
                        #Mais aqui eu fecho para trabalhar com HTML SIMULTANEAMENTE
                    ?>
                        <tr>
                            <td><?= $tbl[1] ?></td> <!--TRAZ SOMENTE A COLUNA 1 [nome] DO BANCO-->
                            <td><?= $tbl[2] ?></td><!--TRAZ SOMENTE A COLUNA 2 [descrição] DO BANCO-->
                            <td><?= $tbl[3] ?></td><!--TRAZ SOMENTE A COLUNA 3 [Qtde Estoque] DO BANCO-->
                            <td>R$<?=  number_format($tbl[5],2,',','.') ?></td><!--TRAZ SOMENTE A COLUNA 4 [VALOR] DO BANCO-->
                            <td><img src="data:image/jpeg;base64,<?= $tbl[6] ?>" width="100" height="100" ></td><!--TRAZ SOMENTE A COLUNA 6 [IMagem] DO BANCO-->
                            <td><a href="alteraproduto.php?id=<?= $tbl[0] ?>"><input type="button" value ="ALTERAR DADOS"></a></td>
                            <td><?= $check = ($tbl[5] == "s") ? "SIM" : "NÃO" ?></td> 
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
<?php 
#Conexão com o banco
include("cabecalho.php");
#PASSANDO UMA INSTRUÇÃO AO BANCO DE DADOS
$sql = "SELECT * FROM clientes WHERE cli_ativo = 's'";
$retorno = mysqli_query($link, $sql);
#FORÇA SEMPRE TRAZER 'S' NA VÁRIAVEL PARA UTILIZARMOS NOS RADIO BUTTON
$ativo = "s";
#COLETA O BOTÃO MÉTODO POST VINDO DO HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $ativo = $_POST ['ativo'];
    #VERIFICA SE O USUARIO ESTÁ ATIVO PARA LISTAR, SE 'S' LISTA SENÃO, NÃO LISTA e Puxa todos o usuarios
    if ($ativo == 's') {
        $sql = "SELECT * FROM clientes WHERE cli_ativo = 's'";
        $retorno = mysqli_query($link, $sql); 
    }
    else if ($ativo == 't') {
        $sql = "SELECT * FROM clientes ORDER BY cli_id";
        $retorno = mysqli_query($link,$sql);
    }
    else {
        $sql = "SELECT * FROM clientes WHERE cli_ativo = 'n'";
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
        <title>Lista dos CLientes</title>
    </head>
    <body>
        <div id="background">
            <form action="listaclientes.php" method="post">
                <!-- Required é usado para o usuario tentar passar em branco o cadastro e impedir o mesmo -->
                <input type="radio" name ="ativo" class="radio" value="s" required onclick="submit()" <?= $ativo == 's' ? "checked" : "" ?>> ATIVOS 
                <br>
                <input type="radio" name ="ativo" class="radio" value="n" required onclick="submit()" <?= $ativo == 'n' ? "checked" : "" ?>> INATIVOS 
                <br>  
                <input type="radio" name ="ativo" class="radio" value="t" required onclick="submit()" <?= $ativo == 't' ? "checked" : "" ?>> TODOS
                <br>  

            </form>
            <div class="container">
                <table border="1">
                    <tr>
                        <th>NOME</th>
                        <th>ATIVO</th>
                        <th>EMAIL</th>
                    </tr>
                    <!--INICIO DE PHP + HTML-->
                    <?php
                    #FAZENDO O PREENCHIMENTO DE TABELA USANDO WHILE (ENQUANTO TEM DADOS RODA PREENCHENDO)
                    while ($tbl = mysqli_fetch_array($retorno)) {
                        #Mais aqui eu fecho para trabalhar com HTML SIMULTANEAMENTE

                    ?>
                        <tr>
                            <td><?= $tbl[1] ?></td> <!--TRAZ SOMENTE A COLUNA 1 [nome] DO BANCO-->
                            <!--AO CLICAR NO BOTÃO ELE JA TRARA O ID DO USUARIO PARA PAGINA DO ALTERAR -->
                            <td><?= $check = ($tbl[3] == "s") ? "SIM" : "NÃO" ?></td> 
                            <td><?= $tbl[5] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
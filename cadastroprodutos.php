<?php 
#Inicia a conexão com o banco de dados

include("conectadb.php");
#Coleta de variáveis via formulário de HTML
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $file = $_POST['imagem'];

    #POSSANDO INSTRUÇÕES SQL PARA O BANCO
    #VALIDANDO SE USUARIO EXISTE

    $sql = "SELECT COUNT(prod_id) FROM produtos WHERE prod_nome = '$nome' AND prod_ativo = 's'";
    $retorno = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($retorno))
    {
        $cont = $tbl[0];
    }
    #VERIFICAÇÃO SE USUARIO EXISTE, SE EXISTE = 1 SENÃO = 0
    if ($cont == 1)
    {
        echo "<script>window.alert('PRODUTOD JÁ CADASTRADO!';</script>)";
    }
    else
    {
        $sql = "INSERT INTO produtos(prod_nome, prod_descricao,prod_quantidade,prod_valor,prod_ativo,prod_img)
         VALUES ('$nome','$descricao','$quantidade','$valor','n','$file')";
        mysqli_query($link, $sql);
        echo "<script>window.alert('PRODUTO CADASTRADO COM SUCESSO');</script>";
        echo "<script>window.location.href='cadastroprodutos.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href="./css/estiloadm.css">
    <title>Cadastro Produtos</title>
</head>
<body>
    <div>
        <form action="cadastroprodutos.php" method="post">
            <input type="text" name ="nome" id="nome" placeholder="Nome de Usuario"><br>
            <textarea type="text" name ="descricao" id="descricao" placeholder="Descrição" rows="5"></textarea><br>
            <input type="number" name ="quantidade" id="quantidade" placeholder="Quantidade"><br>
            <input type="number" name ="valor" id="valor " step="0.01" placeholder="Valor do Produto"><br>
            <input type="file" name ="imagem" id="imagem" placeholder="Insira a imagem"><br>
            <input type="submit" name ="cadastrar" id="cadastrar" placeholder="Cadastrar"><br>
        </form>
    </div>
</body>
</html>
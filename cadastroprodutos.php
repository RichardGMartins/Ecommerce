<?php 
#Inicia a conexão com o banco de dados

include("conectadb.php");
#Coleta de variáveis via formulário de HTML
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor = str_replace(",",".",$_POST['valor']);
    $file = $_POST['imagem'];

    $nome = trim($nome);
    $descricao= trim($descricao);
    #POSSANDO INSTRUÇÕES SQL PARA O BANCO
    #VALIDANDO SE USUARIO EXISTE
    if(isset ($_FILES['imagem']) && $_FILE['imagem']['error']===UPLOAD_ERR_OK){
        $tipo = exif_imagetype($_FILE['imagem']['tmp_name']);
        if ($tipo !== false) {
            //o arquivo é uma imagem
            $imagem_temp = $_FILE['imagem']['tmp_name'];
            $imagem = file_get_contents($imagem_temp);
            $imagem_base64 = base64_encode($imagem);
        } else {
            //o arquivo não é uma imagem
            $imagem = file_get_contents('C:\xampp\htdocs\projetosti26\ecommerce\img\alert.jpg');
            $imagem_base64 = base64_encode($imagem);
        }
    } else {
        // o arquivo não foi enviado
        $imagem = file_get_contents('C:\xampp\htdocs\projetosti26\ecommerce\img\alert.jpg');
        $imagem_base64 = base64_encode($imagem);
    }
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
        if ($nome == "" || $descricao == "") 
        {
            echo "<script>window.alert('Por favor preencha os campos corretamente!');</script>";
            echo "<script>window.location.href='cadastroprodutos.php';</script>";
        }
        else
        {
        $sql = "INSERT INTO produtos(prod_nome, prod_descricao,prod_quantidade,prod_valor,prod_ativo,prod_img)
         VALUES ('$nome','$descricao','$quantidade','$valor','n','$imagem_base64')";
        mysqli_query($link, $sql);
        echo "<script>window.alert('PRODUTO CADASTRADO COM SUCESSO');</script>";
        echo "<script>window.location.href='cadastroprodutos.php';</script>";
        }
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
            <input type="text" name ="nome" id="nome" placeholder="Nome de Usuario" required><br>
            <textarea type="text" name ="descricao" id="descricao" placeholder="Descrição" rows="5" required></textarea><br>
            <input type="number" min="0" name ="quantidade" id="quantidade" placeholder="Quantidade" required><br>
            <input type="number" min="0" name ="valor" id="valor " step="0.01" placeholder="Valor do Produto" required><br>
            <input type="file" name ="imagem" id="imagem" placeholder="Insira a imagem" required><br>
            <input type="submit" name ="cadastrar" id="cadastrar" placeholder="Cadastrar"><br>
        </form>
    </div>
</body>
</html>
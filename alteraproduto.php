<?php 
include("cabecalho.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
     $id = $_POST['id'];
     $nome = $_POST['nome'];
     $descricao = $_POST['descricao'];
     $quantidade = $_POST['quantidade'];
     $ativo = $_POST['ativo'];
     $valor = $_POST['valor'];

     if(isset ($_FILES['imagem']) && $_FILES['imagem']['error']===UPLOAD_ERR_OK){
        $tipo = exif_imagetype($_FILES['imagem']['tmp_name']);
        if ($tipo !== false) {
            //o arquivo é uma imagem
            $imagem_temp = $_FILES['imagem']['tmp_name'];
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
    $sql = "UPDATE produtos SET prod_nome = '$nome',prod_descricao = '$descricao',prod_quantidade = '$quantidade',prod_valor = '$valor', prod_ativo = '$ativo', prod_file = '$imagem_base64' WHERE prod_id = $id";
    mysqli_query($link,$sql);

    echo("<script>window.alert('Produto alterado com sucesso !')</script>");
    echo("<script>window.location.href='listaprodutos.php';</script>");
    exit();
}
    $id = $_GET['id'];
    $sql = "SELECT * FROM produtos WHERE prod_id =$id";
    $retorno = mysqli_query($link,$sql);

    while ($tbl = mysqli_fetch_array($retorno)){
        $nome = $tbl[1]; #Campo nome
        $descricao = $tbl[2]; #Campo Descrição
        $quantidade = $tbl[3]; #Campo Quantidade
        $valor = $tbl[4];# Campo Valor
        $ativo = $tbl[5];# Campo Ativo
        $imagem_base64 = $tbl[6];#Campo Img
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produtos</title>
    <link rel="stylesheet" href="./css/estiloadm.css" >
</head>
<body>
<div class="div-form2">
        <form action="alteraproduto.php" method="post" enctype="multipart/form-data">
            <h2>Alteração Produtos</h2>
         <input type="hidden" name="id" value="<?= $id ?>">
            <label>Nome</label>
            <input type="text" name ="descricao" id="nome" value="<?= $nome?>" required></input>
            <label>Descrição</label>
            <input type="text" min="0" name ="descricao" id="descricao" value="<?=$descricao?>" required>
            <label>Quantidade</label>
            <input type="number" min="0" name ="quantidade" id="quantidade" value="<?= $quantidade ?>" required>
            <label>Valor</label>
            <input type="number" min="0" name ="valor" id="valor " step="0.01" value="<?= $valor ?>" required>
            <label>Imagem</label>
            <input type="file" name ="imagem" id="imagem" value="<?= $imagem_base64 ?>" required>
            <label id="lb-form">Status: <?= $check = ($ativo =='s') ? "Ativo" : "Inativo" ?> </label>
            <br>
            <input type="radio" name = "ativo" value="s" <?=$ativo == "s" ? "checked" : "" ?>> <li>ATIVO</li> <br>
            <input type="radio" name = "ativo"  value="n" <?=$ativo == "n" ? "checked" : "" ?>> <li>INATIVO</li> <br>
            <button type="submit" name ="cadastrar" id="btn">Alterar </button>
        </form>
    </div>
    <div class="imagem-div">
        <h2 id="imagem-div-h2">Imagem Atual</h2>
        <td><img name = "imagem_atual" class ="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_base64?>"></td>
    </div>
    
</body>
</html>
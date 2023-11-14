<?php 
include ('cabecalholoja.php');

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $id = $_POST['id'];
    $nomeproduto = $_POST['nomeproduto'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $quantidade = (int)$quantidade;
    $preco = $_POST['preco'];
    $preco = (float)$preco;
    $totalitem = (($preco));
    $numerocarrinho = ($idclientes . RAND());


if ($idclientes <= 0){
    echo"<script>window.alert('VOCÊ PRECISA FAZER O LOGIN PARA ADICIONAR AO CARRINHO');</script>";
    echo"<script>window.location.href='loja.php';</script>";
} else {
    //VERIFICA SE EXISTE UM CARRINHO JÁ ABERTO
    $sql = "SELECT COUNT(car_id) FROM carrinho INNER JOIN clientes ON fk_cli_id = cli_id WHERE cli_id = $idclientes AND car_finalizada = 'n'";
    
    $retorno = mysqli_query($link,$sql);
    //SE CARRINHO NÃO EXISTE CRIA UM NOVO CARRINHO

    while ($tbl = mysqli_fetch_array($retorno)){
        $cont = $tbl[0];

        if($cont == 0) {
            $valor_venda = $quantidade * $preco;

            //SE O CARRINHO NÃO EXISTE GERA UM NOVO CARRINHO E INSERE NA TABELA  ITENS DO CARRINHO
            $sql = "INSERT INTO carrinho(car_id, car_valorvenda,fk_cli_id, car_finalizada) VALUES ('$numerocarrinho',$valor_venda,$idclientes,'n')";
            mysqli_query($link,$sql);

            $sql2 = "INSERT INTO item_carrinho(fk_car_id,fk_pro_id,car_item_quantidade) VALUES ('$numerocarrinho',$id,$quantidade)";
            mysqli_query($link,$sql2);
            $_SESSION['carrinhoid'] = $numerocarrinho;
            echo"<script>window.alert('PRODUTO ADICIONADO AO CARRINHO $numerocarrinho');</script>";
            echo"<script>window.location.href='loja.php';</script>";
        }else {
            //SE CARRINHO EXISTE , CONSULTA O NUMERO DO CARRINHO PARA ADICIONAR MAIS ITEMS
            $sql ="SELECT car_id FROM carrinho WHERE fk_cli_id = '$idclientes' AND car_finalizada = 'n' ";
            $retorno = mysqli_query($link,$sql);

            while($tbl = mysqli_fetch_array($retorno)){
                $numerocarrinho = $tbl[0];
                $_SESSION['carrinhoid'] = $numerocarrinho;
                
                #Verifica se já existe esse item ao carrinho
                #Se já existe, atualiza a quantidade
                $sql2 = "SELECT car_item_quantidade FROM item_carrinho WHERE fk_car_id = '$numerocarrinho' AND fk_pro_id = $id";
                $retorno2 = mysqli_query($link,$sql2);
                $qntd_atual = mysqli_fetch_array($retorno2);

                if ($retorno2){
                    if (mysqli_num_rows($retorno2) >= 1){
                        $sql = "UPDATE item_carrinho SET car_item_quantidade = ($quantidade+$qntd_atual[0]) WHERE fk_car_id = '$numerocarrinho'";
                        mysqli_query($link, $sql);
                        echo ("<script>window.alert('Produto adicionado ao carrinho $numerocarrinho');</script>");
                        echo ("<script>window.location.href='loja.php';</script>");
                    }
                    #Se já existe, adiciona o novo item
                    else{
                        $sql = "INSERT INTO item_carrinho(fk_car_id, fk_pro_id, car_item_quantidade) VALUES ('$numerocarrinho','$id',$quantidade)";
                        mysqli_query($link,$sql);
                        echo ("<script>window.alert('Produto adicionado ao carrinho $numerocarrinho');</script>");
                        echo ("<script>window.location.href='loja.php';</script>");
                    }
                }
            }
        } 
    }
    } 
    echo ("<script>window.location.href='loja.php';</script>");
    exit();
}
$id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE prod_id = $id";
$retorno = mysqli_query($link,$sql);
while($tbl = mysqli_fetch_array($retorno)){
    $id = $tbl[0];
    $nomeproduto = $tbl[1];
    $descricao = $tbl[2]; 
    $preco = $tbl[4]; 
    $imagem_atual = $tbl[6];
}
if(isset($idclientes)){
    $sql = "SELECT COUNT(fav_id) FROM favoritos WHERE fk_cli_id = $idclientes AND fk_pro_id = $id";
    $retorno = mysqli_query($link,$sql);

    while($tbl = mysqli_fetch_array($retorno)){
        $cont = $tbl[0];
        if($cont <= 0){
            $coracao = "https://icones.pro/wp-content/uploads/2021/02/icone-de-coeur-noir.png";
        } else {
            $coracao = "https://icones.pro/wp-content/uploads/2021/02/icone-de-coeur-rouge-1.png";
        }
    }
}else {
    $coracao = "https://icones.pro/wp-content/uploads/2021/02/icone-de-coeur-noir.png"; 
}

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>Ver Produtos</title>
</head>
<body>
    <div class="div-form3">
        <form action="verproduto.php" class="visualizaproduto" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>" readonly>
            <label>NOME</label>
            <input type="text" name="nomeproduto" id="nome" value="<?=$nomeproduto?>" readonly>
            <label>DESCRIÇÃO</label>
            <textarea name="descricao" readonly><?=$descricao?></textarea>
            <label>QUANTIDADE</label>
            <input type="number" name="quantidade" id="quantidade" min="1" value="1">
            <label>PREÇO</label>
            <input type="number" name="preco" id="preco" value="<?=$preco?>" readonly>
            <button type="submit" id="btn">ADICIONAR AO CARRINHO </button>
        </form>
    </div>
    <div class="favoritos">
            <td><img name="imagem_atual" class="imagem_atual2" src="data:imagem/jpeg;base64, <?= $imagem_atual ?>"></td>
            <a href="favoritar.php?id=<?= $id ?>"><img class="heart" src="<?php echo $coracao; ?>" width="50" height="50"/></a>
    </div>
</body>
</html>
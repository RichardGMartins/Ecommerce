<?php 
include("cabecalholoja.php");

$idclientes = $_SESSION['idclientes'];

$sql = "SELECT c.car_id, c.fk_cli_id, c.car_finalizada,p.prod_id,p.prod_nome,p.prod_descricao,p.prod_valor,p.prod_img,
ic.car_item_quantidade,ic.fk_car_id,ic.fk_pro_id FROM carrinho c JOIN item_carrinho ic ON c.car_id = ic.fk_car_id JOIN produtos p ON 
ic.fk_pro_id = p.prod_id WHERE c.fk_cli_id = $idclientes AND c.car_finalizada = 'n'";
$retorno = mysqli_query($link,$sql);
$retorno2 = mysqli_query($link,$sql);

$total = 0;

while($row = mysqli_fetch_assoc($retorno2)){
    $preco = $row['prod_valor'];
    $quantidade =$row['car_item_quantidade'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href="./css/estiloadm.css">
    <title>Carrinho</title>
</head>
<body>
    <div class="div-form3" id="total">Total R$ <?=$total?>
    <button id="btn2"><a href="finaliza_carrinho.php?id=<?=($idclientes)?>">Finaliza Carrinho</a></button></div>

    <?php
    while ($tbl = mysqli_fetch_array($retorno)){
        ?>
        <div class="div-form4">
            <img class="img2" src="data:image/jpeg;base64,<?=$tbl[7]?>" alt="Product Image">
            <h3 class="titulo"><?= $tbl[4] ?></h3>
            <h3 class="preco">R$ <?= $tbl[6] * $tbl[8]?></h3>
            <label class="quantidade">Quantidade</label>
            <div>
            <button onclick="location.href='atualizar_carrinho.php?var1=<?= $tbl[3]?>&var2=<?= $tbl[8] - 1?>'" class="plus-button1">-</button>
            <h3 class="number"><?= $tbl[8]?></h3>
            <button onclick="location.href='atualizar_carrinho.php?var1=<?= $tbl[3]?>&var2=<?= $tbl[8] + 1?>'" class="plus-button2">+</button>
            </div>
            <br>
            <button onclick="location.href='delete_produto_carrinho.php?var1=<?= $tbl[3]?>&var2=<?= $tbl[0]?>'"
            class="plus-button">Excluir do carrinho</button>
        </div>
    <?php
    }
    ?>
</body>
</html>
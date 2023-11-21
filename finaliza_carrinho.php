<?php 
include('cabecalholoja.php');

$sql = "SELECT c.car_id, c.fk_cli_id, c.car_finalizada,p.prod_id,p.prod_nome,p.prod_descricao,p.prod_valor,p.prod_img,
ic.car_item_quantidade,ic.fk_car_id,ic.fk_pro_id FROM carrinho c JOIN item_carrinho ic ON c.car_id = ic.fk_car_id JOIN produtos p ON 
ic.fk_pro_id = p.prod_id WHERE c.fk_cli_id = $idclientes AND c.car_finalizada = 'n'";
#Para remover os items do carrinho
$retorno = mysqli_query($link,$sql);
#Para fazer o total
$retorno2 = mysqli_query($link,$sql);
#Finalização do carrinho
$retorno3 = mysqli_query($link,$sql);

$total = 0;

while ($row = mysqli_fetch_assoc($retorno2)){
    $preco = $row['prod_valor'];
    $quantidade = $row['car_item_quantidade'];
    $subtotal = $preco * $quantidade;

    $total += $subtotal;
}


while ($tbl = mysqli_fetch_array($retorno)){
    $sql3 = "SELECT prod_quantidade FROM produtos WHERE prod_id = $tbl[3]";

    $retorno4 = mysqli_query($link,$sql3);
        while($row = mysqli_fetch_assoc($retorno4)){
            $quantidade_produto = $row['prod_quantidade'];
            $sql4 = "UPDATE produtos SET prod_quantidade = $quantidade_produto - $tbl[8] WHERE prod_id = $tbl[3]";

            $resultado4 = mysqli_query($link,$sql4);
        }
}

$tbl = mysqli_fetch_array($retorno3);
#INCLUI O TOTAL, DATA DA VENDA E FINALIZA O CARRINHO
$data = date("Y-m-d");#PEGANDO O DIA ATUAL

#PEGANDO O TOTAL DE ITENS QUE  TEM NO CARRINHO
$sql2 = "SELECT COUNT(*) FROM item_carrinho WHERE fk_car_id = $tbl[0]";
$retorno3 = mysqli_query($link,$sql2);
$total_itens = mysqli_fetch_array($retorno3);
#REALIZANDO O UPDATE PARA FINALIZAÇÃO DO CARRINHO
$sql_total = "UPDATE carrinho SET car_valorvenda = $total,car_datavenda='$data', car_finalizada ='s',car_total_item = $total_itens[0] WHERE car_id = $tbl[0]";
$resultado2 = mysqli_query($link,$sql_total);



header("Location: loja.php");

?>
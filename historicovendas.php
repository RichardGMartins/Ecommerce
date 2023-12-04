<?php 
include("cabecalho.php");

$sql = "SELECT car_id,car_valorvenda, car_datavenda, car_total_item, cli_nome, fk_cli_id FROM carrinho INNER JOIN clientes ON fk_cli_id = cli_id WHERE car_finalizada = 's'"; 
$return = mysqli_query($link,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href="./css/estiloadm.css">
    <title>VENDAS</title>
</head>
<body>
    <div class="div-form6">
    <table border="1">
        <h3>HISTORICO DE VENDAS</h3>
        <th>Valor da Venda</th>
        <th>Data da Venda</th>
        <th>Total de itens</th>
        <th>ID Cliente</th>
        <th>Cliente</th>
        <?php 
        while ($tbl = mysqli_fetch_array($return)){
            ?>
        <tr>
            <td>R$ <?= $tbl[1]?></td>
            <td><?= $tbl[2]?></td>
            <td><?= $tbl[3]?></td>
            <td><?= $tbl[5]?></td>
            <td><?= $tbl[4]?></td>
        </tr>
        <?php } ?>
    </table>
    </div>
</body>
</html>
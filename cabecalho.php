<?php 
include ("conectadb.php");
session_start();
//isset é para saber se esta logado
isset($_SESSION['nomeusuario'])?$nomeusuario = $_SESSION['nomeusuario']:"";
$nomeusuario = $_SESSION['nomeusuario'];
?>

<div>
    <ul class="menu">
        <li><a href="cadastrousuario.php">CADASTRA USUARIO</a></li>
        <li><a href="listausuarios.php">LISTAR USUARIOS</a></li>
        <li><a href="cadastroprodutos.php">CADASTRA PRODUTOS</a></li>
        <li><a href="listaprodutos.php">LISTAR PRODUTOS</a></li>
        <li><a href="listaclientes.php">LISTAR CLIENTES</a></li>
        <li><a href="vendas.php">VENDAS</a></li>
        <li class="menuloja"><a href="logout.php">SAIR</a></li>

        <?php
        if($nomeusuario != null){
        ?>
            <li class="profile">OLÁ <?= strtoupper($nomeusuario)?></li>
        <?php
        } else {
            ?>
            <li class="profile">OLÁ <?= strtoupper($nomeusuario)?>aa</li>
        <?php 
            echo "<script>window.alert('USUARIO NÃO AUTENTICADO');window.location.href='login.php';</script>";
        }
        ?>
    </ul>
</div>
<?php 
include ("conectadb.php");
session_start();
//isset é para saber se esta logado
isset($_SESSION['nomeclientes'])?$nomeclientes = $_SESSION['nomeclientes']:"";
$nomeclientes = $_SESSION['nomeclientes'];

isset($_SESSION['idclientes'])?$idclientes = $_SESSION['idclientes']:"";
$idclientes = $_SESSION['idclientes'];
?>


<div>
    <ul class="menu-loja">
        <li><a href="loja.php">HOME</a></li>
        <li><a href="carrinho.php">CARRINHO</a></li>
        <li class="menuloja"><a href="logoutclientes.php">SAIR</a></li>

        <?php
        if($nomeclientes != null){
        ?>
            <li class="profile">OLÁ <?= strtoupper($nomeclientes)?></li>
        <?php
        } else {
            ?>
            <li class="profile">OLÁ <?= strtoupper($nomeclientes)?>aa</li>
        <?php 
            echo "<script>window.alert('USUARIO NÃO AUTENTICADO');window.location.href='loginusuario.php';</script>";
        }
        ?>
    </ul>
</div>
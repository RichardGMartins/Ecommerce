<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
include('conectadb.php');
$email =$_POST['email'];
$cod =$_POST['cod'];
$senha =$_POST['senha'];

if($cod ==""){
    header("Location:redefine_senha.php?msg=Código Inválido!");
    exit();
    }
    $sql ="SELECT COUNT(cli_id) FROM clientes WHERE cli_email ='$email' AND cli_recupera ='$cod'";
    $result = mysqli_query($link,$sql);

    $tbl = mysqli_fetch_array($result);
    $cont = $tbl[0];
    if($cont == 0){
        $sql ="UPDATE clientes SET cli_recupera = '' WHERE cli_email = '$email'";
        mysqli_query($link,$sql);
        header("Location:redefine_senha.php?msg=Código Inválido! Solicite um novo código!");
        exit();
    } else{
        $random = rand();
        $tempero= md5(rand() . date('H:i:s'));
        $senha= md5($senha . $tempero);
        $sql = "UPDATE clientes SET cli_senha = '$senha', cli_tempero= '$tempero', cli_recupera=$random WHERE cli_email='$email'";
        mysqli_query($link,$sql);
        header("Location:loja.php?msg=Senha alterada com sucesso!");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefine senha</title>
</head>
<body>
    <div class="div-form">
        <form action="redefinesenha.php" method="post">
            <h1>Redefinir Senha</h1>
            <input type="text" name="email" id="email" placeholder="Email" required>
            <br>
            <input type="text" name="cod" id="cod" placeholder="Codigo" required>
            <br>
            <input type="password" id="senha" name="senha" placeholder="Senha">
            <br>
            <button type="submit" id="btn">Redefinir</button>
        </form>
    </div>
    <p id="msg">
        <?php
        if(isset($_GET['msg'])){
            echo($_GET['msg']);
            if($_GET['msg'] == "Usuario ou senha incorretos"){
                echo("<br><a href='recuperasenha.php'>Esqueci minha senha</a>");
            }
        }
        ?>
    </p>
</body>
</html>
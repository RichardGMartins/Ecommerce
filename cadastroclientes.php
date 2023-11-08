<?php 
#Inicia a conexão com o banco de dados

include("conectadb.php");
#Coleta de variáveis via formulário de HTML
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];

    #Trim é usado para tirar os espaços do começo e do fim do nome para armazenar sem spacebar
    $nome = trim($nome);
    $senha = trim($senha);
    $email = trim($email);
    #POSSANDO INSTRUÇÕES SQL PARA O BANCO
    #VALIDANDO SE USUARIO EXISTE
    #preg_match é usado para o usuario colocar somente os caracteres a baixo sem o spacebar
    if (!preg_match('/^[a-zA-Z0-9!@#$%^&*()-_+=]*$/', $senha)) {
        echo ("<script>window.alert('Por favor informe que contém caracteres especiais permitidos');</script>");
        echo ("<script>window.location.href='cadastroclientes.php';</script>"); 
    }
    else {
        $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_nome = '$nome' AND cli_senha = '$senha' AND cli_email = '$email'AND cli_ativo = 's'";
        $retorno = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($retorno))
        {
            $cont = $tbl[0];
        }
        #VERIFICAÇÃO SE USUARIO EXISTE, SE EXISTE = 1 SENÃO = 0
        if ($cont == 1)
        {
            echo "<script>window.alert('USUARIO JÁ CADASTRADO!';</script>)";
        }
        else
        {
            $tempero = md5(rand(). date('H:i:s'));
            $senha = md5($senha. $tempero);

            $sql = "INSERT INTO clientes (cli_nome, cli_senha,cli_ativo,cli_tempero,cli_email)
            VALUES ('$nome', '$senha', 's', '$tempero', '$email')";
            echo($sql);
            //ALTER TABLE usuarios
            // ADD usu_temepro VARCHAR(50);
            mysqli_query($link, $sql);
            echo "<script>window.alert('USUARIO CADASTRADO');</script>";
            echo "<script>window.location.href='loginusuario.php';</script>";
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
        <title>Cadastro Clientes</title>
    </head>
    <body>
        <div class="div-form">
            <form action="cadastroclientes.php" method="post">
                <!-- Required é usado para o usuario tentar passar em branco o cadastro e impedir o mesmo -->
                <h2>Cadastro de Clientes</h2> <!--Para qualquer atualização usar CTRL + F5-->
                <input type="text" name ="nome" id="nome" placeholder="Nome do Usuario" required><br>
                <input type="email" name ="email" id="nome" placeholder="Email do Usuario" required><br><!--type email é ultilizado para o usuario fazer cadastro e é obrigatoria colocar "@emailoficial"-->
                <input type="password" name ="senha" id="senha" placeholder="Senha" minlength="8" maxlength="32" required><br>
                <span id="MostrarSenha" onclick="MostrarSenha()">👀</span> <br><br>
                <button type="submit" name ="cadastrar" id="btn" >Cadastrar</button><br>
            </form>
        </div>
    </body>
</html>

<script>
    function MostrarSenha() {
        var passwordInput = document.getElementById("senha");
        var PasswordIcon = document.getElementById("MostrarSenha")
        if(passwordInput.type === "password"){
         passwordInput.type = "text";
         PasswordIcon.textContent = "❌"
        }
        else {
            passwordInput.type = "password";
            PasswordIcon.textContent = "👀";
        }
    }
</script>
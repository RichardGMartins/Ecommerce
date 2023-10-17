<?php 
#Inicia a conexão com o banco de dados

include("conectadb.php");
#Coleta de variáveis via formulário de HTML
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    #Trim é usado para tirar os espaços do começo e do fim do nome para armazenar sem spacebar
    $nome = trim($nome);
    #POSSANDO INSTRUÇÕES SQL PARA O BANCO
    #VALIDANDO SE USUARIO EXISTE
    #preg_match é usado para o usuario colocar somente os caracteres a baixo sem o spacebar
    if (!preg_match('/^[a-zA-Z0-9!@#$%^&*()-_+=]*$/', $senha)) {
        echo ("<script>window.alert('Por favor informe que contém caracteres especiais permitidos');</script>");
        echo ("<script>window.location.href='cadastrousuario.php';</script>"); 
    }
    else {
        $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome' AND usu_senha = '$senha' AND usu_ativo = 's'";
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
            $sql = "INSET INTO usuarios (usu_nome, usu_senha,usu_ativo)
            VALUES ('$nome', '$senha', 'n')";
            mysqli_query($link, $sql);
            echo "<script>window.alert('USUARIO CADASTRADO');</script>";
            echo "<script>window.location.href='cadastrausuario.php';</script>";
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
        <title>Cadastro Usuário</title>
    </head>
    <body>
        <div>
            <form action="cadastrousuario.php" method="post">
                <!-- Required é usado para o usuario tentar passar em branco o cadastro e impedir o mesmo -->
                <input type="text" name ="nome" id="nome" placeholder="Nome de Usuario" required><br>
                <input type="password" name ="senha" id="senha" placeholder="Senha" required><br>
                <input type="submit" name ="cadastrar" id="cadastrar" placeholder="Cadastrar"><br>
            </form>
        </div>
    </body>
</html>
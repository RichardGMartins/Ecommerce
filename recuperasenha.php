<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPmail/src/Exception.php';
require 'PHPmail/src/PHPMailer.php';
require 'PHPmail/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conectadb.php');
    $email = $_POST['email'];
    //verifica se o usuario é válido
    $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_email = '$email'";
    $result = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($result)) {
        $cont = $tbl[0];
    }
    if ($cont != 0) {
        $recupera = rand();
        $sql = "UPDATE clientes SET cli_recupera = '$recupera' WHERE cli_email = '$email' ";
        mysqli_query($link, $sql);

        $to = $email;
        $subject = "Recuperação de Senha";
        $message = "Esse e o seu codigo de recuperacao $recupera. 
        <br> Acesse<a href='http://localhost/ecommerce/redefinesenha.php'>aqui </a> para redefinir sua senha.";
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'contaparaaaulateste@outlook.com'; //mudar para seu email
            $mail->Password = '12345678a@'; ////mudar para senha do seu seu email
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('contaparaaaulateste@outlook.com', 'EMAIL REC'); //mudar para seu email
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            //    $mail->UT_8;
            $mail->Body = $message;
            $mail->send();
            echo 'Mensagem enviada';
        } catch (Exception $e) {
            echo "Não foi possível enviar a mensagem: {$mail->ErrorInfo}";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-bt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
</head>
<body>
   <div class="div-form">
    <h2>Redefinir Senha</h2>
    <form action="recuperarsenha.php" method="post">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <button type="submit" id="btn">Enviar</button>
    </form>
   </div> 
</body>
</html>
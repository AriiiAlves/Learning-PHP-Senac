<?php

$email = $_GET['email'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar-se no Saguadim</title>
    <link rel="stylesheet" href="../../../../styles/login.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../../../../public/photos/saguadim_logo.png">
            <p>
                A plataforma ideal para o gerenciamento da sua salgaderia.
            </p>
        </div>
        <div class="login">
            <div>
                <h3>Insira o código enviado por email</h3>
                <input type="number" name="codigo" id="codigo" min="0" placeholder="Código" required>
                <span id="error"></span>
                <button value="Entrar" onclick="submitForm()">Confirmar</button>
            </div>
            <span>
                Já possui uma conta? <a href="../login.html" class="toggle-form" id="toggleCadastra">Clique aqui</a>
            </span>
        </div>
    </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var codeInput = document.getElementById('codigo');
        // VMasker(codeInput).maskPattern('999999');
    });

    // Script AJAX que envia os dados de cadastro para o arquivo PHP, e o PHP retorna uma resposta
    function submitForm() {
        var codigo = document.getElementById('codigo').value;
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../functions/verify_code.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        // Callback a ser executado quando a resposta do servidor for recebida
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                console.log(typeof(xhr.responseText));
                var response = xhr.responseText;
                
                // Se a resposta for "0", mostra a mensagem de erro
                if(response === "0") {
                    document.getElementById('error').style.display = 'none';
                    document.getElementById('error').innerHTML = 'Código incorreto.';
                    document.getElementById('error').style.display = 'block';
                }
                // Se a resposta for "1", redireciona para a home
                else if (response === "1") {
                    document.getElementById('error').style.display = 'none';
                    window.location = `new_password.php?codigo=${codigo}&email=<?= $email ?>`;
                }
            }
        };
    
        // Converte os dados para a notação de URL
        var params = 'email=' + '<?= $email ?>' + '&codigo=' + codigo;
        
        xhr.send(params);
    }
</script>
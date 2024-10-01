<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/forms.css">
    <title>Revelar Fotos</title>
</head>
<body>

    <section>
        <h2>Revelar Fotos</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificando se todos os campos foram preenchidos
            if (isset($_POST['name']) && isset($_POST['telefone']) && isset($_POST['message']) && isset($_FILES['file'])) {
                // Obtendo os dados do formulário
                $nome = $_POST['name'];
                $telefone = $_POST['telefone'];
                $mensagem = $_POST['message'];
                $arquivo = $_FILES['file'];

                // Verificando a extensão do arquivo
                $extensaoArquivo = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                if ($extensaoArquivo == 'exe') {
                    die('Arquivos .exe não são permitidos.');
                }

                // Criando a pasta com o nome do cliente
                $pastaCliente = 'uploads/' . $nome;
                if (!is_dir($pastaCliente)) {
                    mkdir($pastaCliente, 0777, true); // Cria a pasta se não existir
                }

                // Movendo o arquivo para a pasta do cliente
                $caminhoArquivo = $pastaCliente . '/' . $arquivo['name'];
                if (move_uploaded_file($arquivo['tmp_name'], $caminhoArquivo)) {
                    echo 'Arquivo enviado com sucesso!<br>';
                } else {
                    die('Erro ao enviar o arquivo.');
                }

                // Criando um arquivo .txt com as informações do cliente
                $caminhoTxt = $pastaCliente . '/informacoes.txt';
                $conteudoTxt = "Nome: $nome\nTelefone: $telefone\nMensagem: $mensagem";
                file_put_contents($caminhoTxt, $conteudoTxt); // Salva o arquivo .txt

            } else {
                echo 'Por favor, preencha todos os campos corretamente.';
            }
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Nome</label>
            <input type="text" name="name" placeholder="Digite seu Nome" autocomplete="off" required>

            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" placeholder="(00)00000-0000" required pattern="[0-9]{10,11}">

            <label for="message">Mensagem</label>
            <textarea name="message" cols="30" rows="10" placeholder="Digite sua mensagem" required></textarea>

            <label for="file">Enviar Arquivo</label>
            <input type="file" name="file" required>

            <button type="submit">Enviar</button>
        </form>

    </section>
</body>
</html>

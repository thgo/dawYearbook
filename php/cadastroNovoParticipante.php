<?php
require_once("./conf/confBD.php");
include_once("../templates/header.php");

try {
    
    $origem = basename($_SERVER['HTTP_REFERER']);
    if ((count($_POST) != 9) && ($origem != 'cadastroParticipante.php')) {
        header("Location:./acessoNegado.php");
        die();
    }
    else {
    
        $conexao = conn_mysql();

        $nome = htmlspecialchars($_POST['nome']);
        $login = htmlspecialchars($_POST['usuario']);
        $cidade = htmlspecialchars($_POST['cidade']);
        $estado = htmlspecialchars($_POST['estado']);
        $email = htmlspecialchars($_POST['email']);
        $descricao = htmlspecialchars($_POST['descricao']);
        $senha = htmlspecialchars($_POST['passwd']);
        $senhaConf = htmlspecialchars($_POST['passwd2']);
        
        if (($senha != $senhaConf) || (strlen($senha) < 4) || (strlen($senha) > 8)) {
            header("Location:./erroCadastro.php");
            die();
        }

        // Tratar Upload
        $permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");  //extensoes validas
        $temp = explode(".", basename($_FILES["foto"]["name"]));
        $extensao = end($temp);
        $extensao = strtolower($extensao);
        
        if ((in_array($extensao, $permissoes) ) && (in_array($_FILES["foto"]["type"], $permissoes)) && ($_FILES["foto"]["size"] < $_POST["MAX_FILE_SIZE"])) {

            if ($_FILES["foto"]["error"] > 0) {
                echo "<h1>Erro no envio, código: " . $_FILES["foto"]["error"] . "</h1>";
            } else {
                $dirUploads = "../perfil/foto/";

                if (!file_exists($dirUploads))
                    mkdir($dirUploads, 0700);

                $pathCompleto = $dirUploads.basename($login.".".$extensao);
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $pathCompleto))
                    $foto = $pathCompleto;
                else {
                    $foto = "";
                    echo "<h1>Problemas ao armazenar o arquivo. Tente novamente.<h1>";
                }
            }
        } else {
            echo "<h1>Arquivo inválido<h1>";
        }

        $SQLInsert = 'INSERT INTO participantes (nomeCompleto, login, cidade, email, descricao, arquivoFoto, senha) 
                     VALUES (?,?,?,?,?,?,MD5(?))';

        $operacao = $conexao->prepare($SQLInsert);
        $inserir = $operacao->execute(array($nome, $login, $cidade, $email, $descricao, $foto, $senha));
        $conexao = null;

        if ($inserir) {
            echo "<h1>Cadastro efetuado com sucesso.</h1>\n";
            echo "<p class=\"lead\"><a href=\"index.php\">Página principal</a></p>\n";
        } else {
            echo "<h1>Erro na operação.</h1>\n";
            $arr = $operacao->errorInfo();
            $erro = $arr[2];
            echo "<p>$erro</p>";
            echo "<p><a href=\"./cadastroParticipante.php\">Retornar</a></p>\n";
        }
    }
} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("../templates/footer.html");
?>
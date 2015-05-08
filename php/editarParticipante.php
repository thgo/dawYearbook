<?php

require_once("./authSession.php");
require_once("./conf/confBD.php");

try {
    $conexao = conn_mysql();

    $nome = htmlspecialchars($_POST['nome']);
    $login = htmlspecialchars($_POST['usuario']);
    $cidade = htmlspecialchars($_POST['cidade']);
    $estado = htmlspecialchars($_POST['estado']);
    $email = htmlspecialchars($_POST['email']);
    $descricao = htmlspecialchars($_POST['descricao']);
    $foto = $_FILES["foto"]["name"];
    $senha = htmlspecialchars($_POST['passwd']);
    $senhaConf = htmlspecialchars($_POST['passwd2']);

    if (!empty($senha))
        if ($senha != $senhaConf) {
            header("Location:./erroEdicao.php");
            die();
        }

    if (!empty($foto)) {
        // Tratar Upload
        $permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");
        $temp = explode(".", basename($_FILES["foto"]["name"]));
        $extensao = end($temp);
        $extensao = srttolower($extensao);

        if ((in_array($extensao, $permissoes) ) && (in_array($_FILES["foto"]["type"], $permissoes)) && ($_FILES["foto"]["size"] < $_POST["MAX_FILE_SIZE"])) {

            if ($_FILES["foto"]["error"] > 0) {
                echo "<h1>Erro no envio, código: " . $_FILES["foto"]["error"] . "</h1>";
            } else {
                $dirUploads = "../perfil/foto/";

                if (!file_exists($dirUploads))
                    mkdir($dirUploads, 0700);

                $pathCompleto = $dirUploads . basename($login . "." . $extensao);

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
    }

    $SQLUpdate = "UPDATE participantes SET "
            . "nomeCompleto='$nome',"
            . "cidade=$cidade, "
            . "email='$email', "
            . "descricao='$descricao'";
    if ($foto)
        $SQLUpdate = $SQLUpdate . ", arquivoFoto='$foto'";
    if (!empty($senha))
        $SQLUpdate = $SQLUpdate . ", senha=MD5($senha)";

    $SQLUpdate = $SQLUpdate . " WHERE login='$login'";

    $operacao = $conexao->prepare($SQLUpdate);
    $atualizacao = $operacao->execute();
    $conexao = null;

    if ($atualizacao) {
        header("Location: ./principal.php");
    } else {
        echo "<h1>Erro na operação.</h1>\n";
        $arr = $operacao->errorInfo();
        echo "<p>$arr[2]</p>";
        echo "<p><a href=\"./principal.php\">Retornar</a></p>\n";
    }

} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
?>

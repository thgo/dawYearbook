<?php

require_once("./authSession.php");
require_once("./conf/confBD.php");

try {
    if (count($_GET) != 1) {
        header("Location:./erroExclusao.php");
        die();
    } else {
        $conexao = conn_mysql();
        $loginParticipante = htmlspecialchars($_GET['usuario']);

        $SQLDelete = 'DELETE FROM participantes WHERE login=?';
        $operacao = $conexao->prepare($SQLDelete);
        $apagar = $operacao->execute(array($loginParticipante));
        $conexao = null;

        if ($apagar) {
            header("Location: ./logout.php");
        } else {
            echo "<h1>Erro na operação.</h1>\n";
            $arr = $operacao->errorInfo();
            echo "<p>$arr[2]</p>";
            echo "<p><a href=\"./mainPage.php\">Retornar</a></p>\n";
        }
    }
} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
?>

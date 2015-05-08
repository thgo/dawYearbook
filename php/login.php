<?php

session_start();

require_once("./conf/confBD.php");

if (isset($_POST["login"])) {
    $log = htmlspecialchars($_POST["login"]);
    $senha = htmlspecialchars($_POST["passwd"]);
    if (isset($_POST["lembrarLogin"]))
        $lembrar = htmlspecialchars($_POST["lembrarLogin"]);
    else
        $lembrar = "";
}
elseif (isset($_COOKIE["loginAutomatico"])) {
    $log = htmlspecialchars($_COOKIE["loginYearbook"]);
    $senha = htmlspecialchars($_COOKIE["loginAutomatico"]);
} else {
    header("Location: ./erroLogin.php");
    die();
}
try {

    $conexao = conn_mysql();
    $SQLSelect = 'SELECT * FROM participantes WHERE senha=MD5(?) AND login=?';
    $operacao = $conexao->prepare($SQLSelect);
    $pesquisar = $operacao->execute(array($senha, $log));
    $resultados = $operacao->fetchAll();
    $conexao = null;

    if (count($resultados) != 1) {
        header("Location:./erroLogin.php");
        die();
    } else {
        setcookie("loginYearbook", $log, time() + 60 * 60 * 24 * 90); //guarda o login por 90 dias a partir de agora
        if (!empty($lembrar)) {
            setcookie("loginAutomatico", $senha, time() + 60 * 60 * 24 * 90); //guarda a senha por 90 dias a partir de agora	
        }
        $_SESSION['auth'] = true;
        $_SESSION['nomeCompleto'] = $resultados[0]['nomeCompleto'];
        $_SESSION['nomeUsuario'] = $log;
        header("Location: ./principal.php");
        die();
    }
} //try
catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
?>
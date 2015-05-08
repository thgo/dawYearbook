<?php

require_once("./conf/confBD.php");

try {
    $conexao = conn_mysql();
    $login = "";

    if (!empty($_SESSION['auth']))
        $login = $_SESSION['nomeUsuario'];
    
    $SQLSelect = "select p.login, p.arquivoFoto, p.nomeCompleto "
            . "from participantes p "
            . "where p.login <> :perfilLogado ";
    
    if (isset($_COOKIE["ultimosVisitados"])) {
        $ultimosVisitados = $_COOKIE["ultimosVisitados"];
        
        $SQLSelect = $SQLSelect. "and p.login in ($ultimosVisitados) "
                . "union "
                . "select p.login, p.arquivoFoto, p.nomeCompleto "
                . "from participantes p "
                . "where p.login <> :perfilLogado and p.login not in ($ultimosVisitados) "
                . "limit ". (11 - count($ultimosVisitados));
    } else 
        $SQLSelect = $SQLSelect."limit 10";

    $operacao = $conexao->prepare($SQLSelect);
    $operacao->bindParam("perfilLogado", $login);          
    $pesquisar = $operacao->execute();
    $resultados = $operacao->fetchAll();
    $conexao = null;

    echo "<div class=\"miniaturas\">";
    echo "<ul class=\"custom-ul\">";

    foreach ($resultados as $miniatura) {
        echo "<li class=\"custom-li\">";
        echo "<a href=\"participante.php?usuario=" . $miniatura['login'] . "\">";
        echo "<figure>";
        echo "<img src=\"" . $miniatura['arquivoFoto'] . "\" \" title=\"". $miniatura['nomeCompleto']. "\" />";
        echo "</figure>";
        echo "</a>";
        echo "</li>";
    }

    echo "</ul></div>";
    
} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
?>

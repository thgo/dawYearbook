<?php

require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("../templates/header.php");

$login = htmlspecialchars($_SESSION['nomeUsuario']);
try {
    $conexao = conn_mysql();

    $sql = "select p.nomeCompleto, c.nomeCidade, e.sigaEstado,
                   p.email, p.descricao, p.arquivoFoto, p.login from participantes p
                   join cidades c on c.idCidade = p.cidade
                   join estados e on e.idEstado = c.idEstado
                   where p.login = ?";

    $operacao = $conexao->prepare($sql);
    $pesquisar = $operacao->execute(array($login));
    $resultados = $operacao->fetchAll();

    $conexao = null;

    echo "<div class=\"container\">";
    
    if ($resultados)
        $item = $resultados[0];
    else {
        echo "<div class=\"well\">";
        echo "<h1>Nenhum participante encontrado!</h1>";
        echo "<p class=\"lead\">Retorne à tela de <a href=\"index.php\">login</a> e registre alguém.</p>";
        echo "</div>";
        die();
    }

    if ($resultados) {
        echo "<div class=\"well\">";
        
        echo "<div class=\"row\">";
        
        echo "<div class=\"col-xs-12 col-sm-12 col-md-5 col-lg-5 text-center\">";
        echo "<figure id=\"fotoPessoal\">";
        echo "<img src=\"" . $item['arquivoFoto'] . "\" alt=\"" . $item['nomeCompleto'] . "\"/>";
        echo "</figure>";        
        echo "</div>"; // div foto
        
        echo "<div class=\"col-xs-12 col-sm-12 col-md-7 col-lg-7\">";
        echo "<dl>";
        echo "<dt><h3>Nome:</h3></dt>";
        echo "<dd>" . $item['nomeCompleto'] . "</dd>";

        echo "<dt><h3>Cidade:</h3></dt>";
        echo "<dd>" . $item['nomeCidade'] . " - " . $item['sigaEstado'] . "</dd>";

        echo "<dt><h3>E-Mail:</h3></dt>";
        echo "<dd> <a href=\"mailto:" . $item['email'] . "\">" . $item['email'] . "</a></dd>";

        echo "<dt><h3>Descrição:</h3></dt>";
        echo "<dd><p>" . $item['descricao'] . "</p></dd></dl>";
        
        echo "</div>"; // div dados

        echo "<form role=\"form\" method=\"post\" action=\"./removerPerfil.php?usuario=" . $item['login'] . "\" "
        . "class=\"form-horizontal pull-right\" onsubmit=\"return confirm('Você realmente deseja remover seu perfil ?')\" >";

        echo "<p><button type=\"submit\" class=\"btn btn-danger btnExcluir\" style=\"margin-right: 1em\">Excluir</button></p></form>";
        
        echo "</div>"; // row
        echo "</div>"; // well
        
    }
    echo "</div>"; // container
} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
include_once("miniaturas.php");
include_once("../templates/footer.html");
?>
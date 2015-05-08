<?php

require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("../templates/header.php");
?>


<?php

$login = htmlspecialchars($_GET['usuario']);

try {
    $conexao = conn_mysql();
    $sql = "select p.nomeCompleto, c.nomeCidade, e.sigaEstado,
               p.email, p.descricao, p.arquivoFoto from participantes p
               join cidades c on c.idCidade = p.cidade
               join estados e on e.idEstado = c.idEstado
               where p.login = ?";
    $operacao = $conexao->prepare($sql);
    $pesquisar = $operacao->execute(array($login));
    $resultados = $operacao->fetchAll();

    $conexao = null;

    $item = $resultados[0];

    // Tratamento de últimos perfis visitados.
    if (isset($_COOKIE["ultimosVisitados"])) {
        $perfis = explode(",", $_COOKIE["ultimosVisitados"]);

        if (!in_array("\"" . $login . "\"", $perfis)) {
            $totalPerfis = count($perfis);
            if ($totalPerfis == 10)
                unset($perfis[0]);

            array_push($perfis, "\"" . $login . "\"");
            setcookie("ultimosVisitados", implode(",", $perfis));
        }
    } else
        setcookie("ultimosVisitados", "\"" . $login . "\"");

    echo "<div class=\"container\">";
    
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

        echo "</div>"; // row
        echo "</div>"; // well

    } else {
        echo "<h2>Perfil não encontrado.</h2>";
    }
    echo "</div>"; // container
} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
include_once("miniaturas.php");
include_once("../templates/footer.html");
?>
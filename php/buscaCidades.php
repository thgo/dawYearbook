<?php

require_once("./conf/confBD.php");

try {
    $conexao = conn_mysql();

    $idEstado = $_GET['idEstado'];

    $sql = "SELECT * FROM cidades WHERE idEstado = $idEstado ORDER BY nomeCidade";

    $operacao = $conexao->prepare($sql);
    $pesquisar = $operacao->execute();
    $resultados = $operacao->fetchAll();
    $conexao = null;

    if (count($resultados) < 1) {
        echo "Nenhuma cidade encontrada";
        die();
    } else {
        echo "<select id=\"cidade\" name=\"cidade\" class=\"form-control\" >";
        echo "<option value=\"-1\">Selecione uma cidade</option>";
        foreach ($resultados as $cidadesEncontradas) {
            echo "<option ";
            if (!empty($estadoUsuario))
                if ($estadoUsuario['idEstado'] == $cidadesEncontradas["idEstado"])
                    echo "selected ";
            echo "value=\"" . $cidadesEncontradas['idCidade'] . "\">" . $cidadesEncontradas['nomeCidade'];
            echo "</option>\n";
        }
        echo "</select>";
    }
} catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
?>
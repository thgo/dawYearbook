<?php
require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("../templates/header.php");
?>

<div class="container">
    <div>
        
        <?php
        try {
            $origem = basename($_SERVER['HTTP_REFERER']);
            if ((count($_POST) != 1) && ($origem != 'pesquisa.php')) {
                header("Location:./acessoNegado.php");
                die();
            } else {
                $conexao = conn_mysql();
                $nome = htmlspecialchars($_POST['nome']);
                
                $SQLSelect = "SELECT p.nomeCompleto, "
                        . "c.nomeCidade, "
                        . "e.sigaEstado, "
                        . "p.email, "
                        . "p.login, "
                        . "p.arquivoFoto, "
                        . "p.descricao "
                        . "FROM participantes p "
                        . "left join cidades c on c.idCidade = p.cidade "
                        . "left join estados e on e.idEstado = c.idEstado ";
                
                if (strlen($nome) > 0) {
                    $nome = "%" . $nome . "%";
                    $SQLSelect = $SQLSelect . "WHERE p.nomeCompleto like '$nome'";
                }
                
                $operacao = $conexao->prepare($SQLSelect);
                $pesquisar = $operacao->execute();
                $resultados = $operacao->fetchAll();
                $conexao = null;

                if (count($resultados) > 0) {
                    echo "<h3>Participantes encontrados:</h3><hr/>";
                    echo "<div class=\"row\">";
                                        
                    foreach($resultados as $pessoa){
                        echo "<div class=\"col-xs-12 col-sm-6 col-md-4 col-lg-4 \">";
                        echo "<div class=\"thumbnail\">";
                        echo "<img src=\"" . $pessoa['arquivoFoto'] . "\" alt=\"" . $pessoa['nomeCompleto'] . "\" class=\"fotoPesquisa\" />";
                        echo "<div class=\"caption text-center\">";
                        echo "<h5>" . $pessoa['nomeCompleto'] . "</h5>";
                        echo "<p class=\"text-muted\">" . $pessoa['email'] . "</p>";
                        
                        echo "<div class=\"row text-center\">";
                        echo "<a href=\"participante.php?usuario=". $pessoa['login'] . "\" class=\"btn btn-info\">Ver Perfil</a>";
                        
                        echo "</div></div></div></div>";
                    }
                    echo "</div>";
                } else {
                    echo"\n<h1>Não foram encontrados participantes com os dados fornecidos.</h1>";
                }                                               
                
                echo "<p class=\"lead\"><a href=\"./pesquisa.php\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-chevron-left\"></span> Nova pesquisa</a></p>";
            }
        } catch (PDOException $ex) {
            echo "Erro!: " . $e->getMessage() . "<br>";
            die();
        }
        ?>

    </div>
</div>

<?php
require_once("../templates/footer.html");
?>
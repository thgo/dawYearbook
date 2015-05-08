<?php
require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("../templates/header.php");
?>
<?php
try {

    $login = htmlspecialchars($_SESSION['nomeUsuario']);

    $conexao = conn_mysql();

    $SQLSelect = "select e.idEstado, "
                . "e.nomeEstado, "
                . "p.cidade, "
                . "c.nomeCidade, "
                . "p.login, "
                . "p.nomeCompleto, "
                . "p.arquivoFoto, "
                . "p.email, "
                . "p.descricao from participantes p "
            . "left join cidades c on c.idCidade = p.cidade "
            . "left join estados e on e.idEstado = c.idEstado "
            . "where p.login = ?";
    
    $operacao = $conexao->prepare($SQLSelect);
    $pesquisar = $operacao->execute(array($login));
    $resultados = $operacao->fetchAll();
    $participante = $resultados[0];
?>

    <div class="container">

        <div class="row">
            
            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 well">
            
                <div class="text-center">
                    <h3><strong>Yearbook<br/>Edição de Participante</strong></h3>
                </div>
            
                <form role="form" method="post" enctype="multipart/form-data" action="./editarParticipante.php" class="form-horizontal">

                    <input type="hidden" name="MAX_FILE_SIZE" value="500000" />

                    <div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">Nome:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" 
                                   autocomplete="off" required autofocus value="<?php echo $participante['nomeCompleto'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="usuario" class="col-sm-2 control-label">Usuário:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="usuario" name="usuario" 
                                   autocomplete="off" placeholder="Nome de usuário" required readonly value="<?php echo $participante['login'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="estado" class="col-sm-2 control-label">Estado:</label>
                        <div class="col-sm-10">
                            <!-- <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required> -->
                            <select id="estado" name="estado" class="form-control" onchange="CarregaCidades(this.value)" required>
                                <option value="">Selecione um estado</option>

                                <?php
                                $conexao = conn_mysql();

                                $sqlTodosEstados = "select * from estados order by nomeEstado";

                                $operacao = $conexao->prepare($sqlTodosEstados);
                                $pesquisar = $operacao->execute();
                                $estados = $operacao->fetchAll();

                                if (count($estados) < 1) {
                                    echo "Nenhum estado encontrado";
                                    die();
                                } else {
                                    foreach ($estados as $estadosEncontrados) {
                                        echo "<option ";
                                        if ($participante['idEstado'] == $estadosEncontrados["idEstado"])
                                            echo "selected ";
                                        echo "value=\"" . $estadosEncontrados['idEstado'] . "\">" . $estadosEncontrados['nomeEstado'];
                                        echo "</option>\n";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cidade" class="col-sm-2 control-label">Cidade:</label>
                        <div class="col-sm-10" id="cidadesAjax">
                            <?php
                            $conexao = conn_mysql();
                            $sql = "SELECT * FROM cidades WHERE idEstado = " . $participante['idEstado'] . " ORDER BY nomeCidade";
                            $operacao = $conexao->prepare($sql);
                            $pesquisar = $operacao->execute();
                            $cidadesRetornadas = $operacao->fetchAll();
                            $conexao = null;

                            if (count($cidadesRetornadas) < 1) {
                                echo "Nenhuma cidade encontrada";
                                die();
                            } else {
                                echo "<select id=\"cidade\" name=\"cidade\" class=\"form-control\" >";
                                echo "<option value=\"-1\">Selecione uma cidade</option>";
                                foreach ($cidadesRetornadas as $cidadesEncontradas) {
                                    echo "<option ";
                                    if (!empty($participante))
                                        if ($participante['cidade'] == $cidadesEncontradas["idCidade"])
                                            echo "selected ";
                                    echo "value=\"" . $cidadesEncontradas['idCidade'] . "\">" . $cidadesEncontradas['nomeCidade'];
                                    echo "</option>\n";
                                }
                                echo "</select>";
                            }
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">E-Mail:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" required
                                   value="<?php echo $participante['email'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="col-sm-2 control-label">Descrição:</label>
                        <div class="col-sm-10">
                            <textarea class="descricao" id="descricao" name="descricao" maxlength="200" required><?php echo trim($participante['descricao'])?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="foto" class="col-sm-2 control-label">Foto:</label>
                        <div class="col-sm-10">
                            <input type="file" name="foto" id="foto" placeholder="Escolha uma foto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="senha" class="col-sm-2 control-label">Nova Senha:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="senha" name="passwd" placeholder="Deixe em branco caso não queira alterar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm" class="col-sm-2 control-label">Confirme:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="confirm" name="passwd2" placeholder="Deixe em branco caso não queira alterar">
                        </div>
                    </div>
                    
                    <hr/>
                
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        <button type="button" class="btn btn-danger" onclick="javascript:window.location.href = './principal.php'">Cancelar</button>
                    </div>
                </form>
            
            </div> <!-- div col -->

        </div> <!-- row -->

    </div> <!-- container -->

    <?php
}
catch (PDOException $e) {
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("../templates/footer.html");
?>
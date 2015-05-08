<?php
include_once("../templates/header.php");
require_once("./conf/confBD.php");
?>

 <div class="container">
     
     <div class="row">
         <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1 well">
             <div class="text-center">
                 <h3><strong>Yearbook<br/>Cadastro de Usuário</strong></h3>
             </div>

            <form role="form" method="post" enctype="multipart/form-data" action="./cadastroNovoParticipante.php" class="form-horizontal">

                <input type="hidden" name="MAX_FILE_SIZE" value="500000" />

                <div class="form-group">
                    <label for="nome" class="col-sm-2 control-label">Nome:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome completo" autocomplete="off" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="usuario" class="col-sm-2 control-label">Usuário:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="usuario" name="usuario" autocomplete="off" placeholder="Nome de usuário" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="estado" class="col-sm-2 control-label">Estado:</label>
                    <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado" required> -->
                        <select id="estado" name="estado" class="form-control" onchange="CarregaCidades(this.value)">
                            <option value="-1">Selecione um estado</option>

                            <?php
                            try {
                                $conexao = conn_mysql();
                                $SQLSelect = "select * from estados order by nomeEstado";
                                $operacao = $conexao->prepare($SQLSelect);
                                $pesquisar = $operacao->execute();
                                $resultados = $operacao->fetchAll();
                                $conexao = null;

                                if (count($resultados) < 1) {
                                    echo "Nenhum estado encontrado";
                                    die();
                                } else {
                                    foreach ($resultados as $estadosEncontrados) {
                                        echo "<option ";
                                        echo "value=\"" . $estadosEncontrados['idEstado'] . "\">" . $estadosEncontrados['nomeEstado'];
                                        echo "</option>";
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "Erro!: " . $e->getMessage() . "<br>";
                                die();
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cidade" class="col-sm-2 control-label">Cidade:</label>
                    <div class="col-sm-10" id="cidadesAjax">
                        <select name="cidade" id="cidade" class="form-control">
                            <option value="-1">Selecione uma cidade</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">E-Mail:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descricao" class="col-sm-2 control-label">Descrição:</label>
                    <div class="col-sm-10">
                        <textarea class="descricao" id="descricao" name="descricao" maxlength="200" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="foto" class="col-sm-2 control-label">Foto:</label>
                    <div class="col-sm-10">
                        <input type="file" name="foto" id="foto" placeholder="Escolha uma foto" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="senha" class="col-sm-2 control-label">Senha:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="senha" name="passwd" placeholder="Senha" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm" class="col-sm-2 control-label">Confirme:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="confirm" name="passwd2" placeholder="Confirme a senha" required>
                    </div>
                </div>

                <hr/>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                    <button type="button" class="btn btn-danger" onclick="javascript:window.location.href = './index.php'">Cancelar</button>
                </div>
            </form>
             
        </div> <!-- div col -->

    </div> <!-- row -->

</div> <!-- container -->

<?php
include_once("../templates/footer.html");
?>
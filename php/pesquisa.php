<?php
require_once("./authSession.php");
require_once("./conf/confBD.php");
include_once("../templates/header.php");
?>

<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
        <h1 class="lead">Pesquisar participantes</h1>
        <form role="form" method="post" action="./pesquisaParticipantes.php">
            <div class="form-group">
                <label for="InputNome">Nome:</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                    <input type="text" class="form-control" id="InputNome" name="nome" placeholder="Informe um nome" autofocus >
                </div>
                
                
                <p class="small">Deixe em branco para listar todos.</p>
            </div>

            <button type="submit" class="btn btn-info">
                <span class="glyphicon glyphicon-search"></span> Pesquisar
            </button>
        </form>
    </div>
</div>

<?php
include_once("../templates/footer.html");
?>
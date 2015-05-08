<!DOCTYPE html>
<html lang="pt-BR">

    <head>    
        <title> YearBook </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../dist/css/normalize.css" />
        <link rel="stylesheet" href="../dist/css/main.css" />
        <link rel="stylesheet" href="../dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="../dist/css/font-awesome.min.css" />
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]--> 
        <script src="../dist/js/jquery-1.11.1.min.js"></script>
        <script src="../dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript">
            function CarregaCidades(idEstado) {
                if (idEstado) {
                    $.ajax({
                        url: "buscaCidades.php?idEstado=" + idEstado,
                        type: "get",
                        success: function(returnData) {
                            $("#cidadesAjax").html(returnData);
                        },
                        error: function(e) {
                            alert(e);
                        }
                    });
                }
            }
        </script>
    </head>
    
    <body>
        
        <header>
            <?php
                if(!empty($_SESSION['auth'])) {
                    echo "<nav class=\"navbar navbar-default\" role=\"navigation\">";
                        echo "<div class=\"container-fluid\">";
                            echo "<div class=\"navbar-header\">";
                                echo "<button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\"". 
                                    "data-target=\"#opcoes\">";
                                    echo "<span class=\"sr-only\">Navegação</span>";
                                    echo "<span class=\"icon-bar\"></span>";
                                    echo "<span class=\"icon-bar\"></span>";
                                    echo "<span class=\"icon-bar\"></span>";
                                echo "</button>";
                                echo "<a class=\"navbar-brand\" href=\"\">PUCMinas</a>";
                            echo "</div>";
                            echo "<div class=\"collapse navbar-collapse\" id=\"opcoes\">";
                                echo "<ul class=\"nav navbar-nav\">";
                                    echo "<li><a href=\"principal.php\">Página Inicial</a></li>";
                                    echo "<li><a href=\"editarDados.php\">Editar meus dados</a></li>";
                                    echo "<li><a href=\"pesquisa.php\">Pesquisar</a></li>";
                                    echo "<li><a href=\"logout.php\">Logout</a></li>";
                                echo "</ul>";
                                echo "<ul class=\"nav navbar-nav navbar-right\">";
                                    echo "<li><a href=\"http://www.pucminas.br/ensino/virtual/cursos.php?pagina=3510&tipo=2&curso=257\"
                               target=\"_blank\" class=\"hidden-xs\">Desenvolvimento de Aplicações Web</a></li>";
                                echo "</ul>";
                            echo "</div>";
                        echo "</div>";
                    echo "</nav>";
                } else {
                    echo "<div class=\"header-login\">";
                        echo "<h1> Turma 2014 </h1>";
                        echo "<div class=\"row text-center\"><p> Desenvolvimento de Aplicações Web <br> PUC Minas </p></div>";
                    echo "</div>";
                }
            ?>
        </header>

<?php 
    if (isset($_COOKIE[ 'loginAutomatico'])) {
        header( "Location: ./principal.php" );
    } else
        if (isset($_COOKIE[ 'loginYearbook']))
            $nomeUser=$_COOKIE[ 'loginYearbook' ];
        else
            $nomeUser="";
    include_once( "../templates/header.php" );
?>

<div class="container">
    
    <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 well well-lg text-center"
         style="box-shadow: 10px 10px 30px #CCC;">
        
        <div class="row">
            
            <h2>YearBook - Login</h2>
                
            <form class="form-horizontal" role="form" method="post" action="./login.php">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="input-group" style="margin-bottom: 1em">
                            <span class="input-group-addon"><span class="fa fa-user fa-2x"></span></span>
                            <input type="text" class="form-control input-login" placeholder="Login (usuario)" name="login" 
                                   id="user" autocomplete="off" required autofocus>
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-lock fa-2x"></span></span>
                            <input type="password" class="form-control input-login" placeholder="Senha (1234)" name="passwd" id="senha" required>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="checkbox">
                                    <label style="float: left">
                                        <input type="checkbox" name="lembrarLogin" value="loginAutomatico">Lembrar
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <button class="btn btn-lg btn-success btn-block" type="button" 
                                        onclick="javascript:window.location.href = './cadastroParticipante.php'">Faça parte</button>
                            </div>
                        
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

<?php 
include_once( "./miniaturas.php"); 
include_once( "../templates/footer.html"); 
?>
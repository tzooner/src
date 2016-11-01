<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php echo ConfigGeneral::APPLICATION_NAME; ?></title>

        <?php
        /**
         *
         *
         * By: Tomas Smekal
         * Company: Memos s.r.o.
         * Date: 3.8.2015
         */

        use \lib\helper as Helper;

        /**
         * Nacitani CSS
         */
        Helper\HTML::loadCSS("bootstrap.min");
        Helper\HTML::loadCSS("bootstrap-theme.min");
        Helper\HTML::loadCSS("main");
        Helper\HTML::loadCSS("bootstrap-datetimepicker");

        /**
         * Nacitani JavaScript
         */
        Helper\HTML::loadJS("jquery-1.11.3.min");
        Helper\HTML::loadJS("bootstrap.min");
        Helper\HTML::loadJS("moment");
        Helper\HTML::loadJS("moment-with-locales");
        Helper\HTML::loadJS("bootstrap-datetimepicker");
        Helper\HTML::loadJS("ajax");
        Helper\HTML::loadJS("main");
        Helper\HTML::loadJS("events");

        ?>

    </head>
    <body>

        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">SolarMonitor</a>
                </div>

                <?php if($Authorization->isLoggedIn()) { ?>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Přehled elektráren<span class="sr-only">(current)</span></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                        if(\lib\Authorization::isUserAdmin()):
                        ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Nastavení <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=users"><span class="glyphicon glyphicon-user"></span> Uživatelé</a></li>
                            </ul>
                        </li>
                        <?php
                        endif;
                        ?>
                        <li><a href="?action=logout">Odhlásit se</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->

                <?php
                } // isLoggedIn()
                else{
                ?>

                    <form method="post" action="" class="form-inline navbar-form navbar-left">
                        <div class="form-group">
                            <label for="txtUsername"></label>
                            <input type="text" class="form-control input-sm" name="txtUsername" id="txtUsername" placeholder="Uživatelské jméno">
                        </div>
                        <div class="form-group">
                            <label for="txtPassword"></label>
                            <input type="password" class="form-control input-sm" name="txtPassword" id="txtPassword" placeholder="Heslo">
                        </div>
                        <button type="submit" class="btn btn-default btn-sm" name="btnLogin">Přihlásit se</button>
                    </form>

                <?php
                } // neni prihlaseni
                ?>

            </div><!-- /.container-fluid -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $Messages->getMessagesHTML(false, true); ?>
                </div>
            </div>







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
        Helper\HTML::loadJS("main");
        Helper\HTML::loadJS("events");

        ?>

    </head>
    <body>

        <?php
            if($Authorization->isLoggedIn()) {
                ?>

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

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="index.php">Přehled <span class="sr-only">(current)</span></a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-haspopup="true" aria-expanded="false">Nastavení <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                    </ul>
                                </li>
                                <li><a href="?action=logout">Odhlásit se</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>

        <?php
        }
        ?>

        <div class="container">







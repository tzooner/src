<?php
/**
 * Created by PhpStorm.
 * User: tomas
 * Date: 04.04.2016
 * Time: 20:59
 */

if(isset($_POST["btnLogin"])){

    $username = \lib\helper\URL::getParameter("txtUsername", "post");
    $password = \lib\helper\URL::getParameter("txtPassword", "post");

    if($Authorization->loginUser($username, $password)){

        \lib\helper\URL::redirect("home");

    }
    else{

        echo 'fail';

    }

}

?>

<div class="row mt120">

    <div class="col-lg-2 col-lg-offset-5 col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">

        <form method="post" action="" class="form-group">
            <div class="form-group">
                <label for="txtUsername">Uživatelské jméno</label>
                <input type="text" class="form-control input-lg" name="txtUsername" id="txtUsername" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="txtPassword">Heslo</label>
                <input type="password" class="form-control input-lg" name="txtPassword" id="txtPassword" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-default btn-lg" name="btnLogin">Přihlásit se</button>
        </form>

    </div>

</div>

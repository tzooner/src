<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 25.10.2016
 */

$Users = new \lib\source\Users($WebService);
$table = \lib\source\UsersHTML::printTable($Users->GetAllUser());

?>
<div class="row">

    <div class="col-lg-4 col-md-4 col-sm-6 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">

        <h3>Seznam uživatelů</h3>

    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 text-right">

        <a href='index.php?page=user_new'><span class='glyphicon glyphicon glyphicon-plus-sign text-success' title='Přidat uživatele' style='font-size: 30px'></span></a>

    </div>

</div>
<div class="row">

    <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">

        <?php
        echo $table;
        ?>

    </div>

</div>
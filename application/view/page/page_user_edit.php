<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 25.10.2016
 */

use \lib\helper\Security;
use \lib\helper\General;
use \lib\helper\URL;

$User = new \lib\source\Users($WebService);
$Roles = new \lib\source\Roles($WebService);

$UserID = Security::secureGetPost("id", "get");
$IsEdit = (Security::secureGetPost("page", "get") == \lib\ConstantsPages::URL_USERS_EDIT && intval($UserID) > 0);

$form_username = "";
$form_password = "";
$form_email = "";
$form_role = "";

(Security::secureGetPost("msg", "get") == "ok" ? $Messages->addMessageSuccess("Uloženo") : "");


if(isset($_POST["save"])){

    unset($_POST["save"]);

    $saveResponse = $User->Save($UserID, $_POST);

    if(!is_array($saveResponse) && intval($saveResponse) > 0){
        if($IsEdit){
            $Messages->addMessageSuccess("Informace o uživateli byly uloženy");
        }
        else{
            URL::redirect(\lib\ConstantsPages::URL_USERS_EDIT, "", array("id" => $saveResponse, "msg" => "ok"));
        }

    }
    else{   // Nepodarilo se ulozit

        $form_username = Security::secureGetPost("Username", "post");
        $form_password = Security::secureGetPost("Password", "post");
        $form_email = Security::secureGetPost("Email", "post");
        $form_role = Security::secureGetPost("RoleID_FK", "post");

        foreach ($saveResponse as $row) {

            $msg = (is_array($row) ? $row[0] : $row);
            $Messages->addMessageError($msg);

        }

    }

}

if($IsEdit){

    $data = $User->GetUser($UserID);

    $form_username = General::isSetOrEmpty($data["Username"]);
    $form_email = General::isSetOrEmpty($data["Email"]);
    $form_role = General::isSetOrEmpty($data["RoleID"]);

}

?>


<form method="post" class="validate-form" autocomplete="off" data-is-edit="<?php echo ($IsEdit ? "1" : "0"); ?>">

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <?php echo $Messages->getMessagesHTML(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">

            <div class="panel panel-primary">

                <div class="panel-heading">
                    Informace o uživateli
                </div>
                <div class="panel-body" style="height: 340px;">

                    <div class="form-group">
                        <label for="Username">Uživatelské jméno</label>
                        <input type="text" class="form-control validate-required" id="Username" name="Username" maxlength="20" value="<?php echo $form_username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Password">Heslo <?php echo ($IsEdit ? "<span class='glyphicon glyphicon-question-sign text-info' title='Nevyplněné heslo = při uložení je heslo bezezměny'></span>" : ""); ?></label>
                        <input type="password" class="form-control validate-required validate-required-new" id="Password" name="Password" maxlength="100" value="<?php echo $form_password; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Email">E-mail</label>
                        <input type="text" class="form-control validate-required" id="Email" name="Email" maxlength="100" value="<?php echo $form_email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Email">Role</label>
                        <?php echo \lib\source\UsersHTML::printRoleCombo($Roles->getAllRoles(), $form_role); ?>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="row">
        <div class="<?php echo ($IsEdit ? "col-lg-12" : "col-lg-8 col-lg-offset-2"); ?>">
            <button type="submit" name="save" class="btn btn-success pull-right">Uložit</button>
        </div>
    </div>

</form>

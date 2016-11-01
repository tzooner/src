<?php

use \lib\helper\Security;
use \lib\source\Powerplant;
use \lib\helper\General;
use \lib\helper\URL;

$PowerPlantID = Security::secureGetPost("id", "get");
// Priznak jestli se jedna o editaci existujici elektrarny nebo o nove vytvarenou elektrarnu
$IsEdit = (Security::secureGetPost("page", "get") == \lib\ConstantsPages::URL_POWERPLANT_EDIT && intval($PowerPlantID) > 0);

$from_PowerPlantName = "";
$from_Users = "";
$from_City = "";
$from_Street = "";
$from_ZIP = "";
$from_LocationLatitude = "";
$from_LocationLongitude = "";
$from_Description = "";

$Users = new \lib\source\Users($WebService);
$Settings = new \lib\source\Settings($WebService);
$Powerplant = new Powerplant($WebService);

(Security::secureGetPost("msg", "get") == "ok" ? $Messages->addMessageSuccess("Uloženo") : "");


if(isset($_POST["save"])){

    $columnsDefinition = @$_POST['ColumnDefinitions'];

    unset($_POST["save"]);
    unset($_POST["ColumnDefinitions"]);

    $saveResponse = $Powerplant->SavePowerPlant($PowerPlantID, $_POST);

    if(!is_array($saveResponse) && intval($saveResponse) > 0){
        if($IsEdit){

            $resultDefinition = $Settings->saveColumnsDefinition($columnsDefinition);
            if($resultDefinition){
                $Messages->addMessageSuccess("Definice sloupců byla uložena");
            }
            else{
                $Messages->addMessageError("Nepodařilo se uložit definici sloupců");
            }

            $Messages->addMessageSuccess("Informace o elektrárně byly uloženy");
        }
        else{
            URL::redirect(\lib\ConstantsPages::URL_POWERPLANT, "", array("id" => $saveResponse, "msg" => "ok"));
        }

    }
    else{   // Nepodarilo se ulozit

        $from_PowerPlantName = Security::secureGetPost("PowerPlantName", "post");
        $from_Users = Security::secureGetPost("UserID_FK", "post");
        $from_City = Security::secureGetPost("City", "post");
        $from_Street = Security::secureGetPost("Street", "post");
        $from_ZIP = Security::secureGetPost("ZIP", "post");
        $from_LocationLatitude = Security::secureGetPost("LocationLatitude", "post");
        $from_LocationLongitude = Security::secureGetPost("LocationLongitude", "post");
        $from_Description = Security::secureGetPost("Description", "post");

        foreach ($saveResponse as $row) {

            $msg = (is_array($row) ? $row[0] : $row);
            $Messages->addMessageError($msg);

        }

    }

}

if($IsEdit){

    $data = $Powerplant->GetPowerPlantData($PowerPlantID);

    $from_PowerPlantName = General::isSetOrEmpty($data["PowerPlantName"]);
    $from_Users =General::isSetOrEmpty($data["Users"]);
    $from_City = General::isSetOrEmpty($data["City"]);
    $from_Street = General::isSetOrEmpty($data["Street"]);
    $from_ZIP = General::isSetOrEmpty($data["ZIP"]);
    $from_LocationLatitude = General::isSetOrEmpty($data["LocationLatitude"]);
    $from_LocationLongitude = General::isSetOrEmpty($data["LocationLongitude"]);
    $from_Description = General::isSetOrEmpty($data["Description"]);

}

?>

<form method="post" class="validate-form">

    <div class="row">
        <div class="col-lg-12">
            <?php echo $Messages->getMessagesHTML(); ?>
        </div>
    </div>

    <?php
    if($IsEdit){
        echo '<div class="col-lg-4">';
    }
    else{
        echo '<div class="col-lg-8 col-lg-offset-2">';
    }
    ?>

        <div class="panel panel-primary">

            <div class="panel-heading">
                Informace o elektrárně
            </div>
            <div class="panel-body" style="height: 640px;">

                <div class="form-group">
                    <label for="PowerPlantName">Jméno elektrárny</label>
                    <input type="text" class="form-control validate-required" id="PowerPlantName" name="PowerPlantName" maxlength="50" value="<?php echo $from_PowerPlantName; ?>">
                </div>
                <div class="form-group">
                    <label for="UserID_FK">Uživatel k elektrárně</label>
                    <?php echo \lib\source\UsersHTML::printUsersCombo($Users->GetAllUser(), $from_Users); ?>
                </div>
                <div class="form-group">
                    <label for="City">Město</label>
                    <input type="text" class="form-control validate-required" id="City" name="City" maxlength="100" value="<?php echo $from_City; ?>">
                </div>
                <div class="form-group">
                    <label for="Street">Ulice</label>
                    <input type="text" class="form-control validate-required" id="Street" name="Street" maxlength="100" value="<?php echo $from_Street; ?>">
                </div>
                <div class="form-group">
                    <label for="ZIP">PSČ</label>
                    <input type="text" class="form-control validate-required" id="ZIP" name="ZIP" maxlength="5" value="<?php echo $from_ZIP; ?>">
                </div>
                <div class="form-group">
                    <label for="LocationLatitude">Zeměpisná délka</label>
                    <input type="text" class="form-control" id="LocationLatitude" name="LocationLatitude" maxlength="19" value="<?php echo $from_LocationLatitude; ?>">
                </div>
                <div class="form-group">
                    <label for="LocationLongitude">Zeměpisná. šířka</label>
                    <input type="text" class="form-control" id="LocationLongitude" name="LocationLongitude" maxlength="19" value="<?php echo $from_LocationLongitude; ?>">
                </div>
                <div class="form-group">
                    <label for="Desciption">Poznámka</label>
                    <textarea class="form-control" id="Desciption" name="Description"><?php echo $from_Description; ?></textarea>
                </div>

            </div>

        </div>

    </div>

    <?php
    if($IsEdit):
    ?>

    <div class="col-lg-8">

        <div class="panel panel-primary">

            <div class="panel-heading">
                Nastavení přiřazení naměřených dat
            </div>
            <div class="panel-body" style="height: 640px; overflow-y: auto;">

                <?php
                    echo \lib\source\SettingsHTML::printTable($Settings->getAvailableColumns($PowerPlantID), $PowerPlantID);
                ?>

            </div>

        </div>

    </div>

    <?php
    endif;
    ?>

    <div class="row">
        <div class="<?php echo ($IsEdit ? "col-lg-12" : "col-lg-8 col-lg-offset-2"); ?>">
            <button type="submit" name="save" class="btn btn-success pull-right">Uložit</button>
        </div>
    </div>

</form>



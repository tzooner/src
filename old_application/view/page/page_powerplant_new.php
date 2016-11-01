<?php
/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 17.10.2016
 */

if(isset($_POST["save"])){

}

?>

<div class="col-lg-6 col-lg-offset-3">

    <div class="panel panel-primary">

        <div class="panel-heading">
            Založit novou elektrárnu
        </div>
        <div class="panel-body">
            <form method="post">
                <div class="form-group">
                    <label for="PowerPlantName">Jméno elektrárny</label>
                    <input type="text" class="form-control" id="PowerPlantName" name="PowerPlantName">
                </div>
                <div class="form-group">
                    <label for="City">Město</label>
                    <input type="text" class="form-control" id="City" name="City">
                </div>
                <div class="form-group">
                    <label for="Street">Ulice</label>
                    <input type="text" class="form-control" id="Street" name="Street">
                </div>
                <div class="form-group">
                    <label for="ZIP">PSČ</label>
                    <input type="text" class="form-control" id="ZIP" name="ZIP">
                </div>
                <div class="form-group">
                    <label for="LocationLatitude">Zem. délka</label>
                    <input type="text" class="form-control" id="LocationLatitude" name="LocationLatitude">
                </div>
                <div class="form-group">
                    <label for="LocationLongitude">Zem. šířka</label>
                    <input type="text" class="form-control" id="LocationLongitude" name="LocationLongitude">
                </div>
                <div class="form-group">
                    <label for="Desciption">Poznámka</label>
                    <textarea class="form-control" id="Desciption" name="Desciption"></textarea>
                </div>
                <button type="submit" class="btn btn-success pull-right">Uložit</button>
            </form>
        </div>

    </div>

</div>



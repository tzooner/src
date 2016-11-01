/**
 * Created by tomas on 01.11.2016.
 */
function handleResult(jsonData, $element){

    try{

        var jsonEncode = jQuery.parseJSON(jsonData);

        if (jsonEncode.STATE === "success") {

            $element.fadeOut(150);

        }
        else {

            $element.addClass('danger');
            alert(jsonEncode.MESSAGE);

        }

    }
    catch(Exception){

        $element.addClass('danger');
        alert('Odstraňování selhalo');

    }

}

function deleteUser(userID, $element){

    $.ajax({
        url: "view/ajax/deleteUser.php",
        type: "get",
        async: false,
        cache: false,
        data: {userID: userID},
        success: function(data){

            handleResult(data, $element);

        },
        error:function(){

            $selector.addClass('danger');
            alert('Nepodařilo se připojit k serveru');

        }
    });

}

function deletePowerplant(powerplantID, $element){

    $.ajax({
        url: "view/ajax/deletePowerplant.php",
        type: "get",
        async: false,
        cache: false,
        data: {powerplantID: powerplantID},
        success: function(data){

            handleResult(data, $element);

        },
        error:function(){

            $selector.addClass('danger');
            alert('Nepodařilo se připojit k serveru');

        }
    });

}

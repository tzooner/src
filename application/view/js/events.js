/**
 *
 *
 * By: Tomas Smekal
 * Company: Memos s.r.o.
 * Date: 13.10.2016
 */
$(document).ready(function(){

    var $BODY = $("body");

    $BODY.on("click", ".btn-set-date", function () {

        var dateFrom = $(this).data("date-from");
        var dateTo = $(this).data("date-to");

        $("#dateFrom").val(dateFrom);
        $("#dateTo").val(dateTo);

    });

    $BODY.on("submit", "#frmSetGraph", function (event) {

        var values = $("#cmbColumn").val();

        if(values == undefined || values.length == 0){

            alert("Musíte vybrat alespoň jednu hodnotu pro zobrazení v grafu");
            event.preventDefault();
            return false;

        }

    });

    /**
     * Validace kazdeho formulare s tridou validate-form
     */
    $BODY.on("submit", "form.validate-form", function (event) {

        var isFormEdit = $(this).attr("data-is-edit");

        var $form = $(this);

        var invalidFormsId = [];
        var validFormsId = [];

        // Projdou se vsechny formulare oznacene jako povinne
        $form.find(".validate-required").each(function(){

            // Pokud se jedna o editaci a formular ma tridu 'validate-required-new', tak se validace neprovadi
            // napr. heslo se pri editaci nevyplnuje, pokud chce uzivatel, aby se nezmenilo
            if(!$(this).hasClass("validate-required-new") || !isFormEdit){

                var val = $(this).val();
                var type = $(this).prop('nodeName');

                var isEmpty = false;
                // Podle type formulare se urci, ktery je prazdny
                switch (type.toUpperCase()) {
                    case "INPUT":
                        isEmpty = (!val || val.length == 0);
                        break;
                    case "SELECT":
                        isEmpty = (!val || val == "0");
                        break;
                }

                var elementId = $(this).attr("id");
                if (isEmpty) {
                    invalidFormsId.push(elementId);
                }
                else {
                    validFormsId.push(elementId);
                }

            }

        });

        // U validnich formularu se odeberou pripadne zvyrazneni
        if(validFormsId.length > 0){

           for(var i = 0; i < validFormsId.length; i++){
               $("#" + validFormsId[i]).parent().removeClass("has-error").addClass("has-success");
            }

        }

        // U nevalidnich formularu se prida zvyrazneni pro chyby
        if(invalidFormsId.length > 0){

            for(var j = 0; j < invalidFormsId.length; j++){
                $("#" + invalidFormsId[j]).parent().removeClass("has-success").addClass("has-error");
            }

            alert("Vyplňte zvýrazněná pole");
            event.preventDefault();

        }

    });

    $BODY.on("click", ".remove-item", function(){

        if(confirm("Opravdu chcete odstranit tuto položku?")){

            var id = $(this).attr("data-id");
            var type = $(this).attr("data-type");
            var $selector = $(this).parent().parent("tr");

            switch(type){
                case "user":
                    deleteUser(id, $selector);
                    break;
                case "powerplant":
                    deletePowerplant(id, $selector);
                    break;
            }

        }

    });

});
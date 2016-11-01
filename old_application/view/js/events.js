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

});
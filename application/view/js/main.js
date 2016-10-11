/**
 * Created by tomas on 09.10.2016.
 */
$(document).ready(function(){

    $(function () {

        var optionsFrom = {
            locale: 'cs',
            sideBySide: true
        };

        var optionsTo = optionsFrom;
        optionsTo.useCurrent = false;//Important! See issue #1075

        var $dateFrom = $('.datepicker-from');
        var $dateTo = $('.datepicker-to');

        $dateFrom.datetimepicker(optionsFrom);
        $dateTo.datetimepicker(optionsTo);

        $dateFrom.on("dp.change", function (e) {
            $dateTo.data("DateTimePicker").minDate(e.date);
        });
        $dateTo.on("dp.change", function (e) {
            $dateFrom.data("DateTimePicker").maxDate(e.date);
        });

    });

});
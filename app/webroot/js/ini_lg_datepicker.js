$('.datepicker').glDatePicker({
    zIndex: 999999,
    onClick: function (target, cell, date, data) {
        target.val(date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());

        if (data != null) {
            alert(data.message + '\n' + date);
        }
    }
});
$('.datepicker').glDatePicker({
    zIndex: 100,
    onClick: function (target, cell, date, data) {
        target.val(date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());

        if (data != null) {
            alert(data.message + '\n' + date);
        }
    }
});
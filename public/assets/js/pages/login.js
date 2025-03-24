$(document).ready(function(){
    $('input[name="phone"]').inputmask({
        mask: "+99 999 999 99 99",
        greedy: false,
        placeholder: "_",
        showMaskOnHover: false,
        showMaskOnFocus: true,
        onBeforePaste: function (pastedValue, opts) {
            return pastedValue.replace(/\D/g, '');
        }
    });
});
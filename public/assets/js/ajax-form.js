function show_message(title, message, status = 'info') {
    toastr[status](title, message);
}

$(document).ready(function () {
    $('form.ajax-form').on('submit', function (event) {
        event.preventDefault();

        var url = $(this).attr('data-action');
        var _this = this;

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.status == true) {
                    if (response.clear !== false) {
                        $(_this).trigger("reset");
                    }

                    show_message('İşlem Başarılı!', response.message, 'success');

                    if (response.reload == true) {
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else if (typeof response.reload == 'string' || response.reload instanceof String) {
                        setTimeout(function () {
                            window.location = response.reload;
                        }, 2000);
                    }
                } else {
                    show_message('Hata!', response.message, 'error');
                }
            },
            error: function (response) {
                show_message('Hata!', 'Yanıt alınamadı', 'error');
            }
        });
    });
});
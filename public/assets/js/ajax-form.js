function show_message(title, message, status = 'info') {
    toastr[status](title, message);
}

$(document).ready(function () {
    $('form.ajax-form').on('submit', function (event) {
        event.preventDefault();

        var url = $(this).attr('data-action');
        var _this = this;
        var formData = new FormData(this);

        $(this).find('input[type="checkbox"]').each(function() {
            formData.set($(this).attr('name'), $(this).is(':checked') ? 1 : 0);
        });

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.status == true) {
                    if (response.clear !== false) {
                        $(_this).trigger("reset");
                    }

                    let title = null;
                    if(response.title)
                        title = response.title;

                    show_message(title, response.message, 'success');

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
                    show_message('Error!', response.message, 'error');
                }
            },
            error: function (response) {
                show_message('Error!', 'No response received', 'error');
            }
        });
    });
});

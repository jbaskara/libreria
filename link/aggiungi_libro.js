$(document).ready(function () {
    $("#aggiungi-libro-form").submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '/aggiungi_libro.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                let alertClass = response.success ? 'alert-success' : 'alert-danger';

                let alertBox = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                    response.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>').hide(); 

                $('#alert-container').html(alertBox);
                alertBox.fadeIn("slow"); 

                setTimeout(function () {
                    alertBox.fadeOut("slow", function () {
                        $(this).remove();
                    });
                }, 5000);

                if (response.success) {
                    $("#aggiungi-libro-form")[0].reset();
                }
            },
            error: function () {
                let alertBox = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    'Errore nella comunicazione con il server.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>').hide();

                $('#alert-container').html(alertBox);
                alertBox.fadeIn("slow");

                setTimeout(function () {
                    alertBox.fadeOut("slow", function () {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    });
});
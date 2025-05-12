$(document).ready(function() {
    $('#form-contatto').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'link/salva_messaggio.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                let alertClass = response.status === 'success' ? 'alert-success' : 'alert-danger';
                let html = '<div class="alert ' + alertClass + ' alert-dismissible show" role="alert">' +
                           response.message +
                           '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                           '</div>';

                $('#messaggio-risposta').hide().html(html).show();

                if (response.status === 'success') {
                    $('#form-contatto')[0].reset();
                }

                setTimeout(function() {
                    $('#messaggio-risposta .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            },
            error: function() {
                let html = '<div class="alert alert-danger alert-dismissible show" role="alert">' +
                           'Errore durante l\'invio del messaggio.' +
                           '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                           '</div>';
                $('#messaggio-risposta').hide().html(html).show();

                setTimeout(function() {
                    $('#messaggio-risposta .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    });
});
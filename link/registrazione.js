$(document).ready(function() {

    var urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('error')) {
        var errorMessage = urlParams.get('error');

        switch (errorMessage) {
            case 'compilare_tutti_i_campi':
                $('#message').addClass('alert-danger').text('Compila tutti i campi!');
                break;
            case 'email_gia_registrata':
                $('#message').addClass('alert-danger').text('Questa email è già registrata!');
                break;
            case 'errore_nella_registrazione':
                $('#message').addClass('alert-danger').text('Errore nella registrazione, riprova!');
                break;
            case 'errore_query':
                $('#message').addClass('alert-danger').text('Errore nel database, riprova!');
                break;
            default:
                break;
        }
        $('#message').show();
    } 
    
    if (urlParams.has('successo')) {
        var successMessage = urlParams.get('successo');

        if (successMessage === 'registrazione_completata') {
            $('#message').addClass('alert-success').text('Registrazione avvenuta con successo!');
            $('#message').show();
        }
    }
});
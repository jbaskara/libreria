$(document).ready(function(){
    $('.visualizza-btn').click(function(){
        let id = $(this).data('id');
        $('#dettagli-' + id).slideToggle();
        $(this).toggleClass('btn-primary btn-secondary');
        $(this).text(function(i, text){
            return text === "Visualizza" ? "Nascondi" : "Visualizza";
        });
    });
});
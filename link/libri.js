$(document).ready(function () {
  $("#filtroCard").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    var visibili = 0;
    $(".libro").filter(function () {
      var titolo = $(this).find('.card-title').text().toLowerCase().indexOf(value) > -1;
      $(this).closest('.col').toggle(titolo);
      if (titolo) visibili++;
    });
    $('#contatore').text(`${visibili} libri trovati`);
  });

  $(".card").on("click", function () {
    $(".card").removeClass("selected");
    $(this).addClass("selected");
  });

  $('.card').on('mouseenter', '.fa-star', function () {
    const val = $(this).data('val');
    $(this).siblings().removeClass('checked');
    $(this).addClass('checked').prevAll().addClass('checked');
  });

  $('.card').on('click', '.fa-star', function () {
    const voto = $(this).data('val');
    const container = $(this).closest('.star-rating');
    container.find('input[name="voto"]').val(voto);
    container.find('.fa-star').removeClass('selected');
    $(this).addClass('selected').prevAll().addClass('selected');
  });

  $('form[action="link/invia_recensione.php"]').on('submit', function (e) {
    e.preventDefault();
    const form = $(this);
    const data = form.serialize();
  
    $.post(form.attr('action'), data, function (res) {
      if (res.status === 'success') {
        const successAlert = $("<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>Recensione pubblicata con successo!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
        form.after(successAlert);
        form[0].reset();
        form.find('.fa-star').removeClass('checked selected');
  
        setTimeout(() => successAlert.fadeOut(300, function () { $(this).remove(); }), 3000);
      } else {
        const errorAlert = $("<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>Errore: " + res.message + "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>");
        form.after(errorAlert);
      }
    }, 'json');
  });  

  $('.noleggia').click(function () {
    const bottone = $(this);
    const idLibro = bottone.data('id');

    $.ajax({
      url: 'link/noleggia_libro.php',
      method: 'POST',
      data: { id_libro: idLibro },
      success: function (response) {
        if (response === 'success') {
          bottone.prop('disabled', true).text('Noleggiato');
          bottone.siblings('.noleggio-confermato').removeClass('d-none');
        } else {
          alert("Errore: " + response);
        }
      }
    });
  });

  $(window).on("load", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const idLibro = urlParams.get('id');
    if (idLibro) {
      const dettagli = document.getElementById('dettagli' + idLibro);
      const card = $('#libro' + idLibro);
      if (dettagli && card.length) {
        new bootstrap.Collapse(dettagli, { toggle: true });
        $(".card").removeClass("selected");
        card.addClass("selected");
        $('html, body').animate({
          scrollTop: card.offset().top - 80
        }, 600);
      }
    }
  });
});

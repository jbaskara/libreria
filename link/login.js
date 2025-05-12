$(document).ready(function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('errore') === '1') {
    $('#message').addClass('alert-danger').text('Email o password errati. Riprova.');
    $('#message').show();
  }
});

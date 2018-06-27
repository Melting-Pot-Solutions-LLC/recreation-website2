document.getElementById('feedback-form').addEventListener('submit', function(evt){
  var http = new XMLHttpRequest(), f = this;
  evt.preventDefault();
  http.open("POST", "./assets/mail.php", true);
  http.onreadystatechange = function() {
    if (http.readyState == 4 && http.status == 200) {
      alert(http.responseText);
      if (http.responseText.indexOf(f.nameFF.value) == 0) { 
        f.messageFF.removeAttribute('value');
        f.messageFF.value='';
      }
          
        // Clear the form.
        $('#contact-form input,#contact-form textarea').val('');
        $('#contact-form .price').val('Your price will appear here');
        $('#contact-form .quote-btn').val('Instant A Quote');
        $("#contact-form .service-options [value='no-service']").attr("selected", "selected");
    }
  }
  http.onerror = function() {
    alert('Oops! An error occured and your message could not be sent.');
  }
  http.send(new FormData(f));
}, false);
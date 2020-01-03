(function(){


  document.form_login.addEventListener('submit', function(ev){
    if(ev) ev.preventDefault();

    $.ajax({
      url: 'db/login.php',
      type: 'POST',
      dataType: 'json',
      data: $(this).serialize(),
      beforeSend: ()=>{
        Swal.fire({
          title: 'Cargando', 
          onOpen: ()=>{
            Swal.showLoading();
          },
          allowOutsideClick: false,
          allowEscapeKey: false
        });
      }
    })
    .done(function(response) {
      if( response.status === 1 ){
        
        let timerInterval;
        Swal.fire({
          text: response.msg,
          timer: 2000,
          icon: 'success',
          onBeforeOpen: () => {
            Swal.showLoading();
          },
          onClose: () => {
            clearInterval(timerInterval);
          }
        }).then((result) => {
          window.location.reload();
        });

      }
      else{
        Swal.fire("Inválido", response.msg, 'error');
      }
    })
    .fail(function() {
      Swal.fire("Error de Red", 'La red no esta disponible en este momento', 'error');
    });
    

  });


})();
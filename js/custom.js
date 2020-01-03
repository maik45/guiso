
    $("#agregarmenu").click(function(){
    $("#contenedor").load('menu.php');
    });
    $("#eliminarmenu").click(function(){
    $("#contenedor").load('eliminarmenu.php');
    });
    $("#modificarmenu").click(function(){
    $("#contenedor").load('modificarmenu.php');
    });
    // $("#generarexp").click(function(){
    // $("#contenedor").load('generarexplosion.php');
    // });
    // $("#generarexpplinea").click(function(){
    // $("#contenedor").load('generarexplosionporlinea.php');
    // });
    // $("#generarexppproveedor").click(function(){
    // $("#contenedor").load('generarexplosionporproveedor.php');
    // });
    $("#hojasdeproduccion").click(function(){
    $("#contenedor").load('hojasdeproduccion.php');
    });
    $("#hojasdeproduccionporunidad").click(function(){
    $("#contenedor").load('hojasdeproduccionporunidad.php');
    });
    $("#consultarmenu").click(function(){
    $("#contenedor").load('consultarmenu.php');
    });
    $("#imprimirmenu").click(function(){
    $("#contenedor").load('imprimirmenu.php');
    });
    $("#copiarmenu").click(function(){
    $("#contenedor").load('copiarmenu.php');
    });
    $("#generaciondeoc").click(function(){
    $("#contenedor").load('generaciondeoc.php');
    });
    $("#generaciondeocgeneral").click(function(){
    $("#contenedor").load('generaciondeocgeneral.php');
    });
    $("#generaciondereportedecomprasporunidad").click(function(){
    $("#contenedor").load('generaciondereportedecomprasporunidad.php');
    });
    $("#crearlistadeexedentes").click(function(){
    $("#contenedor").load('crearlistadeexedentes.php');
    });
    $("#creararchivodeexelparalistadeexedentes").click(function(){
    $("#contenedor").load('creararchivodeexelparalistadeexedentes.php');
    });
    $("#cargarlistadeexedentes").click(function(){
    $("#contenedor").load('cargarlistadeexedentes.php');
    });
    $("#modifcarfacturasatravesdeoc").click(function(){
    $("#contenedor").load('modifcarfacturasatravesdeoc.php');
    });
    $("#modifcarfacturasatravesdeocmanuales").click(function(){
    $("#contenedor").load('modifcarfacturasatravesdeocmanuales.php');
    });

//class ajaxLink a la ruta
(function(){

  $('.sidebar').on('click', '.ajaxLink', function(ev){
    ev.preventDefault();
    //recuperamos el href
    var path = this.getAttribute('href');
    $('#contenedor').load( path );

  });


  //poner en español datatable
  $.extend( true, $.fn.dataTable.defaults, {
    language: {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
        }
    }
  });


})();

var loadView = function( path ){
  $('#contenedor').load( path );
};

//var ps = new PerfectScrollbar(document.querySelector('.sidebar'));
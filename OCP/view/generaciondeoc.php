<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Creación de Orden de Compra con Presentación</h3>
  </div>
</div> -->


<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white text-center">
        Creación de Orden de Compra con Presentación
      </div>
      
      <div class="panel-body text-blue">

        <form action="#" method="post" name="form_excedente" id="form_excedente">
            

            <div class="row">

                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label for="orden">Orden de Compra *</label>
                        <input name="orden" id="orden" class="form-control input-sm" required readonly placeholder="Orden de Compra" />
                    </div>
                </div> -->
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="cliente">Cliente *</label>
                        <select name="cliente" id="cliente" class="form-control input-sm" required>
                            <option value="">Seleccione un cliente</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                
                <div class="col-xs-12">
                  Seleccione el rango de fechas para la orden de compra *
                  <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control" name="start" id="start" placeholder="Fecha Inicial" readonly />
                    <span class="input-group-addon"> hasta </span>
                    <input type="text" class="form-control" name="end" id="end" placeholder="Fecha Final" readonly />
                  </div>

                  <!-- <div id="datepicker"></div>
                  <input type="hidden" id="my_hidden_input"> -->

                </div>

            </div>

            <div class="row my-1">
                
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i> Orden de Compra Con Presentación</button>
                </div>

            </div>
          
        </form>

        <div class="row">
            
            <!-- <div class="col-xs-12">
                <div class="alert alert-warning">
                    Este reporte sólo acepta hasta 5 unidades por cliente, de lo contrario las demás unidades serán excluídas del reporte.
                </div>
            </div> -->

            <div class="col-xs-12">
              <div class="alert alert-info">
                Este reporte recolecta los artículos de los menus que cada cliente ha adquirido en el periodo solicitado.
              </div>
            </div>

        </div>
    

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

(function(){

  let _ = document;
  let $$ = _.querySelector.bind(_);

  let form_excedente = _.form_excedente;

  var stockArticulos, stockClientes;

  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: 'es',
    autoclose: true,
    // endDate: '0d',
  });

  var init = ()=>{

    // $.post('OC/php/Compra.php', {method: 'getOrden'}, function(data, textStatus, xhr) {
    //   form_excedente.orden.value = data;
    // });

    $.ajax({
      url: 'explosion/php/explosion.php',
      type: 'POST',
      dataType: 'json',
      data: {method: 'getClienteUnidad'},
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
    .done((response)=> {

      stockClientes = response;

      var doc = _.createDocumentFragment();
      for( let item of response ){
        let option = _.createElement('option');
        option.value = item.idCliente;
        option.textContent = item.nombre;
        doc.appendChild( option );
      }
      form_excedente.cliente.appendChild( doc );

      Swal.close();
    })
    .fail((a, b, c)=> {
        console.log(a, b, c);
    });




  };

  init();//agrega clientes al formulario


  form_excedente.addEventListener('submit', function(ev){
    if(ev) ev.preventDefault();

    if( this.start.value === '' || this.end.value === '' ){
      Swal.fire('Las fechas son requeridas', '','info');
      return;
    }

    Swal.fire({
        title: 'Orden de Compra',
        text: `¿Desea crear la orden de compra con presentación de ${this.cliente.options[this.cliente.selectedIndex].text}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, crear'
      }).then((result) => {
        if (result.value) {
          
          let data = $(this).serializeArray();
          data.push({name: 'method', value: 'crearOC'});

          $.ajax({
            url: 'OC/php/Compra.php',
            type: 'POST',
            dataType: 'json',
            data,
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
          .done((response)=> {
            console.log(response);
            if(response.status === 1){
              Swal.fire('Exito', response.msg, 'success');
              // generarOrden( this.cliente.value, this.start.value, this.end.value );
              data.push({name: 'orden', value: response.orden});
              generarOrden( data );
              this.reset();
            }
            else{
                Swal.fire('Error', response.msg, 'error');
            }
          })
          .fail((a, b, c)=> {
            Swal.fire('Error', 'La red no esta disponible, intente mas tarde', 'error');
            console.log(a, b, c);
          });

        }//endIf

      });

    

  });



  var generarOrden = data =>{

    let form = _.createElement('form');
    form.target = '_blank';
    form.action = 'OCP/generaOrden.php';
    form.method = 'post';
    form.style.display = 'none';

    let input;
    for(let item of data){
      input = _.createElement('input');
      input.type = 'text';
      input.name = item.name;
      input.value = item.value;
      form.appendChild(input); 
    }

    _.body.appendChild(form);
    form.submit();
    form.parentNode.removeChild(form);

  }


})();
  

</script>
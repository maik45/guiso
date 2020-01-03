<form role="form">

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <p class="help-block">*Fecha inicial</p>
          <div id="calendar">
            <div id="calendar_header"><i class="icon-chevron-left"></i>          <h1></h1><i class="icon-chevron-right"></i>         </div>
            <div id="calendar_weekdays"></div>
            <div id="calendar_content"></div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <p class="help-block">*Fecha final</p>
            <div id="calendar2">
            <div id="calendar_header2"><i class="icon-chevron-left"></i>          <h1></h1><i class="icon-chevron-right"></i>         </div>
            <div id="calendar_weekdays2"></div>
            <div id="calendar_content2"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <p class="help-block" style="font-size: x-small;">Este reporte genera la orden de compra con presentación para todas las unidades de todos los clientes. Se genera una hoja por proveedor. Sólo genera información para órdenes de compra previamente creadas, es decir, si no existe una O.C. previamente creada para la fecha indicada no generará información. Tomará como válido todas aquellas O.C. que su fecha de creación sea mayor o igual a la fecha seleccionada y su fecha de término sea menor igual a la fecha final. Esto es, si existe un O.C. donde su fecha de inicio este dentro del rango seleccionado pero su fecha final este fuera del rango seleccionado, esta O.C. no será considerada dentro del reporte.</p>
            </div>
        </div>
    </div>
    
    <script src="../js/calendar.js"></script>
    <script src="../js/calendar2.js"></script>
</form>
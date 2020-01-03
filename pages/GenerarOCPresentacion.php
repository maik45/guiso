<form role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>* Id orden</label>
                <input class="form-control" name="idorden" required="true" autofocus="true">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>* Cliente</label>
                <select class="form-control" name="cliente" required="true">
                    <option></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
        </div>
    </div>
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
    
    <script src="../js/calendar.js"></script>
    <script src="../js/calendar2.js"></script>
</form>
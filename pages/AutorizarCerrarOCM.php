<?php
    session_start();
?>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr id="mi_thead">
            </tr>
        </thead>
        <tbody id="mi_tbody">
        </tbody>
    </table>
</div>
<!-- /.table-responsive -->

<script type="text/javascript" src="./pages/personal_js/select.js"></script>
<script type="text/javascript">
    function construirTabla()
    {
        var json_obj_ocm = null;

        iJoinTabla1 = {
            table_name : "cliente",
            index_field : [
            "nombre"
            ],
            key : "ocm.cliente",
            foreing_key : "cliente.idCliente"
        };

        iJoinTabla2 = {
            table_name : "usuario",
            index_field : [
            "usuario"
            ],
            key : "usuario.idUser",
            foreing_key : "ocm.usuario"
        };

        iJoinTabla3 = {
            table_name : "ocm",
            index_field : [
            "idOC",
            "fechaI",
            "fechaF",
            "status"
            ]
        };

        iJoinTablas = {
            arg1 : {},
            arg3 : {}
        };

        iJoinTablas.arg3 = iJoinTabla1;
        iJoinTablas.arg1 = iJoinTabla3;

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "", "vec2" );
        json_obj_ocm = _json_response_;
        _json_response_ = null;

        $("#mi_thead").append( "<td>Clave</td>" );
        $("#mi_thead").append( "<td>Cliente</td>" );
        $("#mi_thead").append( "<td>Apertura - Cierre</td>" );
        $("#mi_thead").append( "<td>Elaboró</td>" );
        $("#mi_thead").append( "<td>Estado</td>" );

        for ( var i = 0; i < json_obj_ocm.length; i++ )
        {
            $("#mi_tbody").append("<tr></tr>");
            $("#mi_tbody > tr:last-child").append("<td>" + json_obj_ocm[ i ][ 4 ] + "</td>");
            $("#mi_tbody > tr:last-child").append("<td>" + json_obj_ocm[ i ][ 0 ] + "</td>");
            $("#mi_tbody > tr:last-child").append("<td>" + json_obj_ocm[ i ][ 1 ].substring( 0, json_obj_ocm[ i ][ 1 ].indexOf(" ") ) + " - " + json_obj_ocm[ i ][ 2 ].substring(0, json_obj_ocm[ i ][ 2 ].indexOf(" ") ) + "</td>");
            $("#mi_tbody > tr:last-child").append("<td>" + json_obj_ocm[ i ][ 5 ] + "</td>");
            $("#mi_tbody > tr:last-child").append("<td>" + json_obj_ocm[ i ][ 3 ] + "</td>");
        }
    }

    construirTabla();
</script>
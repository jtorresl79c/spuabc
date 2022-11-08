<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPUABC - Usuarios</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <br />
    <br />
    <div align="right">
        <form action="{{ route('login') }}">
            <input type="submit" value="Regresar" class="btn btn-success btn-sm"/>
        </form>
    </div>
    <br />

    <h3 align="center">Administración de Pedidos</h3>
    <br />

    <div align="right">
        <form action="{{ route('actualizar') }}">
            <input type="submit" value="Actualizar" class="btn btn-warning btn-sm"/>
        </form>
    </div>

    <br />
    <div class="table-responsive">
        <table id="user_table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="5%"></th>
                <th width="23%">Nombre de Solicitante</th>
                <th width="10%">Almacen</th>
                <th width="10%">Fecha</th>
                <th width="10%">Hr. Inicial</th>
                <th width="10%">Hr. Final</th>
                <th width="10%">Estado</th>
                <th width="22%">Opción</th>
            </tr>
            </thead>
        </table>
    </div>
    <br />
    <br />
</div>
</body>
</html>

<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambio de estado de solicitud</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="GET" id="sample_form"  class="form-horizontal" >
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4">Estado : </label>
                        <div class="col-md-4">
                            <select class="form-control " id="inlineFormCustomSelectPref" name="Estado">
                                <option selected>Pendiente</option>
                                <option>Rechazado</option>
                                <option>Entregado</option>
                                <option>En uso</option>
                            </select>
                        </div>
                    </div>
                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ProductoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Productos solicitados en este pedido</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table border='1' id="Tabla" class="table table-bordered table-striped">
       <thead>
        <tr>
          <th width="10%">Matricula</th>
          <th width="50%">Nombre</th>
          <th width="20%">Almacen</th>
          <th width="20%">Cantidad</th>
        </tr>
       </thead>
     </table>
     <div class="form-group" align="center">
     <input type="submit" name="action_button" id="action_button" class="btn btn-danger" value="GENERAR REPORTE" />
     <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Modificar" />
                </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var divClone = $("#Tabla").clone();

        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('Ped.Pedido.index') }}",
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'Solicitante',
                    name: 'Solicitante'
                },
                {
                    data: 'Almacen',
                    name: 'Almacen'
                },
                {
                    data: 'Fecha',
                    name: 'Fecha'
                },
                {
                    data: 'Inicial',
                    name: 'Inicial'
                },
                {
                    data: 'Final',
                    name: 'Final'
                },
                {
                    data: 'Estado',
                    name: 'Estado'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
            ],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ Al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 Al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#sample_form').on('submit', function(event){
            event.preventDefault();
            var action_url = '';
            var type ='';

                var Id = $('#hidden_id').val();
                action_url = "Pedido/" + Id;
                type = 'PUT';

            $.ajax({
                url: action_url,
                data:$(this).serialize(),
                dataType:"json",
                type: type,
                success:function(data)
                {
                    var html = '';
                    if(data.errors)
                    {
                        html = '<div class="alert alert-danger">';
                        for(var count = 0; count < data.errors.length; count++)
                        {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if(data.success)
                    {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#sample_form')[0].reset();
                        $('#user_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
        });

        $(document).on('click', '.producto', function () {
            var id = $(this).attr('id');
            $.ajax({
                type: 'GET',
                url: '/prodc',
                dataType: "json",
                data:{id:id},
                success: function (data) {
            var len = data.result.length;
            $("#Tabla").replaceWith(divClone.clone());
            for(var i=0; i<len; i++){

                var tr_str = "<tr>" +
                    "<td align='center'>" + data.result[i].Matricula + "</td>" +
                    "<td align='center'>" + data.result[i].name + "</td>" +
                    "<td align='center'>" + data.result[i].almacen + "</td>" +
                    "<td align='center'>" + data.result[i].cantidad + "</td>" +
                    "</tr>";

                $("#Tabla").append(tr_str);
                }
                $('#ProductoModal').modal('show');
                }
            })
        });


        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                type: 'GET',
                url: "Pedido/" + id + "/edit",
                dataType: "json",
                success: function (data) {
                    $('#hidden_id').val(id);
                    $('#action_button').val('Editar');
                    $('#formModal').modal('show');
                }
            })
        });

    });
</script>

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
                <input type="submit" value="Regresar" class="btn btn-success btn-sm" />
            </form>
        </div>
        <span id="form_result"></span>
        <br />

        <h3 align="center">Solicitar productos para prestamo</h3>
        <br />
        <div align="right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Crear
                solicitud</button>
        </div>
        <br />
        <div class="table-responsive">
            <table id="user_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="20%">Matricula</th>
                        <th width="40%">Nombre</th>
                        <th width="30%">Almacen</th>
                        <th width="10%">¿Solicitar?</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br />
        <br />
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Confirmación de operación</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Esta a punto de solicitar los siguientes productos,<br>
                        Es posible que algunos de ellos requieran una cantidad a especificar.</h4>

                    <table border='1' id="Tabla" class="table table-sm">
                        <thead>
                            <tr>
                                <th width="3%">Id</th>
                                <th width="7%">Matricula</th>
                                <th width="50%">Nombre</th>
                                <th width="10%">Almacen</th>
                                <th width="30%">Cantidad</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-warning">Solicitar
                        Productos</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    $(document).ready(function() {
        var table;
        var divClone = $("#Tabla").clone();
        table = $('#user_table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('Us.Usuario.index') }}",
            },
            type: "POST",
            dataType: 'json',
            columns: [{
                    data: 'Matricula'
                },
                {
                    data: 'name'
                },
                {
                    data: 'almacen',
                },
                {
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
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
            },
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var id = [];
        var cant = [];
        $('#create_record').click(function() {
            id = [];
            var cant = [];
            $('.Producto:checked').each(function() {
                id.push($(this).val());
            });

            $.ajax({
                type: 'GET',
                url: '/conf', // Cuando presionas el boton de "Crear Solicitud" manda un request al controller confirm.php
                dataType: "json",
                data: {
                    id: id
                },
                success: function(data) {
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                        $('#form_result').html(html);
                    } else {
                        var len = data.result.length;
                        $("#Tabla").replaceWith(divClone.clone());
                        for (var i = 0; i < len; i++) {

                            var tr_str = "<tr>" +
                                "<td align='center'>" + data.result[i].id + "</td>" +
                                "<td align='center'>" + data.result[i].Matricula + "</td>" +
                                "<td align='center'>" + data.result[i].name + "</td>" +
                                "<td align='center'>" + data.result[i].almacen + "</td>" +
                                "<td class='col-sm-1'><input class='form-control' type='number' value='1'></td>" +
                                "</tr>";

                            $("#Tabla").append(tr_str);
                        }
                        $('#confirmModal').modal('show');
                    }
                }
            })
        });

        $('#ok_button').click(function() { // Cuando preesionas 'Solicitar Productos' en el modal de confirmacion

            var table = document.getElementById('Tabla');
            for (var r = 1, n = table.rows.length; r < n; r++) {
                cant[r - 1] = table.rows[r].cells[4].children[0].value;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('Us.Usuario.store') }}",
                dataType: 'json',
                data: {
                    id: id,
                    cant: cant
                },

                success: function(data) {
                    // console.log(data)
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success +
                        '</div>';
                        $('#user_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                    $('#confirmModal').modal('hide');
                    id = [];
                    cant = [];
                }
            });
        });

    });
</script>

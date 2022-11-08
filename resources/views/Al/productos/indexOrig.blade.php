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
        <br />

        <h3 align="center">Administración de Productos</h3>
        <br />
        <div align="right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Agregar
                Producto</button>
        </div>
        <br />
        <div class="table-responsive">
            <table id="user_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="10%">Matricula</th>
                        <th width="20%">Nombre</th>
                        <th width="10%">Almacen</th>
                        <th width="10%">Cantidad</th>
                        <th width="10%">Disponible</th>
                        <th width="10%">Permiso</th>
                        <th width="20%">Accion</th>

                    </tr>
                </thead>
            </table>
        </div>
        <h5 class="modal-title">M = Solo Maestros, MA = Maestros y Alumnos</h5>
        <br />
        <br />
    </div>
</body>

</html>

<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Record</h4>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="POST" id="sample_form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4">Nombre del Producto : </label>
                        <div class="col-md-8">
                            <input type="text" name="Nombre" id="Nombre" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Matricula del Producto : </label>
                        <div class="col-md-8">
                            <input type="text" name="Matricula" id="Matricula" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Tipo de producto : </label>
                        <div class="col-md-8">
                            <select class="form-control" name="tipo">
                                <option selected value="Unico">Unico </option>
                                <option value="Consumible">Consumible </option>
                                <option value="Kit">Kit </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Cantidad disponibles : </label>
                        <div class="col-md-8">
                            <input default="1" onchange="yesnoCheck(this);" type='number' name="cantidad" id="cantidad"
                                class="form-control" min="1" />
                        </div>
                    </div>

                    <div class="form-check" id="ifYes">
                        <label class="control-label col-md-4">¿Multiples Matriculas?</label>
                        <input class="form-check-input" type="checkbox" value="mult" id="CU" name="CU">
                    </div>
                    </br>

                    <div class="form-group">
                        <label class="control-label col-md-4">Puede solicitarlo : </label>
                        <div class="col-md-8">
                            <select class="form-control" id="inlineFormCustomSelectPref" name="permiso">
                                <option selected value="MA">Maestros y Alumnos </option>
                                <option value="M">Solo Maestros </option>
                            </select>
                        </div>
                    </div>
                    @can('AccesoAdmin')
                        <div class="form-group">
                            <label class="control-label col-md-4">Almacen : </label>
                            <div class="col-md-8">
                                <select class="form-control" id="inlineFormCustomSelectPref" name="almacen">
                                    <option selected>Selecciona...</option>
                                    @foreach ($Alm as $Al)
                                        <option value={{ $Al->Matricula }}>{{ $Al->Matricula }} ( {{ $Al->name }} )
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endcan
                    <div class="form-group" id="detalles">
                        <label class="control-label col-md-4">Detalles : </label>
                        <div class="col-md-8">
                            <textarea class="form-control" aria-label="With textarea" id="detalles" name="detalles"></textarea>
                        </div>
                    </div>

                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                            value="Add" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmación de operación</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Estas a punto de eliminar este Producto, ¿Estas seguro?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Eliminar Producto</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function yesnoCheck(that) {
        if (that.value > 1) {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }

    $(document).ready(function() {

        $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('Al.productos.index') }}",
            },
            columns: [{
                    data: 'Matricula',
                    name: 'Matricula'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'almacen',
                    name: 'almacen'
                },
                {
                    data: 'cantidad',
                    name: 'cantidad'
                },
                {
                    data: 'disponible',
                    name: 'disponible'
                },
                {
                    data: 'permiso',
                    name: 'permiso'
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

        $('#create_record').click(function() {
            $('.modal-title').text('Agregar Producto');
            $('#action_button').val('Agregar');
            $('#action').val('Add');
            $('#form_result').html('');

            $('#formModal').modal('show');
        });

        $('#sample_form').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            var type = '';

            if ($('#action').val() == 'Add') {
                action_url = "{{ route('Al.productos.store') }}";
                type = 'POST';
            }

            if ($('#action').val() == 'Edit') {
                var Id = $('#hidden_id').val();
                action_url = "productos/" + Id;
                type = 'PUT';
            }

            $.ajax({
                url: action_url,
                data: $(this).serialize(),
                dataType: "json",
                type: type,
                success: function(data) {
                    console.log(data)
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
                        $('#sample_form')[0].reset();
                        $('#user_table').DataTable().ajax.reload();
                    }
                    $('#form_result').html(html);
                }
            });
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                type: 'GET',
                url: "productos/" + id + "/edit",
                dataType: "json",
                success: function(data) {
                    $('#Nombre').val(data.result.name);
                    $('#Matricula').val(data.result.Matricula);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Modificar Producto');
                    $('#action_button').val('Editar');
                    $('#action').val('Edit');
                    $('#formModal').modal('show');
                }
            })
        });

        var user_id;
        var alma;

        $(document).on('click', '.delete', function() {
            user_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                type: 'DELETE',
                url: "productos/" + user_id,
                dataType: "json",
                data: {
                    "id": user_id,
                    "almacen": alma,
                },

                beforeSend: function() {
                    $('#ok_button').text('Eliminando...');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#ok_button').text('Eliminar Producto');
                        $('#confirmModal').modal('hide');
                        $('#user_table').DataTable().ajax.reload();
                        alert('Producto Eliminado');
                    }, 2000);
                }

            })
        });

    });
</script>

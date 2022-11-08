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
    <h3 align="center">Administración de usuarios</h3>
    <div class="table-responsive">
        <table id="user_table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="4%">Matricula</th>
                <th width="10%">Nombre</th>
                <th width="15%">A. Paterno</th>
                <th width="15%">A. Materno</th>
                <th width="20%">Correo</th>
                <th width="15%">Nivel</th>
                <th width="15%">Opción</th>
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
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Record</h4>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="POST" id="sample_form" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4" >Nombre : </label>
                        <div class="col-md-8">
                            <input type="text" name="Nombre" id="Nombre" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4" >A. Paterno : </label>
                        <div class="col-md-8">
                            <input type="text" name="apellidoP" id="apellidoP" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4" >A. Materno : </label>
                        <div class="col-md-8">
                            <input type="text" name="apellidoM" id="apellidoM" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4" >Matricula : </label>
                        <div class="col-md-8">
                            <input type="text" name="Matricula" id="Matricula" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Nivel : </label>
                        <div class="col-md-8">
                            <input type="radio" onchange="yesnoCheck(this);" name="Nivel" id="role1" class="form-check-input" value="Administrador"/>Administrador<br>
                            <input type="radio" onchange="yesnoCheck(this);" name="Nivel" id="role2" class="form-check-input" value="Almacenista"/>Almacenista<br>
                            <input type="radio" onchange="yesnoCheck(this);" name="Nivel" id="role3" class="form-check-input" value="Maestro"/>Maestro<br>
                            <input type="radio" onchange="yesnoCheck(this);" name="Nivel" id="role4" class="form-check-input" value="Usuario"/>Usuario<br>
                        </div>
                    </div>

                    <div class="form-group" id="ifYes">
                        <label class="control-label col-md-4">Almacen : </label>
                        <div class="col-md-8">
                            <select class="form-control" id="inlineFormCustomSelectPref" name="almacen">
                                <option selected>Selecciona...</option>
                                @foreach ($Alm as $Al)
                                <option value={{$Al->Matricula}}>{{$Al->Matricula}} ( {{$Al->name}} )</option>
                                @endforeach
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

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmación de operación</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Estas a punto de eliminar este usuario, ¿Estas seguro?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Eliminar Usuario</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>

function yesnoCheck(that) {
    if (that.value == 'Almacenista') {
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
                url: "{{ route('admin.users.index') }}",
            },
            columns: [
                {
                    data: 'Matricula',
                    name: 'Matricula'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'apellidoP',
                    name: 'apellidoP'
                },
                {
                    data: 'apellidoM',
                    name: 'apellidoM'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
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

            if($('#action').val() == 'Edit')
            {
                var Id = $('#hidden_id').val();
                action_url = "users/" + Id;
            }

            $.ajax({
                url: action_url,
                method:"PUT",
                data:$(this).serialize(),
                dataType:"json",
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

        $(document).on('click', '.edit', function () {
            var id = $(this).attr('id');
            $('#form_result').html('');
            $.ajax({
                type: 'GET',
                url: "users/" + id + "/edit",
                dataType: "json",
                success: function (data) {
                    $('#Nombre').val(data.result.name);
                    $('#role').val(data.result.role);
                    $('#apellidoP').val(data.result.apellidoP);
                    $('#apellidoM').val(data.result.apellidoM);
                    $('#Matricula').val(data.result.Matricula);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Modificar Usuario');
                    $('#action_button').val('Editar');
                    $('#action').val('Edit');
                    $('#formModal').modal('show');
                }
            })
        });

        var user_id;

            $(document).on('click', '.delete', function () {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function () {
                $.ajax({
                    type: 'DELETE',
                    url: "users/" + user_id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": user_id
                    },

                    beforeSend: function () {
                        $('#ok_button').text('Eliminando...');
                    },
                    success: function (data) {
                        setTimeout(function () {
                            $('#confirmModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                            alert('Usuario Eliminado');
                        }, 2000);
                    }
                })
            });

    });
</script>

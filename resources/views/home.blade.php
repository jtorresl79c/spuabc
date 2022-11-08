@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #EFB810;">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            <span id="form_result"></span>
                        </div>
                    @endif

                    Sesión activa
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection

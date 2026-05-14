@extends('layouts.auth')

@section('titulo_pagina', 'Iniciar Sesión')

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">

                    <div class="row">
                        {{-- Imagen decorativa (visible solo en pantallas grandes) --}}
                        {{-- Video decorativo lado izquierdo --}}
                        <div class="col-lg-6 d-none d-lg-block p-0"
                             style="position: relative; overflow: hidden; border-radius: 0.35rem 0 0 0.35rem; background-color: #fff; min-height: 380px;">
                            <video
                                autoplay
                                loop
                                muted
                                playsinline
                                style="position: absolute; top: 0; left: 0;
                                       width: 100%; height: 100%;
                                       object-fit: cover;
                                       object-position: 60% 20%;">
                                <source src="/IMG/logo1.mp4" type="video/mp4">
                            </video>
                        </div>

                        {{-- Formulario de login --}}
                        <div class="col-lg-6">
                            <div class="p-5">

                                <div class="text-center mb-4">
                                    <i class="fas fa-paw fa-3x text-primary mb-3"></i>
                                    <h1 class="h4 text-gray-900">¡Bienvenido!</h1>
                                    <p class="text-muted small">Ingresa tus credenciales para continuar</p>
                                </div>

                                {{-- Mensajes de error --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Credenciales incorrectas. Intenta de nuevo.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form class="user" action="{{ route('logear') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="Correo electrónico..."
                                               required
                                               autofocus>
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control form-control-user"
                                               id="password"
                                               name="password"
                                               placeholder="Contraseña"
                                               required>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                                    </button>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@extends('user::layouts.master')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Edit User</h1>

        <form action="{{ route('user.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="firma" class="form-label">Firma</label>
                <input type="text" class="form-control" id="firma" name="firma" value="{{ $user->firma }}">
                <div class="invalid-feedback">
                    Bitte geben Sie den Firmennamen ein.
                </div>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                <div class="invalid-feedback">
                    Bitte geben Sie den Namen ein.
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                <div class="invalid-feedback">
                    Bitte geben Sie eine gültige E-Mail-Adresse ein.
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Neues Passwort</label>
                <input type="password" class="form-control" id="password" name="password">
                <div class="invalid-feedback">
                    Bitte geben Sie ein Passwort mit mindestens 8 Zeichen ein.
                </div>
            </div>

            <div class="mb-3">
                <label for="password-confirmation" class="form-label">Passwort bestätigen</label>
                <input type="password" class="form-control" id="password-confirmation" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>

        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>

    <script>
        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection

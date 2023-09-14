@extends('permission::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Permissions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Permissions</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.permission')

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Permissionsübersicht</h5>

                <!-- Dark Table -->
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Permissionskey</th>
                        <th scope="col">Beschreibung</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $perm)
                        <tr>
                            <th>{{ $perm->id }}</th>
                            <td>{{ $perm->key }}</td>
                            <td>{{ $perm->desc }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <form method="post" action="{{ route('permission.store')}}">
                            {{ csrf_field() }}
                        <th></th>
                        <td><input type="text" class="form-control" id="inputText" name="key"></td>
                        <td><input type="text" class="form-control" id="inputText" name="desc"></td>
                        <td><button type="submit" class="btn btn-primary">Submit</button></td>
                        </form>
                    </tr>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>

    @endcan
@endsection

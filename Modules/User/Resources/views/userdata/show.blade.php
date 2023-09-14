@extends('user::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitglieder</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item">Mitglieder</li>
                <li class="breadcrumb-item active">UserData</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('dashboard.see.Times')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">UserDataTabelle</h5>

                <!-- Dark Table -->
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Key</th>
                        <th scope="col">Datum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userDatas as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->key }}</td>
                            <td>{{ $data->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>
    @endcan
@endsection

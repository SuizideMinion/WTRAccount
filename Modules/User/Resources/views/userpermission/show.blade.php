@extends('user::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitglieder</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item">Mitglieder</li>
                <li class="breadcrumb-item active">UserPermission</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('dashboard.see.Times')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">UserPermissionsTabelle</h5>

                <!-- Dark Table -->
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Key</th>
                        <th scope="col">Datum</th>
                        <th scope="col">X</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($userPermissions as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->key }}</td>
                            <td>{{ $data->created_at }}</td>
                            <td>
                                <form method="post" action="{{ route('userpermission.destroy', $data->id)}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

                @foreach($permissions as $perm)
                    {{--                    {{ dd(auth()->user()->userHasPermission() ) }}--}}
                    @if( isset(auth()->user()->userHasPermission()[$perm->key]) )
                        <span class="badge bg-success">{{ $perm->key }}</span>
                    @else
                        <span class="badge bg-light text-dark">
                            <form method="post" action="{{ route('userpermission.store')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="key" value="{{ $perm->key }}">
                                <input type="hidden" name="user_id" value="{{ $id }}">
                                    <button style="background:none;border:none;margin:0;padding:0;cursor: pointer;"
                                            type="submit">{{ $perm->key }}</button>
                            </form>
                        </span>
                    @endif
                @endforeach

            </div>
        </div>
    @endcan
@endsection

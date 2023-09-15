@extends('user::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitglieder</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Mitarbeiter</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.Users')
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                <div class="card-body">
                    <h5 class="card-title">Registriere <span>Arbeiter</span></h5>

                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <div class="datatable-container">
                            <table class="table table-borderless datatable datatable-table">
                                <thead>
                                <tr>
                                    <th><a href="#">#</a>
                                    </th>
                                    <th width="100%"><a href="#">Arbeiter</a>
                                    </th>
                                    <th><a href="#">-</a>
                                    </th>
                                    <th><a href="#">Einstellungen</a>
                                    </th>
                                    <th><a href="#">Status</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Users as $User)

                                    <tr data-index="0">
                                        <td><a href="#">{{ $User->id }}</a></td>
                                        <td>{{ $User->name }}</td>
                                        <td></td>
                                        <td>
                                            <form method="POST" action="{{ route('timemanagment.store') }}">
                                                @csrf
                                                <a href="{{ route('userdata.show', $User->id) }}"
                                                   title="UserDaten Bearbeiten"><i
                                                        class="bi bi-wrench"></i></a>
                                                <a href="{{ route('userpermission.show', $User->id) }}"
                                                   title="UserPermissions Bearbeiten"><i
                                                        class="bi bi-folder-check"></i></a>

                                                @if( $User->userAktive() == false )
                                                    <input type="hidden" name="stamped_in" value="1">
                                                    <input type="hidden" name="user_id"
                                                           value="{{ auth()->user()->id }}">
                                                    <button
                                                        style="background:none;border:none;margin:0;padding:0;cursor: pointer;"
                                                        title="Einstempeln"
                                                        type="submit"><i class="bi bi-person-check"></i></button>
                                                @else
                                                    <input type="hidden" name="stamped_in" value="0">
                                                    <input type="hidden" name="user_id"
                                                           value="{{ auth()->user()->id }}">
                                                    <button
                                                        style="background:none;border:none;margin:0;padding:0;cursor: pointer;"
                                                        title="Ausstempeln"
                                                        type="submit"><i class="bi bi-person-dash-fill"></i></button>
                                            @endif
                                        </td>
                                        </form>
                                        {{--                                        TODO:: in der Arbeit usw machen --}}
                                        {{--                                        {{dd($User->userAktive())}}--}}
                                        @if( $User->userAktive() == false )
                                            <td><span class="badge bg-danger">Nicht da</span></td>
                                        @else
                                            <td><span class="badge bg-success">in der Arbeit</span></td>
                                        @endif
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endcan
@endsection

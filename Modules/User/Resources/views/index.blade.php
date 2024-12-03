@extends('user::layouts.master')

@section('styles')
    <style>
        .bi {
            margin-right: 5px;
            font-size: large;
        }
    </style>
@endsection

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
                    <h5 class="card-title">Registrierte <span>Arbeiter</span></h5>

                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        <div class="datatable-container">
                            <table class="table table-borderless datatable datatable-table">
                                <thead>
                                <tr>
                                    <th><a href="#">#</a>
                                    </th>
                                    <th width="50%"><a href="#">Arbeiter</a>
                                    </th>
                                    <th width="25%">
                                        {{ date("F", strtotime("-1 month", time())) }}
                                    </th>
                                    <th width="25%">
                                        {{ __( date('F') ) }}
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
                                        <td>{{ $User->id }}</td>
                                        <td>{{ $User->name }}</td>
                                        <td>

                                            {{ getZeit($User->getWorktime(strtotime(date('Y-m-01') . '- 1 month'), strtotime(date('Y-m-t') . '- 1 month') + 24 * 60 * 60)) }}

                                        </td>
                                        <td>

                                            {{ getZeit($User->getWorktime(strtotime(date('Y-m-01')), strtotime(date('Y-m-t')) + 24 * 60 * 60)) }}

                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('userdata.show', $User->id) }}"
                                               title="UserDaten Bearbeiten"><i
                                                    class="bi bi-wrench"></i></a>
                                            <a href="{{ route('userpermission.show', $User->id) }}"
                                               title="UserPermissions Bearbeiten"><i
                                                    class="bi bi-folder-check"></i></a>
                                            <a href="{{ route('statistik.show', $User->id) }}"
                                               title="Statistik Anschauen"><i
                                                    class="bi bi-calendar-date"></i></a>
                                            <a href="{{ route('timemanagment.show', $User->id) }}"
                                               title="Stempelseite Anschauen"><i
                                                    class="bi bi-clock-fill"></i></a>
                                            <a href="{{ route('user.edit', $User->id) }}"
                                               title="User Bearbeiten"><i
                                                    class="bi bi-pen-fill"></i></a>

                                            <form method="POST" action="{{ route('timemanagment.store') }}">
                                                @csrf
                                                @if( $User->userAktive() == false )
                                                    <input type="hidden" name="stamped_in" value="1">
                                                    <input type="hidden" name="user_id"
                                                           value="{{ $User->id }}">
                                                    <button
                                                        style="background:none;border:none;margin:0;padding:0;cursor: pointer;"
                                                        title="Einstempeln"
                                                        type="submit"><i class="bi bi-person-check"></i></button>
                                                @else
                                                    <input type="hidden" name="stamped_in" value="0">
                                                    <input type="hidden" name="user_id" value="{{ $User->id }}">
                                                    <button
                                                        style="background:none;border:none;margin:0;padding:0;cursor: pointer;"
                                                        title="Ausstempeln"
                                                        type="submit"><i class="bi bi-person-dash-fill"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
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

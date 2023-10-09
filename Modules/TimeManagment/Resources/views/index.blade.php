@extends('timemanagment::layouts.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
@endsection

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitarbeiter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Stempeln</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.timemanagment')
        <form method="POST" action="{{ route('timemanagment.store') }}">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2 mt-3">
                        @if(!$activeTime)
                            <input type="hidden" name="stamped_in" value="1">
                            <input type="hidden" name="user_id" value="{{ ($id ?? auth()->user()->id) }}">
                            <button class="btn btn-primary" type="submit">Einstempeln {{ (isset($user) ? 'für ' . $user->name:'')}}</button>
                        @else
                            <input type="hidden" name="stamped_in" value="0">
                            <input type="hidden" name="user_id" value="{{ ($id ?? auth()->user()->id) }}">
                            <button class="btn btn-primary" type="submit">Ausstempeln {{ (isset($user) ? 'für ' . $user->name:'') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Letzte Zeiterfassungen</h5>

                <!-- Dark Table -->
                <table id="table" class="table datatable datatable-table">
                    <thead>
                    <tr>
                        <th scope="col">von</th>
                        <th scope="col">bis</th>
                        <th scope="col">Zeit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lastWorkings as $last)
                        <tr onclick="location.href='{{ route('request.show', $last->id) }}'">
{{--                            <th>{{ $last->user->name }}</th>--}}
                            <td data-sort="{{ $last->stamped }}">{{ date("d.m H:i",$last->stamped + strtotime("1970/1/1")) }}</td>
                            <td data-sort="{{ $last->stamped_out }}">{{ date("d.m H:i",$last->stamped_out + strtotime("1970/1/1")) }}</td>
                            <td data-sort="{{ $last->time_worked }}">{{ getZeit($last->time_worked) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    <!-- jQuery UI -->
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Datatables Js-->
    <script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#table').DataTable({
                pageLength : 25,
                lengthMenu: [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
                order: [[1, 'desc']]
            })
        });
    </script>
@endsection

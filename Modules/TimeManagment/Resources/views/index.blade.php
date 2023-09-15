@extends('timemanagment::layouts.master')

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
                <h5 class="card-title">Letzte 20 Zeiterfassungen</h5>

                <!-- Dark Table -->
                <table class="table">
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
                            <th>{{ date("d.m H:i",$last->stamped + strtotime("1970/1/1")) }}</th>
                            <td>{{ date("d.m H:i",$last->stamped_out + strtotime("1970/1/1")) }}</td>
                            <td>{{ getZeit($last->time_worked) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- End Dark Table -->

            </div>
        </div>
    @endcan
@endsection

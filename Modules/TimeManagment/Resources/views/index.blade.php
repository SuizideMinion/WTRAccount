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
        @if(!$activeTime)
            <form method="POST" action="{{ route('timemanagment.store') }}">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2 mt-3">
                            <input type="hidden" name="stamped_in" value="1">
                            <button class="btn btn-primary" type="submit">Einstempeln</button>
                        </div>
                    </div>
                </div>

            </form>
        @else

            <form method="POST" action="{{ route('timemanagment.store') }}">
                @csrf
                <h5 class="card-title">Eingestempelt um {{ $activeTime->created_at->format('H:i:s d.m.Y')  }}</h5>
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2 mt-3">
                            <input type="hidden" name="stamped_in" value="0">
                            <button class="btn btn-primary" type="submit">Ausstempeln</button>
                        </div>
                    </div>
                </div>

            </form>
        @endif

    @endcan
@endsection

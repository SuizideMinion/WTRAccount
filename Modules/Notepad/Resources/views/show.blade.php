@extends('notepad::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Notepad</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Übersicht</a></li>
                <li class="breadcrumb-item active">Notizblock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.notepad')

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ showBBcodes($Notiz->title) }}</h5>

                    <form method="post" action="{{ route('notepad.edit', $Notiz->id)}}">
                        @method('GET')


                        {!! showBBcodes($Notiz->text) !!}
                        <br><br>
                        <button type="submit" class="btn btn-primary">Ändern</button>
                    </form>

                </div>
            </div>
        </div>

    @endcan
@endsection

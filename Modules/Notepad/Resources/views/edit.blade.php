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

                    <form method="post" action="{{ route('notepad.update', $Notiz->id)}}">
                        {{ csrf_field() }}
                        @method('PUT')

                        <label for="inputText"></label>
                        <input type="text" class="form-control"
                               id="inputText" name="title"
                               placeholder="Titel"
                        value="{{ $Notiz->title }}">
                        <textarea name="text" style="width: 100%;height: 400px"
                                  placeholder="Text">{{ $Notiz->text }}</textarea>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>

    @endcan
@endsection

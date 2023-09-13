@extends('user::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Mitglieder</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/dashboard">Übersicht</a></li>
                <li class="breadcrumb-item active">Mitglieder</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('content')
    @can('show.Users')
        <div class="col-12">
            <div class="card recent-sales overflow-auto">

                {{--            <div class="filter">--}}
                {{--                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>--}}
                {{--                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">--}}
                {{--                    <li class="dropdown-header text-start">--}}
                {{--                        <h6>Filter</h6>--}}
                {{--                    </li>--}}

                {{--                    <li><a class="dropdown-item" href="#">Today</a></li>--}}
                {{--                    <li><a class="dropdown-item" href="#">This Month</a></li>--}}
                {{--                    <li><a class="dropdown-item" href="#">This Year</a></li>--}}
                {{--                </ul>--}}
                {{--            </div>--}}

                <div class="card-body">
                    <h5 class="card-title">Registriere <span>Mitglieder</span></h5>

                    <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                        {{--                    <div class="datatable-top">--}}
                        {{--                        <div class="datatable-dropdown">--}}
                        {{--                            <label>--}}
                        {{--                                <select class="datatable-selector">--}}
                        {{--                                    <option value="5">5</option>--}}
                        {{--                                    <option value="10" selected="">10</option>--}}
                        {{--                                    <option value="15">15</option>--}}
                        {{--                                    <option value="20">20</option>--}}
                        {{--                                    <option value="25">25</option>--}}
                        {{--                                </select> entries per page--}}
                        {{--                            </label>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="datatable-search">--}}
                        {{--                            <input class="datatable-input" placeholder="Search..." type="search"--}}
                        {{--                                   title="Search within table">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        <div class="datatable-container">
                            <table class="table table-borderless datatable datatable-table">
                                <thead>
                                <tr>
                                    <th style="width: 15.601023017902813%;"><a href="#">#</a>
                                    </th>
                                    <th style="width: 22.506393861892583%;"><a href="#">Customer</a>
                                    </th>
                                    <th style="width: 26.342710997442452%;"><a href="#">Product</a>
                                    </th>
                                    <th style="width: 14.066496163682865%;"><a href="#">Price</a>
                                    </th>
                                    <th style="width: 21.483375959079286%;"><a href="#">Status</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($Users as $User)

                                    <tr data-index="0">
                                        <td><a href="#">{{ $User->id }}</a></td>
                                        <td>{{ $User->name }}</td>
                                        <td></td>
                                        <td></td>
                                        <td><span class="badge bg-success">bei der Arbeit</span></td>
                                    </tr>

                                @endforeach

                                <tr data-index="1">
                                    <td><a href="#">#2147</a></td>
                                    <td>Bridie Kessler</td>
                                    <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                                    <td>$47</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr data-index="2">
                                    <td><a href="#">#2049</a></td>
                                    <td>Ashleigh Langosh</td>
                                    <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                                    <td>$147</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                <tr data-index="3">
                                    <td><a href="#">#2644</a></td>
                                    <td>Angus Grady</td>
                                    <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                                    <td>$67</td>
                                    <td><span class="badge bg-danger">Rejected</span></td>
                                </tr>
                                <tr data-index="4">
                                    <td><a href="#">#2644</a></td>
                                    <td>Raheem Lehner</td>
                                    <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                                    <td>$165</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="datatable-bottom">
                            <div class="datatable-info">Showing 1 to 5 of 5 entries</div>
                            <nav class="datatable-pagination">
                                <ul class="datatable-pagination-list"></ul>
                            </nav>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endcan
@endsection

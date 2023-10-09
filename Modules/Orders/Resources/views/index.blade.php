@extends('orders::layouts.master')

@section('breadclumbs')
    <div class="pagetitle">
        <h1>Aufträge</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Übersicht</a></li>
                <li class="breadcrumb-item active">Aufträge</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
@endsection

@section('content')
    @can('showOrders')

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Aufträge</h5>

                <a href="{{ route('orders.create') }}">Neuen Auftrag erstellen</a>
{{--                <a href="#" onclick="dropTable()">Lösche alles</a>--}}
{{--                <a href="#" onclick="getData()">Hole alles</a>--}}

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Firma</th>
                        <th>Kunde</th>
{{--                        <th>Auftraggeber</th>--}}
                        <th>Status</th>
                        <th>Erstellt am</th>
                    </tr>
                    </thead>
                    <tbody id="tablecontents">
                    @foreach($Orders as $task)
                        <tr class="row1" data-id="{{ $task->id }}">
                            <td>
                                <div
                                    style="color:rgb(124,77,255); padding-left: 10px; float: left; font-size: 20px; cursor: pointer;"
                                    title="change display order">
                                    <i class="bi bi-grip-vertical"></i>
{{--                                    <i class="bi bi-grip-vertical"></i>--}}
                                </div>
                            </td>
{{--                            <td>{{ $task->auftraggeber }}</td>--}}
{{--                            {{dd( $task->data() )}}--}}
                            <td>{{ $task->data()['firma'] ?? '' }}</td>
                            <td><a href="{{ route('orders.show', $task->link) }}"> {{ $task->name }}</a></td>
                            <td>{{ getStatus($task->status) }}</td>
                            <td>{{ date('d-m-Y h:m:s',strtotime($task->created_at)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    <!-- jQuery UI -->
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Datatables Js-->
    <script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

    {{--    <script>--}}
    {{--        getData();--}}
    {{--        // setTimeout("getData()",5000);--}}

    {{--        function getData() {--}}
    {{--            $("#table tr").remove();--}}
    {{--            $.ajax({--}}
    {{--                url: '/order/getdata',--}}
    {{--                dataType: 'json',--}}
    {{--                success: function (data) {--}}
    {{--                    drawTable(data);--}}
    {{--                }--}}
    {{--            });--}}
    {{--            // setTimeout("getData()",5000);--}}
    {{--        }--}}

    {{--        function dropTable() {--}}
    {{--            $("#table tr").remove();--}}
    {{--        }--}}

    {{--        function drawTable(data) {--}}

    {{--            // Get Table headers and print--}}
    {{--            var head = $("<tr />")--}}
    {{--            $("#table").append(head);--}}
    {{--            head.append($("<th>*</th>"));--}}
    {{--            for (var j = 0; j < Object.keys(data[0]).length; j++) {--}}
    {{--                head.append($("<th>" + Object.keys(data[0])[j] + "</th>"));--}}
    {{--            }--}}

    {{--            // Print the content of rows in DataTable--}}
    {{--            for (var i = 0; i < data.length; i++) {--}}
    {{--                drawRow(data[i]);--}}
    {{--            }--}}

    {{--        }--}}

    {{--        function drawRow(rowData) {--}}
    {{--            var row = $("<tr />")--}}
    {{--            $("#table").append(row);--}}
    {{--            row.append($("<td>*</td>"));--}}
    {{--            row.append($("<td>" + rowData["auftraggeber"] + "</td>"));--}}
    {{--            row.append($("<td>" + rowData["name"] + "</td>"));--}}
    {{--            row.append($("<td>" + rowData["status"] + "</td>"));--}}
    {{--            row.append($("<td>" + rowData["created_at"] + "</td>"));--}}
    {{--        }--}}
    {{--    </script>--}}

    <script type="text/javascript">
        $(function () {
            // $("#table").DataTable();

            $("#tablecontents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function () {
                    sendOrderToServer();
                }
            });

            function sendOrderToServer() {

                var order = [];
                $('tr.row1').each(function (index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/order/updaterequest') }}",
                    data: {
                        order: order,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            console.log(response);
                        } else {
                            console.log(response);
                        }
                    }
                });

            }
        });

    </script>
@endsection

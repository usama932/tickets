@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

@section('content')
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Ride History</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{!! route('userreport') !!}">{{trans('lang.reports')}}</a></li>
                <li class="breadcrumb-item active">Ride History</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Trip Id#</th>
                                <th>Passenger</th>
                                <th>Requested Date Time</th>
                                <th>Driver Number</th>
                                <th>Vehicle Plate Number</th>
                                <th>Commenced Date time</th>
                                <th>Pick Up Address</th>
                                <th>Commenced Latitude</th>
                                <th>Commenced Longitude</th>
                                <th>Ended Latitude</th>
                                <th>Ended Longitude</th>
                                <th>Ended Date-time</th>
                                <th>Drop-off address</th>
                                <th>Wheelchair Accessible Vehicle</th>
                                <th>Distance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                                <tr>
                                    <td>#.000{{$data->id ?? ''}}</td>
                                    <td>{{$data->user_name  ?? ''}}</td>
                                    <td>{{$data->creer  ?? ''}}</td>
                                    <td>{{$data->driver_phone  ?? ''}}</td>
                                    <td>{{$data->numberplate  ?? ''}}</td>
                                    <td>{{$data->date_retour  ?? ''}} {{$data->heure_retour  ?? ''}}</td>
                                    <td>{{$data->depart_name  ?? ''}}</td>
                                    <td>{{$data->latitude_depart  ?? ''}}</td>
                                    <td>{{$data->longitude_depart  ?? '' }}</td>
                                  
                                    <td>{{$data->latitude_arrivee  ?? ''}}</td>
                                    <td>{{$data->latitude_arrivee  ?? ''}}</td>
                                    <td>{{$data->date_retour  ?? ''}}</td>
                                    <td>{{$data->destination_name  ?? ''}}</td>
                                    <td>@if($data->wheel_chair == 1) True @else False @endif</td>
                                    <td>{{$data->distance ?? ''}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Trip Id#</th>
                                <th>Passenger</th>
                                <th>Requested Date Time</th>
                                <th>Driver Number</th>
                                <th>Vehicle Plate Number</th>
                                <th>Commenced Date time</th>
                                <th>Pick Up Address</th>
                                <th>Commenced Latitude</th>
                                <th>Commenced Longitude</th>
                                <th>Ended Latitude</th>
                                <th>Ended Longitude</th>
                                <th>Ended Date-time</th>
                                <th>Drop-off address</th>
                                <th>Wheelchair Accessible Vehicle</th>
                                <th>Distance</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Responsive Extension -->
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

<!-- DataTables Buttons -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#example').DataTable({
            responsive: true, // Enable responsive extension
            // Your DataTable configuration here
        });

        // DataTables Buttons configuration
        new $.fn.dataTable.Buttons(table, {
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        }).container().appendTo($('.col-md-6:eq(0)', table.table().container()));
    });
</script>
@endsection

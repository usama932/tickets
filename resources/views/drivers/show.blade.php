@extends('layouts.app')

@section('content')

<div class="page-wrapper userdetail-page">

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor">Driver Detail</h3>

            </div>

            <div class="col-md-7 align-self-center">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{!! url('/dashboard') !!}">Dashboard</a></li>

                    <li class="breadcrumb-item"><a href="{!! url('drivers') !!}">Drivers</a></li>

                    <li class="breadcrumb-item active">Driver Detail</li>

                </ol>

            </div>

        </div>

        <div class="container-fluid">

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body p-0 pb-5">

                           <div class="user-top">

                                <div class="row align-items-center">

									<div class="user-profile col-md-2">

										<div class="profile-img">

	                                       @if (!empty($driver->photo_path))
	                                            <td><img class="profile-pic" src="{{asset('assets/images/driver').'/'.$driver->photo_path}}" alt="image"></td>
	                                        @else
	                                        <td><img class="profile-pic" src="{{asset('assets/images/placeholder_image.jpg')}}" alt="image"></td>

	                                        @endif
										</div>

                                 	</div>
	                                <div class="user-title col-md-8">
		                                 <h4 class="card-title"> Details of {{$driver->prenom}} {{$driver->nom}}</h4>
        	                        </div>
                               </div>
                           </div>


						<div class="user-detail" role="tabpanel">

						    <!-- Nav tabs -->
						    <ul class="nav nav-tabs">

						    	<li role="presentation" class="">
						        	<a href="#information" aria-controls="information" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'information' || Request::get('tab') == '') ? 'active show' : '' }}">Information</a>
						        </li>

						        <li role="presentation" class="">
						        	<a href="#rides" aria-controls="rides" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'rides') ? 'active show' : '' }}">Rides</a>
						        </li>

						        <li role="presentation" class="">
						        	<a href="#vehicle" aria-controls="vehicle" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'vehicle') ? 'active show' : '' }}">Vehicle</a>


						    </ul>

						    <!-- Tab panes -->
						    <div class="tab-content">

						        <div role="tabpanel" class="tab-pane {{ (Request::get('tab') == 'information' || Request::get('tab') == '') ? 'active' : '' }}" id="information">

						        	<div class="row">

		                                <div class="col-md-6">
		                                  <div class="col-group">
		                                    	<label for="" class="font-weight-bold">{{trans('lang.user_phone')}}:</label>
		                                    	<span>{{ $driver->phone}}</span>
		                                	</div>
		                                </div>

		                                <div class="col-md-6">
		                                  	<div class="col-group">
		                                    	<label for="" class="font-weight-bold">{{trans('lang.email')}}:</label>
		                                    	<span>{{ $driver->email}}</span>
		                                   	</div>
		                                </div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.bank_name')}}:</label>
												<span>{{ $driver->bank_name}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.branch_name')}}:</label>
												<span>{{ $driver->branch_name}}</span>
											</div>
										</div>
										<div class="col-md-6">
										<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.status')}} :</label>
												@if($driver->statut=="yes")
													<span class="badge badge-success">Enabled</span>
												@else
													<span class="badge badge-warning">Disabled</span>
												@endif
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.holder_name')}}:</label>
												<span>{{ $driver->holder_name}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.account_no')}} :</label>
												<span>{{$driver->account_no}}</span>
											</div>
										</div>

		                                <div class="col-md-6">
		                                  	<div class="col-group">
		                                		<label for="" class="font-weight-bold">{{trans('lang.ifsc_code')}} :</label>
		                                       <span>{{$driver->ifsc_code}}</span>
		                                   </div>
		                                </div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.Other_info')}} :</label>
												<span>{{$driver->other_info}}</span>
											</div>
										</div>

		                                <div class="col-md-6">
		                                   	<div class="col-group">
		                                    	<label for="" class="font-weight-bold">{{trans('lang.created_at')}} :</label>
		                                    	<span class="date">{{ date('d F Y',strtotime($driver->creer))}}</span>
                                                      <span class="time">{{ date('h:i A',strtotime($driver->creer))}}</span>
		                                	</div>
		                                </div>

		                                <div class="col-md-6">
		                                  	<div class="col-group">
		                                  	  <label for="" class="font-weight-bold">{{trans('lang.edited')}} :</label>
		                                    	@if($driver->modifier!='0000-00-00 00:00:00')
                                                      <span class="date">{{ date('d F Y',strtotime($driver->modifier))}}</span>
                                                      <span class="time">{{ date('h:i A',strtotime($driver->modifier))}}</span>
                                                      @endif
		                                	</div>
										</div>

										<div class="col-md-6">
		                                  	<div class="col-group">
		                                  	  <label for="" class="font-weight-bold">{{trans('lang.wallet_balance')}} :</label>
		                                    	<span>${{ $driver->amount }}</span>
		                                	</div>
										</div>

										<div class="col-md-12">
		                                    <div class="col-group-btn">
		                                        @if ($driver->statut=="no")
		                                            <a href="{{route('driver.changeStatus', ['id' => $driver->id])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Activate">{{trans('lang.enable_account')}}<i class="fa fa-check"></i> </a>
		                                        @else
		                                        <a href="{{route('driver.changeStatus', ['id' => $driver->id])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="Activate"> Disable account <i class="fa fa-check"></i> </a>
		                                        @endif
		                                   </div>
		                                </div>



		                             </div>

						        </div>

						        <div role="tabpanel" class="tab-pane {{ Request::get('tab') == 'rides' ? 'active' : '' }}" id="rides">
						        	@if(count($rides) > 0)
						        	<div class="table-responsive">
						        		<table class="display nowrap table table-hover table-striped table-bordered table table-striped">
			                                <thead>
			                                    <tr>
			                                        <th>{{trans('lang.ride_id')}}</th>
			                                        <th>{{trans('lang.driver_name')}}</th>
			                                        <!-- <th >{{trans('lang.depart')}}</th>
			                                        <th >{{trans('lang.destination')}}</th> -->
			                                        <th >{{trans('lang.status')}}</th>
			                                        <th >{{trans('lang.created')}}</th>
			                                        <th>{{trans('lang.actions')}}</th>
			                                    </tr>
			                                </thead>
			                                <tbody id="append_list12">
			                                    @foreach($rides as $ride)
			                                    <tr>
			                                        <td><a href="{{route('ride.show', ['id' => $ride->id])}}">{{ $ride->id}}</a></td>
                                                    <td><a href="{{route('driver.show', ['id' => $ride->driver_id])}}">{{ $ride->driverPrenom}} {{ $ride->driverNom}}</a></td>
			                                        <!-- <td>{{ $ride->depart_name}}</td>
			                                        <td>{{ $ride->destination_name}}</td> -->
			                                        <td>
			                                        	@if($ride->statut=="completed")
			                                                <span class="badge badge-success">{{ $ride->statut }}<span>
			                                            @elseif($ride->statut=="rejected")
			                                                <span class="badge badge-danger">{{ $ride->statut }}<span>
			                                            @else
			                                                <span class="badge badge-warning">{{ $ride->statut }}<span>
			                                            @endif
			                                        </td>
			                                        <td>{{ date('d F Y h:i A',strtotime($ride->creer))}}</td>
			                                        <td class="action-btn">
			                                        	<a href="{{route('ride.show', ['id' => $ride->id])}}" class="" data-toggle="tooltip" data-original-title="Details"><i class="fa fa-ellipsis-h"></i></a>
														<a id="'+val.id+'"
                                                   class="do_not_delete"
                                                   name="user-delete"
                                                   href="{{route('ride.delete', ['rideid' => $ride->id])}}"><i
                                                            class="fa fa-trash"></i></a>
													</td>
			                                    </tr>
			                                    @endforeach
			                                </tbody>
			                            </table>
			                            <nav aria-label="Page navigation example" class="custom-pagination">
                                    		{{ $rides->appends(['tab'=>'rides'])->links() }}
                                		</nav>
                                                {{ $rides->appends(['tab'=>'rides'])->links('pagination.pagination') }}
									</div>
									@else
						        		<p><center>No results found.</center></p>
									@endif
						        </div>
								<div role="tabpanel" class="tab-pane {{ Request::get('tab') == 'vehicle' ? 'active' : ''}}" id="vehicle">

									<div class="row">
									@if($vehicle)
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.brand')}}:</label>

												<span>{{ $vehicle->brand}}</span>


											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.vehicle_model')}}:</label>

												<span>{{ $vehicle->model}}</span>

											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.car_number')}}:</label>
												<span>{{ $vehicle->numberplate}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.number_of_pessanger')}}:</label>
												<span>{{ $vehicle->passenger}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.vehicle_color')}}:</label>
												<span>{{ $vehicle->color}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.vehicle_milage')}}:</label>
												<span>{{ $vehicle->milage}}</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.vehicle_km')}}:</label>
												<span>{{ $vehicle->km}}</span>
											</div>
										</div>
										@endif
										{{--<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.status')}} :</label>
												@if($vehicle->statut=="yes")
													<span class="badge badge-success">Enabled</span>
												@else
													<span class="badge badge-warning">Disabled</span>
												@endif
											</div>
										</div>--}}

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.created_at')}} :</label>
												<span class="date">{{ date('d F Y',strtotime($driver->creer))}}</span>
                                                                        <span class="time">{{ date('h:i A',strtotime($driver->creer))}}</span>
											</div>
										</div>

										<div class="col-md-6">
											<div class="col-group">
												<label for="" class="font-weight-bold">{{trans('lang.edited')}} :</label>
												@if($driver->modifier!='0000-00-00 00:00:00')
                                                                        <span class="date">{{ date('d F Y',strtotime($driver->modifier))}}</span>
                                                                        <span class="time">{{ date('h:i A',strtotime($driver->modifier))}}</span>
                                                                        @endif
											</div>
										</div>

									</div>

								</div>




							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

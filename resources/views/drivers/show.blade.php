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

								</li>
								<li role="presentation" class="">
						        	<a href="#security" aria-controls="security" role="tab" data-toggle="tab" class="{{ (Request::get('tab') == 'security') ? 'active show' : '' }}">CPV Requirement</a>

								</li>
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

								<div role="tabpanel" class="tab-pane {{ Request::get('tab') == 'security' ? 'active' : ''}}" id="security">
									<div class="card">
										<h6 class="card-header">DRIVER INDUCTION TRAINING & ACKNOWLEDGEMENT</h6>
										<div class="card-body">
											<h5>Driver Fatigue
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>The maximum continuous work duty hours is 12 before an off duty period of at least 8 hours. Whilst on duty you must take a minimum 30 minute break every 6 hours.</p>
											<h5>Drug and Alcohol
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>It is a legal requirement in the State of Victoria that you must not operate a taxi or any commercial vehicle under the influence of drugs or alcohol. All drivers must always have a 0.00 BAC when driving a CPV.</p>
											<h5>Maintenance of Vehicles
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>All CPV drivers are responsible for ensuring the vehicle they are operating is in a safe and roadworthy condition. Before each shift you must check the operation of all lights, the operation of all doors and restraints (seatbelts) and make a visual inspection of the body and tyres of the vehicle. Vehicles with any defect that would be deemed as unroadworthy must NOT be operated on our platform under any circumstances. All taxis must also have a roadworthy certificate current to within 365 days.</p>
											<h5>Emergency Management
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>In the case of an emergency you should dial 000 immediately for assistance if required. Please also contact us on +61 434 423 423 and report the emergency as soon as practicable</p>
											<h5>Driver Behaviour
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>All drivers on our platform need to conduct themselves in a professional, honest and courteous way at all times. No form of discrimination is acceptable and will not be tolerated.</p>
											<h5>Medical Fitness
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>If you are feeling unwell or have a contagious disease you must not operate a CPV. If you are suffering a physical injury or taking prescription medication which impacts, or may impact your ability to operate the vehicle, you must not operate the vehicle</p>
											<h5>COVID19
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>To prevent the spread of coronavirus we ask that you please wipe down the touch points and disinfect your vehicle at the start of every shift. If you have cold and flu symptoms but are well enough to drive, please wear a mask as a precaution. If you test positive to COVID19 we ask that you do not drive for 3 days or while you have symptoms. We recommend that you also have masks and hand sanitizer available to provide to passengers in the event you become aware they are positive for coronavirus.</p>
											<h5>Notifiable Incidents
												
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>As a driver you are a duty holder under the CPV regulations, which means you have a legal obligation to report notifiable incidents and you must notify CPV within ten business days of becoming aware an incident has occurred. You can do so using the Notifiable Incidents Portal. It is an offence not to report a notifiable incident. The failure to do so may result in compliance action by Safe Transport Victoria</p>
											<h5>Reporting Hazards
											
												@if(!empty($cpvs))
													@if($cpvs->driver_fatigue == 1)
													<i class="fa fa-check" style="font-size:36px;color:green"></i>
													@else
													<i class="fa fa-close" style="font-size:36px;color:red"></i>
													@endif
												@endif
											</h5>
											<p>If you become aware of any hazards please use our WhatsApp group to report the hazard for the safety of other drivers and passengers.</p>
											<div class="d-flex justify-content-end">
												<h5>Date:: 


												</h5>
											</div>
											<div class="d-flex justify-content-end">
												
												
												<h5>Driver Name:: 
													

												</h5>
												
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

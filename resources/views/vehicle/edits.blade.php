@extends('layouts.app')

@section('content')


    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.vehicle_type')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('vehicle/index') }}">{{trans('lang.vehicle_type')}}</a>
                    </li>
                    <li class="breadcrumb-item active">{{trans('lang.edit_vehicle_type')}}</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card pb-4">

                        <div class="card-body">

                            <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                 style="display: none;">{{trans('lang.processing')}}</div>
                            <div class="error_top"></div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="post" action="{{ route('vehicle-type.update',$type->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="row restaurant_payout_create">
                                    <div class="restaurant_payout_create-inner">

                                        <fieldset>
                                            <legend>{{trans('lang.edit_vehicle_type')}}</legend>
                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.vehicle_type')}}</label>
                                                <div class="col-7">
                                                    <select  class="form-control brand_id" name="libelle">
                                                        <option value="">--! Select Type !--</option>
                                                        <option value="Passenger" @if($type->libelle == "Passenger") selected @endif>Only Passenger Carry</option>
                                                        <option value="Passenger & Pet"  @if($type->libelle == "Passenger & Pet") selected @endif>Passenger & Pet Carry</option>
                                                        <option value="Passenger, Pet & Package"  @if($type->libelle == "Passenger, Pet & Package") selected @endif>Passenger, Pet & Package Carry</option>

                                                    </select>

                                                    <!-- <div class="form-text text-muted"></div> -->
                                                </div>
                                            </div>

                                        <!-- <div class="form-group row width-50">
              <label class="col-3 control-label">{{trans('lang.price')}}</label>
              <div class="col-7">
                <input type="text" class="form-control" name="prix" value="{{$type->prix}}">
               <div class="form-text text-muted"></div>-->
                                            <!--</div>
                                         </div> -->

                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.Image')}}</label>
                                                <div class="col-7">
                                                    <input type="file" class="form-control" name="image"
                                                           onchange="readURL(this);">
                                                    @if ( !empty($type->image))
                                                        <img class="rounded" style="width:50px" id="uploding_image"
                                                             src="{{asset('/public/assets/images/type_vehicle')}}/{{ $type->image }}"
                                                             alt="image">
                                                    @else
                                                        <img class="rounded" style="width:50px" id="uploding_image"
                                                             src="{{asset('assets/images/placeholder_image.jpg')}}"
                                                             alt="image">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row width-50">
                                  						<div class="form-check">
                                  							<input type="checkbox"  class="user_active" id="user_active" name="status" value="Yes" {{ $type->status=='Yes' ? 'checked': '' }} >
                                  							<label class="col-3 control-label" for="user_active">{{trans('lang.active')}}</label>

                                  						</div>
                                  					</div>

                                        </fieldset>
                                        <fieldset>
                                            <legend>Fare</legend>
                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">Day Rate per {{$delivery_distance}}</label>
                                                <div class="col-7">
                                                    @if(!empty($delivery_charges))
                                                        <input type="text" class="form-control"
                                                               value="{{ $delivery_charges->day_charges_per_km }}"
                                                               name="day_charges_per_km">
                                                    @else
                                                        <input type="text" class="form-control" value=""
                                                               name="day_charges_per_km">

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">Flag Day Rate </label>
                                                <div class="col-7">
                                                    @if(!empty($delivery_charges))
                                                        <input type="text" class="form-control"
                                                               value="{{ $delivery_charges->flag_day_rate }}"
                                                               name="flag_day_rate">
                                                    @else
                                                        <input type="text" class="form-control" value=""
                                                               name="flag_day_rate">

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">Overnight ate per {{$delivery_distance}}</label>
                                                <div class="col-7">
                                                    @if(!empty($delivery_charges))
                                                        <input type="text" class="form-control"
                                                               name="overnight_charges_per_km"
                                                               value="{{ $delivery_charges->overnight_charges_per_km }}">
                                                    @else
                                                        <input type="text" class="form-control"
                                                               name="overnight_charges_per_km" value="">

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">Flag Overnight Rate </label>
                                                <div class="col-7">
                                                    @if(!empty($delivery_charges))
                                                        <input type="text" class="form-control"
                                                               value="{{ $delivery_charges->flag_overnight_rate }}"
                                                               name="flag_overnight_rate">
                                                    @else
                                                        <input type="text" class="form-control" value=""
                                                               name="flag_overnight_rate">

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">Peak Rate {{$delivery_distance}}</label>
                                                <div class="col-7">
                                                    @if(!empty($delivery_charges))
                                                        <input type="text" class="form-control"
                                                               name="peak_charges_km"
                                                               value="{{ $delivery_charges->peak_charges_km }}">
                                                    @else
                                                        <input type="text" class="form-control"
                                                               name="peak_charges_km" value="">

                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row width-100">
                                                <label class="col-3 control-label">Flag Peak Rate </label>
                                                <div class="col-7">
                                                    @if(!empty($delivery_charges))
                                                        <input type="text" class="form-control"
                                                               value="{{ $delivery_charges->flag_peak_rate }}"
                                                               name="flag_peak_rate">
                                                    @else
                                                        <input type="text" class="form-control" value=""
                                                               name="flag_peak_rate">

                                                    @endif
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group col-12 text-center btm-btn">
                            <button type="submit" class="btn btn-primary  save_user_btn"><i
                                        class="fa fa-save"></i>{{ trans('lang.save')}}</button>
                            <a href="{{ url('vehicle/index') }}" class="btn btn-default"><i
                                        class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://www.gstatic.com/firebasejs/8.1.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.0/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.1.0/firebase-database.js"></script>
    <script type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".shadow-sm").hide();
        })

        function readURL(input) {
            console.log(input.files);
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image_preview').show();
                    $('#uploding_image').attr('src', e.target.result);


                }

                reader.readAsDataURL(input.files[0]);
            }
        }


    </script>

@endsection

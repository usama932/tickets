@extends('layouts.app')
@section('content')
<div class="page-wrapper">
   <div class="row page-titles">
      <div class="col-md-5 align-self-center">
         <h3 class="text-themecolor">{{trans('lang.driver_edit')}}</h3>
      </div>
      <div class="col-md-7 align-self-center">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href= "{!! route('drivers') !!}" >{{trans('lang.driver_plural')}}</a></li>
            <li class="breadcrumb-item active">{{trans('lang.driver_edit')}}</li>
         </ol>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row daes-top-sec">
         <!-- Column -->
         <!-- Column -->
         <div class="col-lg-4 col-md-6">
            <div class="card">
               <div class="card-body d-flex icon-blue">
                  <div class="card-left">
                     @if ($earnings[0]->montant == "")
                     <h3 class="m-b-0 text-info" id="restaurant_count">0</h3>
                     @else
                     <h3 class="m-b-0 text-info" id="restaurant_count">{{$currency}}{{$earnings[0]->montant}}</h3>
                     @endif
                     <h5 class="text-muted m-b-0">{{trans('lang.dashboard_total_earnings')}}</h5>
                  </div>
                  <div class="card-right ml-auto">
                     <i class="mdi mdi-wallet"></i>
                  </div>
               </div>
            </div>
         </div>
         <!-- Column -->
         <!-- Column -->
         <div class="col-lg-4 col-md-6">
            <div class="card">
               <div class="card-body d-flex icon-blue">
                  <div class="card-left">
                     @if ($earnings[0]->rides == "")
                     <h3 class="m-b-0 text-info">0</h3>
                     @else
                     <h3 class="m-b-0 text-info">{{$earnings[0]->rides}}</h3>
                     @endif
                     <h5 class="text-muted m-b-0">{{trans('lang.completed_rides')}}</h5>
                  </div>
                  <div class="card-right ml-auto">
                     <i class="mdi mdi-car"></i>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-6">
            <div class="card">
               <div class="card-body d-flex icon-blue">
                  <div class="card-left">
                     <h3 class="m-b-0 text-info">{{number_format($avg_rating,1)}}</h3>
                     <h5 class="text-muted m-b-0">{{trans('lang.average_ratings')}}</h5>
                  </div>
                  <div class="card-right ml-auto"><i class="mdi mdi-star"></i></div>
               </div>
            </div>
         </div>
         <!-- Column -->
         <!-- Column -->
      </div>
      <div class="card pb-4">
         <div class="card-body">
            <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}</div>
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
            <form method="post" action="{{ route('driver.update',$driver->id) }}" enctype="multipart/form-data">
               @csrf
               @method("PUT")
               <div class="row restaurant_payout_create">
                  <div class="restaurant_payout_create-inner">
                     <fieldset>
                        <legend>{{trans('lang.driver_edit')}}</legend>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.first_name')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_first_name" name="nom" value="{{$driver->nom}}">
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_first_name_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.last_name')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_last_name" name="prenom" value="{{$driver->prenom}}">
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_last_name_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.email')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_email"  name="email" value="{{$driver->email}}">
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_email_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.user_phone')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_phone" name="phone" value="{{$driver->phone}}">
                              <div class="form-text text-muted w-50">
                                 {{ trans("lang.user_phone_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-100">
                           <label class="col-2 control-label">{{trans('lang.restaurant_image')}}</label>
                           <input type="file" class="col-6" name="photo_path" onchange="readURL(this);">
                           @if (!empty($driver->photo_path))
                           <td><img class="rounded" id="uploding_image" style="width:100px" src="{{asset('assets/images/driver').'/'.$driver->photo_path}}" alt="image"></td>
                           @else
                           <td><img class="rounded" id="uploding_image" style="width:100px" src="{{asset('assets/images/placeholder_image.jpg')}}" alt="image"></td>
                           @endif
                        </div>
                        <div class="form-group row width-100">
                           <div class="form-check">
                              @if ($driver->statut === "yes")
                              <input type="checkbox" class="user_active" name="statut" id="user_active" checked="checked">
                              @else
                              <input type="checkbox" class="user_active" name="statut" id="user_active">
                              @endif
                              <label class="col-3 control-label" for="user_active">{{trans('lang.status')}}</label>
                           </div>
                        </div>
                     </fieldset>
                     <fieldset>
                        <legend>{{trans('lang.vehicle_info')}}</legend>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_type')}}</label>
                           <div class="col-7">
                              <select class="form-control model" name="id_type_vehicule" id="id_type_vehicule">
                                 <option value="">Select Type</option>
                                 @foreach($vehicleType as $value)
                                 <?php if($value->id == $vehicle->id_type_vehicule)
                                    {
                                    $selected = 'Selected';
                                    }
                                    else
                                    {
                                      $selected = '';
                                    }
                                    ?>
                                 <option value="{{ $value->id }}" <?php echo $selected ?>>{{$value->libelle}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_brand')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control address_line1" name="brand_name" value="{{$vehicle->brand_name}}">
                              {{-- <select  class="form-control brand_id" name="brand">
                                 <option value="">Select Brand</option>

                                 @foreach($brand as $value)
                                 <?php if($value->id == $vehicle->brand)
                                    {
                                    $selected = 'Selected';
                                    }
                                    else
                                    {
                                      $selected = '';
                                    }
                                    ?>
                                 <option value="{{ $value->id }}" <?php echo $selected ?>>{{$value->name}}</option>
                                 @endforeach
                              </select> --}}
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_model')}}</label>
                           <div class="col-7">
                               <input type="text" class="form-control user_first_name" name="model_name" value="{{$vehicle->model_name}}">
                                 <!-- var_dump($model); -->
                                 {{-- @foreach($model as $value)
                                 <?php
                                    //print_r($value);
                                    if($value->id == $vehicle->model)
                                    {
                                    $selected = 'Selected';
                                    }
                                    else
                                    {
                                      $selected = '';
                                    }
                                    ?>
                                 <option value="{{ $value->id }}" <?php echo $selected ?>>{{$value->name}}</option>
                                 @endforeach
                              </select> --}}
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_first_name_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                            <label class="col-3 control-label">Car Category</label>
                            <div class="col-7">
                               <input type="text" class="form-control model" name="car_category" value="{{$vehicle->car_category}}">
                               {{-- <select class="form-control model" name="model" id="model">
                               </select> --}}
                               <div class="form-text text-muted">{{trans('lang.car_model_help')}}</div>
                            </div>
                         </div>
                         <div class="form-group row width-50">
                            <label class="col-3 control-label">Car Category Image</label>
                            <div class="col-7">
                               <input type="file" class="form-control model" name="car_image" value="{{Request::old('model')}}">
                               {{-- <select class="form-control model" name="model" id="model">
                               </select> --}}
                               <div class="form-text text-muted">{{trans('lang.car_model_help')}}</div>
                            </div>
                         </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_color')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_last_name" name="color" value="{{$vehicle->color}}">
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_last_name_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_numberplate')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_email"  name="numberplate" value="{{$vehicle->numberplate}}">
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_email_help") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.number_of_pessanger')}}</label>
                           <div class="col-7">
                              <input type="number" class="form-control user_phone" name="passenger" value="{{$vehicle->passenger}}">
                              <div class="form-text text-muted w-50">
                                 {{ trans("lang.user_phone_help") }}
                              </div>
                           </div>
                        </div>
                        {{--
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">Number of Luggage</label>
                           <div class="col-7">
                              <input type="number" class="form-control" name="num_of_luggage"
                                 value="{{$vehicle->num_of_luggage}}">
                              <div class="form-text text-muted w-50">
                                 {{ trans("num_of_luggage") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">Package Weight</label>
                           <div class="col-7">
                              <input type="number" class="form-control" name="package_weight"
                                 value="{{$vehicle->package_weight}}">
                              <div class="form-text text-muted w-50">
                                 {{ trans("package_weight") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">Package Size</label>
                           <div class="col-7">
                              <input type="number" class="form-control" name="package_size"
                                 value="{{$vehicle->package_size}}">
                              <div class="form-text text-muted w-50">
                                 {{ trans("package_size") }}
                              </div>
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">Number of Pets</label>
                           <div class="col-7">
                              <input type="number" class="form-control" name="num_of_pets"
                                 value="{{$vehicle->num_of_pets}}">
                              <div class="form-text text-muted w-50">
                                 {{ trans("num_of_pets") }}
                              </div>
                           </div>
                        </div>
                        --}}
                        {{--
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_milage')}}</label>
                           <div class="col-7">
                              <input type="number" class="form-control user_phone" name="milage" value="{{$vehicle->milage}}">
                              <div class="form-text text-muted w-50">
                              </div>
                           </div>
                        </div>
                        --}}
                        {{--
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.vehicle_km')}}</label>
                           <div class="col-7">
                              <input type="number" class="form-control user_phone" name="km" value="{{$vehicle->km}}">
                              <div class="form-text text-muted w-50">
                              </div>
                           </div>
                        </div>
                        --}}
                        <!-- <div class="form-group row width-100">
                           <label class="col-2 control-label">{{trans('lang.car_image')}}</label>
                           <input type="file" class="col-6" name="image_path" onchange="readCarURL(this);">
                           @if (!empty($vehicleImage) && file_exists('assets/images/vehicle'.'/'.$vehicleImage->image_path) && !empty($vehicleImage->image_path))
                               <td><img class="rounded" id="car_image" style="width:100px" src="{{asset('assets/images/vehicle').'/'.$vehicleImage->image_path}}" alt="image"></td>
                           @else
                               <td><img class="rounded" id="car_image" style="width:100px" src="{{asset('assets/images/placeholder_image.jpg')}}" alt="image"></td>

                           @endif

                           </div> -->
                     </fieldset>
                     <fieldset>
                        <legend>{{trans('lang.driver_bank_details')}}</legend>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.bank_name')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control address_line1" name="bank_name" value="{{$driver->bank_name}}">
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.branch_name')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_first_name" name="branch_name" value="{{$driver->branch_name}}">
                              {{--
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_first_name_help") }}
                              </div>
                              --}}
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.holder_name')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_last_name" name="holder_name" value="{{$driver->holder_name}}">
                              {{--
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_last_name_help") }}
                              </div>
                              --}}
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.account_no')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_email"  name="account_no" value="{{$driver->account_no}}">
                              {{--
                              <div class="form-text text-muted">
                                 {{ trans("lang.user_email_help") }}
                              </div>
                              --}}
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{trans('lang.Other_info')}}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_phone" name="other_info" value="{{$driver->other_info}}">
                              {{--
                              <div class="form-text text-muted w-50">
                                 {{ trans("lang.user_phone_help") }}
                              </div>
                              --}}
                           </div>
                        </div>
                        <div class="form-group row width-50">
                           <label class="col-3 control-label">{{ trans("lang.ifsc_code") }}</label>
                           <div class="col-7">
                              <input type="text" class="form-control user_phone" name="ifsc_code" value="{{$driver->ifsc_code}}">
                           </div>
                        </div>
                     </fieldset>
                  </div>
               </div>
         </div>
         <div class="form-group col-12 text-center btm-btn" >
         <button type="submit" class="btn btn-primary  save_user_btn" ><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
         <a href="{!! route('drivers') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
         </div>
      </div>
      </form>
   </div>
</div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
               $('select[name="brand"]').on('change',function(){

                   var brand_id= $(this).val();
                   var id_type_vehicule = $('select[name="id_type_vehicule"]').val();
                   var url = "{{ route('driver.model',':brandId') }}";
                     url = url.replace(':brandId', brand_id);

                   if (brand_id) {
                    $.ajax({
                       url: url,
                     type: "POST",
                     data: {
                       id_type_vehicule:id_type_vehicule,
                       _token: '{{csrf_token()}}' ,
                     },

                     dataType : 'json',
                     success: function(data){
                       console.log(data);
                       $('select[name="model"]').empty();
                       $.each(data.model,function(key,value){
                         $('select[name="model"]').append('<option value="'+value.id+'">'+value.name+'</option>');
                       });
                     }
                    });
                   }else {
                        $('select[name="model"]').empty();
                  }
              });





             });

             function readURL(input) {
   		console.log(input.files);
           if (input.files && input.files[0]) {
               var reader = new FileReader();

               reader.onload = function (e) {
   			//	$('#image_preview').show();
                   $('#uploding_image').attr('src', e.target.result);


               }

               reader.readAsDataURL(input.files[0]);
           }

         }
   function readCarURL(input) {

       if (input.files && input.files[0]) {
           var reader = new FileReader();

           reader.onload = function (e) {
               //	$('#image_preview').show();
               $('#car_image').attr('src', e.target.result);


           }

           reader.readAsDataURL(input.files[0]);
       }

   }
         function readURLNic(input) {
   		console.log(input.files);
           if (input.files && input.files[0]) {
               var reader = new FileReader();

               reader.onload = function (e) {
   				//$('#placeholder_img_thumb').show();
   				$('#user_nic_image').attr('src', e.target.result);
               }

               reader.readAsDataURL(input.files[0]);
           }
       }


</script>
@endsection

@extends('layouts.app')
@section('content')
<div class="page-wrapper">
   <div class="row page-titles">
      <div class="col-md-5 align-self-center">
         <h3 class="text-themecolor">Ride Setting</h3>
      </div>
      <div class="col-md-7 align-self-center">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
            <li class="breadcrumb-item"><a href= "{{ url('vehicle-rental-type/index') }}" >Ride Setting</a></li>
            <li class="breadcrumb-item active">Create Ride Setting</li>
         </ol>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
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
                  <form action="{{route('ride_setting_save')}}" method="post" enctype="multipart/form-data">
                     @csrf
                     <div class="row restaurant_payout_create">
                        <div class="restaurant_payout_create-inner">
                           <fieldset>
                               
                               <input type="hidden" name="id" value="{{ $setting->id ?? ''}}">
                              <legend>Ride Setting</legend>
                              <div class="form-group row width-50">
                                 <label class="col-3 control-label">Per Token Price</label>
                                 <div class="col-7">
                                    <input type="text" class="form-control"  name="token_price" value='{{ $setting->token_price ?? '1'}}'>
                                    <!-- <div class="form-text text-muted"></div> -->
                                 </div>
                              </div>
                                  <div class="form-group row width-50">
                                     <label class="col-3 control-label">Per Ride Customize Token</label>
                                     <div class="col-7">
                                        <input type="text" class="form-control" name="ride_token"  value='{{ $setting->ride_token ?? '1'}}'>
                                     </div>
                                  </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label"> Pet Fare</label>
                                    <div class="col-7">
                                       <input type="text" class="form-control" name="pet_more" value='{{ $setting->pet_more ?? '1'}}'>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">Coupon Award Token</label>
                                    <div class="col-7">
                                       <input type="text" class="form-control" name="gift_token"  value='{{ $setting->gift_token ?? '0'}}'>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                     </div>
                     <div class="row restaurant_payout_create">
                        <div class="restaurant_payout_create-inner">
                           <fieldset>
                              <legend>Ride Fare Range Tokens</legend>
                              <?php
                              if(isset($setting->fareRange) && !empty($setting->fareRange)):
                                  
                                  foreach($setting->fareRange as $key=>$value):
                              ?>
                              <div class="row" style="align-items:end">
                                <div class="form-group col-md-4">
                                 <label class="control-label">Fare Range From</label>
                                 <input type="text" class="form-control"  name="from_range[]" value="{{$value->from_range ?? 0}}">
                              </div>
                               <div class="form-group col-md-4">
                                 <label class="control-label">Fare Range To</label>
                                 <input type="text" class="form-control"  name="to_range[]" value="{{$value->to_range ?? 0}}">
                              </div>
                               <div class="form-group col-md-2">
                                 <label class="control-label">Tokens</label>
                                 <input type="text" class="form-control"  name="token[]" value="{{$value->token ?? 0}}">
                              </div>
                               <div class="form-group col-md-2">
                                  <button type="button" class="btn btn-primary" onClick="removeRange(this)"><i class="fa fa-trash"></i></button>
                              </div>
                              </div>
                             <?php
                             endforeach;
                             endif; ?>
                              <div class="range-row">
                                  
                              </div>
                              <div class="row" style="align-items:end">
                                  <div class="form-group col-md-2">
                                  <button type="button" class="btn btn-success add-range" ><i class="fa fa-plus"></i> Add Range</button>
                                  </div>
                              </div>
                            </fieldset>
                        </div>
                    </div>
                     <div class="form-group col-12 text-center btm-btn" >
                        <button type="submit" class="btn btn-primary save_user_btn" ><i class="fa fa-save"></i>{{ trans('lang.save')}}</button>
                        <a href="{{ url('vehicle-rental-type/index') }}" class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                     </div>
                </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
@endsection
@section('scripts')
<script>
    $('.add-range').on('click',function(){
        var html = '<div class="row" style="align-items:end">'+
                                '<div class="form-group col-md-4">'+
                                 '<label class="control-label">Fare Range From</label>'+
                                 '<input type="text" class="form-control"  name="from_range[]" value="">'+
                              '</div>'+
                               '<div class="form-group col-md-4">'+
                                 '<label class="control-label">To Range From</label>'+
                                 '<input type="text" class="form-control"  name="to_range[]" value="">'+
                              '</div>'+
                               '<div class="form-group col-md-2">'+
                                 '<label class="control-label">Tokens</label>'+
                                 '<input type="text" class="form-control"  name="token[]" value="">'+
                              '</div>'+
                               '<div class="form-group col-md-2">'+
                                  '<button type="button" class="btn btn-primary" onClick="removeRange(this)" ><i class="fa fa-trash"></i></button>'+
                              '</div>'+
                              '</div>'
            $('.range-row').append(html);
    });
    function removeRange($this){
        $($this).parent().parent().remove();
    }removeRange();
</script>
@endsection

@extends('layouts.app')
@section('content')
<div class="page-wrapper">
<div class="row page-titles">
   <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Send Notification</h3>
   </div>
   <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
         <li class="breadcrumb-item"><a href="#">Send Notification</a>
         </li>
         <li class="breadcrumb-item active">Send Notification</li>
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
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <form action="{{route('send_p_notification')}}" method="post" enctype="multipart/form-data"
               id="create_driver">
               @csrf
               <div class="row restaurant_payout_create">
                  <div class="restaurant_payout_create-inner">
                     <fieldset>
                        <legend>Passenger Notification</legend>
                        <div class="form-group row width-100">
                           <label class="col-3 control-label">Notification Title</label>
                           <div class="col-9">
                            <input  type="text" class="form-control " name="title">
                           </div>
                        </div>
                        <div class="form-group row width-100">
                           <label class="col-3 control-label">Notification Body</label>
                           <div class="col-9">
                            <textarea type="text" class="form-control " name="body"></textarea>

                           </div>
                        </div>


                     </fieldset>

                     <div class="form-group col-12 text-center btm-btn">
                        <button type="submit" class="btn btn-primary save_driver_btn"><i
                           class="fa fa-save"></i> {{ trans('lang.save')}}</button>

                     </div>
            </form>
            </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="page-wrapper">
<div class="row page-titles">
   <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor">Token Edit</h3>
   </div>
   <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
         <li class="breadcrumb-item"><a href="{{  route('tokens.index')  }}">Tokens</a>
         </li>
         <li class="breadcrumb-item active">Token Edit</li>
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
            <form action="{{route('tokens.update',$token->id)}}" method="post" enctype="multipart/form-data"
               id="Edit_driver">
               @csrf
               @method('patch')
               <div class="row restaurant_payout_create">
                  <div class="restaurant_payout_create-inner">
                     <fieldset>
                        <legend>Token Details</legend>
                        <div class="form-group row width-100">
                           <label class="col-3 control-label">Title</label>
                           <div class="col-9">
                              <input type="text" class="form-control " name="title" value={{ $token->title }}
                              required>
                           </div>
                        </div>
                        <div class="form-group row width-100">
                            <label class="col-3 control-label">Token Upto</label>
                            <div class="col-9">
                               <input type="number" class="form-control " name="up_to" value={{ $token->up_to }}
                               required>
                            </div>
                         </div>
                         <div class="form-group row width-100">
                            <label class="col-3 control-label">Amount $</label>
                            <div class="col-9">
                               <input type="number" class="form-control " name="amount" value={{ $token->amount }}
                               required>
                            </div>
                         </div>
                         <div class="form-group row width-100">
                            <label class="col-3 control-label">Expiry Date</label>
                            <div class="col-9">
                               <input type="date" class="form-control " name="expiry_date" value={{ $token->expiry_date }}
                                 required>
                            </div>
                         </div>

                     </fieldset>

                     <div class="form-group col-12 text-center btm-btn">
                        <button type="submit" class="btn btn-primary save_driver_btn"><i
                           class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                        <a href="{!! route('tokens.index') !!}" class="btn btn-default"><i
                           class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                     </div>
            </form>
            </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

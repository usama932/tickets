@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="row page-titles">

            <div class="col-md-5 align-self-center">

                <h3 class="text-themecolor"> Driver Tokens</h3>

            </div>

            <div class="col-md-7 align-self-center">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a>
                    </li>

                    <li class="breadcrumb-item active">
                     Token
                    </li>

                </ol>

            </div>

            <div>

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
                         <form action="{{route('tokens.store')}}" method="post" enctype="multipart/form-data"
                            id="create_driver">
                            @csrf
                            <div class="row restaurant_payout_create">
                               <div class="restaurant_payout_create-inner">
                                  <fieldset>
                                     <legend>Token Details</legend>
                                     <div class="form-group row width-100">
                                        <label class="col-3 control-label">Drivers</label>
                                        <div class="col-9">

                                           <select   class="form-control" name="user_id">
                                            <option class="form-control" value="" >--! Select Driver !--</option>
                                            @foreach ($drivers as $driver)
                                                <option class="form-control " value="{{ $driver->id }}" >{{ $driver->nom }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group row width-100">
                                            <label class="col-3 control-label">Tokens</label>
                                            <div class="col-9">

                                            <input type="number" class="form-control " name="tokens" required>

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
            <div class="row">

                <div class="col-12">

                    <div class="card">



                        <div class="card-body">

                            <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                 style="display: none;">
                                {{trans('lang.processing')}}
                            </div>

                            <div class="userlist-topsearch d-flex mb-3">

                                {{--  <div class="userlist-top-left">
                                    <a class="nav-link" href="{!! route('tokens.create') !!}"><i
                                            class="fa fa-plus mr-2"></i>Token Create</a>
                                </div>  --}}


                            </div>

                            <div class="table-responsive m-t-10">

                                <table id="example24"
                                       class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>

                                        <th>Driver</th>
                                        <th>Tokens</th>


                                    </tr>
                                    </thead>
                                    <tbody id="append_list12">
                                    @if(!empty($tokens) )
                                        @foreach($tokens as $token)

                                        <tr>

                                            <td>
                                                @php
                                                    $driver = App\Models\Driver::where('id',$token->user_id)->first();
                                                    echo $driver->nom ?? '';
                                                @endphp </td>
                                            <td>{{  $token->tokens }}</td>


                                        </tr>

                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" align="center">{{trans("lang.no_result")}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>



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



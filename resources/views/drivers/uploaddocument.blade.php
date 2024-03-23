@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.upload_doc')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    <li class="breadcrumb-item"><a
                                href="javascript: history.go(-1)">{{trans('lang.document_details')}}</a></li>
                    <li class="breadcrumb-item active">{{trans('lang.upload_doc')}}</li>
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
                                

                            <form action="{{route('driver.updatedocument',['id' => $id])}}" method="post"
                                  enctype="multipart/form-data" id="create_driver">
                                @csrf
                                @method("PUT")
                                <div class="row restaurant_payout_create">
                                    <div class="restaurant_payout_create-inner">
                                        <fieldset>
                                            
                                            <legend>{{trans('lang.document_details')}}</legend>
                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">{{trans('lang.category_name')}}</label>
                                                <div class="col-7">

                                                    <select name="document_id" class="form-control" disabled>
                                                        @foreach($document as $doc)
                                                            <option {{$doc->id == $document_id ? 'selected' : '' }}  value="{{$doc->id}}">{{$doc->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="document_id" value="{{$document_id}}">
                                                </div>
                                            </div>
                                            <div class="form-group row width-50">
                                                <label class="col-3 control-label">Expiry Date</label>

                                            <div class="col-12">
                                                <input type="date" name="document_expiry" class="form-control" >
                                              
                                            </div>

                                        </div>

                                            <div class="form-group row width-50">
                                                    <label class="col-3 control-label">{{trans('lang.upload_doc')}}</label>

                                                <div class="col-12">
                                                    <input type="file" class="" name="document_path" >
                                                    <a href="#" data-toggle="modal" data-target="#exampleModal_{{$dr_document->id}}" class="open-image" title="View Document"><i class="imageresource fas fa fa-file-image-o"></i>View</a>
                                                    <div class="modal fade" id="exampleModal_{{$dr_document->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document" style="max-width: 50%;">
                                                            <div class="modal-content">
                        
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                        
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <embed
                                                                            src="{{asset('assets/images/driver/documents').'/'.$dr_document->document_path}}"
                                                                            frameBorder="0"
                                                                            scrolling="auto"
                                                                            height="100%"
                                                                            width="100%"
                                                                            style="height: 540px;"
                                                                        ></embed>
                                                                    </div>
                        
                                                                    <div class="modal-footer">
                                                                        <a class="btn btn-primary" href="{{asset('assets/images/driver/documents').'/'.$dr_document->document_path}}">Download</a>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('lang.close')}}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </fieldset>

                                    </div>
                                </div>
                        </div>

                        <div class="form-group col-12 text-center btm-btn">
                            <button type="submit" class="btn btn-primary save_driver_btn"><i
                                        class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                            <a href="{!! route('driver.documentView',['id' => $id]) !!}"
                               class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



@endsection

@section('scripts')

@endsection
@extends('layouts.app')

@section('content')
<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.administration_tools_tax')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.administration_tools')}}</li>
                <li class="breadcrumb-item active">{{trans('lang.administration_tools_tax')}}</li>
            </ol>
        </div>

    </div>


    <div class="container-fluid">
        @foreach($Tax as $tax)

        <form action="{{ route('tax.update',$tax->id) }}" method="post" enctype="multipart/form-data"
              id="create_driver">
            @csrf
            @method("PUT")
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="row restaurant_payout_create">
                                <div class="restaurant_payout_create-inner">
                                    <fieldset>

                                        <legend>{{trans('lang.administration_tools_tax')}}</legend>

                                        <div class="form-check width-100">

                                            @if($tax->statut == 'yes')
                                            <input type="checkbox" class="form-check-inline" name="enabled" id="enabled" checked>
                                            @else
                                            <input type="checkbox" class="form-check-inline" name="enabled" id="enabled">
                                            @endif

                                            <label class="col-5 control-label" for="enabled">{{
                                                trans('lang.is_enabled')}}</label>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="col-4 control-label">{{ trans('lang.label')}}</label>
                                            <div class="col-7">
                                                <input type="text" class="form-control vat_label" name="name"
                                                       value="{{$tax->libelle}}">
                                            </div>
                                        </div>
                                        <div class="form-group row width-50">
                                            <label class="col-4 control-label">{{ trans('lang.tax_table')}}</label>
                                            <div class="col-7">
                                                <input type="number" class="form-control vat_tax" name="value"
                                                       value="{{$tax->value}}">
                                            </div>
                                        </div>
                                        <div class="form-group row width-50">

                                            <label class="col-4 control-label">{{ trans('lang.type')}}</label>
                                            <div class="col-7">
                                                <select class="form-control commission_type" name="type">

                                                    @if($tax->type == 'Percentage')
                                                    <option value="Percentage" selected>Percentage</option>
                                                    <option value="Fixed">Fixed</option>
                                                    @else
                                                    <option value="Percentage">Percentage</option>
                                                    <option value="Fixed" selected>Fixed</option>
                                                    @endif

                                                </select>
                                            </div>

                                        </div>
                                        @endforeach
                                    </fieldset>
                                </div>

                            </div>


                        </div>

                    </div>

                </div>

            </div>

            <div class="form-group col-12 text-center btm-btn" >
                <button type="submit" class="btn btn-primary  create_user_btn" ><i class="fa fa-save"></i> {{ trans('lang.save')}}</button>
                <a href="{{ url('/home') }}" class="btn btn-default"><i class="fa fa-undo"></i>{{ trans('lang.cancel')}}</a>
            </div>

        </form>
    </div>

</div>


@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function () {
        $(".shadow-sm").hide();
    })

    /* toggal publish action code start*/
    $(document).on("click", "input[name='publish']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '../tax/switch',
            method: "POST",
            data: {'ischeck': ischeck, 'id': id},
            success: function (data) {

            },
        });

    });

    /*toggal publish action code end*/

</script>

@endsection

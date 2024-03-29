@extends('layouts.app')

@section('content')
<div class="page-wrapper">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">{{trans('lang.terms_and_conditions')}}</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a>
				</li>
				<li class="breadcrumb-item active">
					{{trans('lang.administration_tools')}}
				</li>
				<li class="breadcrumb-item active">
					{{trans('lang.terms_and_conditions')}}
				</li>
			</ol>
		</div>

	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card pb-4">
					<div class="card-body">

						<div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
							{{trans('lang.processing')}}
						</div>
						<div class="error_top"></div>

						<div class="row restaurant_payout_create term-cond" >
							<div class="restaurant_payout_create-inner">
								@foreach($termconditions as $terms)
								<fieldset>
									<legend>
										{{trans('lang.terms_and_conditions')}}
									</legend>
									<div class="form-group row">
										<div class="col-12 p-0">
											<input type="hidden" name="id" id="id" value="{{$terms->id}}">
											<textarea class="form-control col-7" name="terms_and_conditions" id="terms_and_conditions">{{$terms->terms}}</textarea>											


										</div>
									</div>

								</fieldset>

								<!-- <fieldset>
								<legend>{{trans('lang.status')}}</legend>
								<div class="form-group row">
								<div class="form-check">

								@if ($terms->statut === "true")
								<input type="checkbox" class="user_active" name="statut" id="user_active" checked="checked"/>
								@else
								<input type="checkbox" class="user_active" name="statut" id="user_active">
								@endif
								<label class="col-3 control-label" for="user_active">{{trans('lang.active')}}</label>
								</div>
								</div>
								</div>

								</fieldset> -->
								@endforeach
							</div>
						</div>
						<div class="form-group col-12 text-center btm-btn text-center" >
							<button type="submit" class="btn btn-primary  save_user_btn" >
								<i class="fa fa-save"></i> {{ trans('lang.save')}}
							</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

</div>
@endsection
@section('scripts')
<script type="text/javascript">
	
	$('#terms_and_conditions').summernote({
		height : 400,
		toolbar : [
		// [groupName, [list of button]]
		['style', ['bold', 'italic', 'underline', 'clear']], ['font', ['strikethrough', 'superscript', 'subscript']], ['fontsize', ['fontsize']], ['color', ['color']], ['forecolor', ['forecolor']], ['backcolor', ['backcolor']], ['para', ['ul', 'ol', 'paragraph']], ['height', ['height']]]
	});
	
	$(".save_user_btn").click(function() {

		var terms_and_conditions = $('#terms_and_conditions').summernote('code');
		var id = $('#id').val();
		var status = $(".user_active").is(":checked");

		var url = "{{ route('terms_condition.update',':id') }}";
		url = url.replace(':id', id);

		if (terms_and_conditions == '') {
			$(".error_top").show();
			$(".error_top").html("");
			$(".error_top").append("<p>{{trans('lang.user_firstname_error')}}</p>");
			window.scrollTo(0, 0);

		} else {

			$.ajax({
				url : url,
				type : 'PUT',
				headers : {
					'X-CSRF-Token' : '{{ csrf_token() }}',
				},
				//dataType: "json",
				data : {
					terms_condition : terms_and_conditions,
					status : status,
				},

				success : function(response) {

					window.location.reload();
				},
				error : function(response) {
					
				},
			});

		}
	})
</script>

@endsection

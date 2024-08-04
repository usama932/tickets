 @include('header')
<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<br>
						<br>
						<br>

						@if(session('success'))
											    <div class="alert alert-success">{{ session('success') }}</div>
								@endif
								<div class="card-body">
									@if(session('error'))
											    <div class="alert alert-danger">{{ session('error') }}</div>
								@endif
							
						
						
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container">
								<!--begin::Layout-->
								<div class="d-flex flex-column flex-lg-row">
									<!--begin::Content-->
									<div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
										<!--begin::Form-->
										
											<!--begin::Customer-->
											<div class="card card-flush pt-3 mb-5 mb-lg-10">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2 class="fw-bolder m-auto">Create a New Packages</h2>
													</div>
													<!--begin::Card title-->
												</div>
												<!--end::Card header-->
						<!--begin::Form-->

						<form class="form w-50 m-auto" action="{{url('/packages') }}" method="POST">
							@csrf
							
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Package Name</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="name" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Package Price</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="price" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Level 1 Commission </label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="level1_commission" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Level 2 Commission </label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="level2_commission" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Package Description</label>
								<!--end::Label-->
								<!--begin::Input-->
								<textarea name="description" class="form-control mb-3 form-control-solid"></textarea>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							 
							
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<input type="submit" class="btn btn-lg btn-primary w-100 mb-5" />
								<!--end::Submit button-->
							
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
											</div>
											<!--end::Customer-->
											@foreach($packages as $package)
											<!--begin::Pricing-->
											<div class="card card-flush pt-3 mb-5 mb-lg-10">
												<!--begin::Card header-->
												<div class="card-header">
													<!--begin::Card title-->
													<div class="card-title">
														<h2 class="fw-bolder">{{$package->name}}/</h2>
														<span class="text-muted fw-bold fs-7">{{$package->price}}</span>
													</div>

													<!--begin::Card title-->
													<!--begin::Card toolbar-->
													<div class="card-toolbar">
														<button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_product_{{$package->id}}">Add Feature</button>
													</div>

													<!--end::Card toolbar-->
												</div>
												<!--end::Card header-->

												<!--begin::Card body-->
												<div class="card-body pt-0">
													<!--begin::Table wrapper-->
													<div class="table-responsive">
														<!--begin::Table-->
														<table class="table align-middle table-row-dashed fs-6 fw-bold gy-4" id="kt_subscription_products_table">
															<!--begin::Table head-->
															<thead>
																<tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
																	<th class="min-w-100">Feature's</th>
																	
																	
																	<th class="min-w-70px text-end">Remove</th>
																</tr>
															</thead>
															<!--end::Table head-->
															<!--begin::Table body-->
															<tbody class="text-gray-600">
																<tr>
																	<td>Feature</td>
																	
																	<td class="text-end">
																		<!--begin::Delete-->
																		<a href="#" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="tooltip" title="Delete" data-kt-action="product_remove">
																			<!--begin::Svg Icon | path: icons/duotone/General/Trash.svg-->
																			<span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																						<rect x="0" y="0" width="24" height="24" />
																						<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
																						<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
																					</g>
																				</svg>
																			</span>
																			<!--end::Svg Icon-->
																		</a>
																		<!--end::Delete-->
																	</td>
																</tr>
																
																
															</tbody>
															<!--end::Table body-->
														</table>
														<!--end::Table-->
														<span class="text-muted fw-bold fs-7">{{$package->description}}</span>
													</div>
													<!--end::Table wrapper-->
												</div>
												<!--end::Card body-->
											</div>
											<!--end::Pricing-->
											@endforeach
									</div>
									<!--end::Content-->
									
								</div>
								<!--end::Layout-->
								<!--begin::Modals-->
								@foreach($packages as $package)
							<!--begin::Modal - New Product-->
								<div class="modal fade" id="kt_modal_add_product_{{$package->id}}" tabindex="-1" aria-hidden="true">
									<!--begin::Modal dialog-->
									<div class="modal-dialog modal-dialog-centered mw-650px">
										<!--begin::Modal content-->
										<div class="modal-content">
											
											
												<!--begin::Modal header-->
												<div class="modal-header">
													<!--begin::Modal title-->
													<h2 class="fw-bolder">Add a Features in {{$package->name}}</h2>
													<!--end::Modal title-->
													<!--begin::Close-->
													<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
														<span class="svg-icon svg-icon-1">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
																	<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
																	<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon-->
													</div>
													<!--end::Close-->
												</div>
												<!--end::Modal header-->
												<!--begin::Modal body-->
												<div class="modal-body py-10 px-lg-17">
													<!--begin::Form-->

						<form class="form w-100 m-auto" action="{{url('/feature', $package->id) }}" method="POST">
							@csrf
							
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Feature Name</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="title" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<input type="hidden" name="package_id" value="{{$package->id}}">
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Status</label>
								<!--end::Label-->
								<!--begin::Input-->
								<select name="status" class="form-control form-control-lg form-control-solid" aria-label="Select example">
								    <option value="active">Active</option>
								    <option value="inactive">Inactive</option>
								</select>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<input type="submit" class="btn btn-lg btn-primary w-100 mb-5" />
								<!--end::Submit button-->
							
							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
												</div>
												<!--end::Modal body-->
										</div>
									</div>
								</div>
								<!--end::Modal - New Product-->
								@endforeach
								
								<!--end::Modals-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					<!--end::Content-->
					
@include('footer')
 @include('header')
<!--begin::Content-->
<br><br><br>
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container" class="container">
                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body p-0">
                                        <!--begin::Heading-->
                                        <div class="card-px text-center py-20 my-10">
                                            <!--begin::Title-->
                                            <h2 class="fs-2x fw-bolder mb-10">Upload Your Products</h2>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <p class="text-gray-500 fs-5 fw-bold mb-13">Click on the below buttons to launch
                                            <br />a new target example.</p>
                                            <!--end::Description-->
                                            <!--begin::Action-->
                                            <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">Upload Products</a>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Illustration-->
                                        <div class="text-center px-5">
                                            <img src="assets/media/illustrations/statistics.png" alt="" class="mw-100 mh-300px" />
                                        </div>
                                        <!--end::Illustration-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Modal - New Target-->
                                <div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                    <div class="modal-dialog modal-dialog-centered mw-650px">
                                        <!--begin::Modal content-->
                                        <div class="modal-content rounded">
                                            <!--begin::Modal header-->
                                            <div class="modal-header pb-0 border-0 justify-content-end">
                                                <!--begin::Close-->
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
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
                                            <!--begin::Modal header-->
                                            <!--begin::Modal body-->
                                            <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                                <!--begin:Form-->
                                                <form id="productForm" action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <!--begin::Heading-->
                                                    <div class="mb-13 text-center">
                                                        <!--begin::Title-->
                                                        <h1 class="mb-3">Upload Product</h1>
                                                        <!--end::Title-->
                                                        <!--begin::Description-->
                                                        <div class="text-muted fw-bold fs-5"><li> Please note that you should have 40 tokens to upload product</li>
                                                            <li> Please note that your subscription status should be 4 or above to upload product </li>
                                                        {{-- <a href="#" class="fw-bolder link-primary">Project Guidelines</a>.</div> --}}
                                                        <!--end::Description-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Input group-->
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <!--begin::Label-->
                                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                            <span class="">Product Name</span>
                                                            {{-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i> --}}
                                                        </label>
                                                        <!--end::Label-->
                                                        <input type="text" class="form-control form-control-solid" placeholder="Enter Product Name" name="product_name" />
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="row g-9 mb-8">
                                                        <!--begin::Col-->
                                                      
                                                        <!--end::Col-->
                                                        <!--begin::Col-->
                                                        <div class="col-md-6 fv-row">
                                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">Product Price</label>
                                                            <input type="text" class="form-control form-control-solid" placeholder="Enter Product price" name="product_price" />
                                                           
                                                            <!--begin::Input-->
                                                           
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">Color</label>
                                                            <input type="text" class="form-control form-control-solid" placeholder="Enter The Color Of Product" />
                                                           
                                                            <!--begin::Input-->
                                                           
                                                            <!--end::Input-->
                                                        </div>

                                                        <div class="col-md-6 fv-row">
                                                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">Category</label>
                                                            <input type="text" class="form-control form-control-solid" placeholder="Enter The Color Of Product" />
                                                           
                                                            <!--begin::Input-->
                                                           
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Col-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="d-flex flex-column mb-8">
                                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">Product Details</label>
                                                        <textarea class="form-control form-control-solid" rows="3" name="product_description" placeholder="Type Product Details"></textarea>
                                                      
                                                    </div>
                                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                        <span class="">Delivery Time</span>
                                                        {{-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference"></i> --}}
                                                    </label>
                                                    <input type="date" class="form-control form-control-solid" placeholder="Enter Product Name"  />
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                    <div class="d-flex flex-column mb-8 fv-row">
                                                        <!--begin::Label-->
                                                        <b><label class="d-flex align-items-center">
                                                           Upload Product Image 
                                                        </label>
                                                        <input type="file" class="form-control form-control-solid" name="product_image" />
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Input group-->
                                                    <!--begin::Input group-->
                                                   
                                                    <!--end::Input group-->
                                                    <!--begin::Actions-->
                                                    <div class="text-center">
                                                        <button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">Cancel</button>
                                                        <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                                            <span class="indicator-label">Submit</span>
                                                            <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                    </div>
                                                    <!--end::Actions-->
                                                </form>
                                                <!--end:Form-->
                                            </div>
                                            <!--end::Modal body-->
                                        </div>
                                        <!--end::Modal content-->
                                    </div>
                                    <!--end::Modal dialog-->
                                </div>
                                <!--end::Modal - New Target-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Post-->
                    </div>
                    <!--end::Content-->
 @include('footer')
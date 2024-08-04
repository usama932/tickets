<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Profile Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body p-9">
        <!--begin::Row-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Full Name</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $user->name }}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

        <!--begin::Input group-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Contact Phone
                <i class="fas fa-exclamation-circle ms-1 fs-7" data-toggle="tooltip" title="Phone number must be active"></i>
            </label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8 d-flex align-items-center">
                <span class="fw-bolder fs-6 text-gray-800 me-2">{{ $user->phone }}</span>
                <!--<span class="badge badge-success">Verified</span>-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="row mb-10">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Referral Code</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">{{ $user->referral_code }}</span>
            </div>
            <!--end::Col-->
        </div>
        
        <!--begin::Input group-->
        <div class="row mb-10">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Package Rank</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bold fs-6 text-gray-800">Rank {{ $user->subscription_status }}</span>
            </div>
            <!--end::Col-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Card body-->
</div>

<div class="col-xl-12">
    <!--begin::Tables Widget 9-->
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Deposit Statements</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th class="min-w-150px">Authors</th>
                            <th class="min-w-100px">Amount</th>
                            <th class="min-w-120px">Payment Method</th>
                            <th class="min-w-120px">Transaction No</th>
                            <th class="min-w-100px">Status</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->

                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($deposit_statement as $deposit_state)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="assets/media/{{ $user->photo }}" alt="" />
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                                {{ $user->name }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted fw-bold d-block fs-7">
                                        {{ $deposit_state->amount }}.00
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted fw-bold d-block fs-7">
                                        {{ $deposit_state->payment_method }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted fw-bold d-block fs-7">
                                        {{ $deposit_state->transaction_number }}
                                    </span>
                                </td>
                                <td>
                                    <span style="text-transform: capitalize;" class="text-muted fw-bold d-block fs-7">
                                        {{ $deposit_state->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>

<div class="col-xl-12">
    <!--begin::Tables Widget 9-->
    <div class="card card-xl-stretch mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">Withdrawal Statements</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bolder text-muted">
                            <th class="min-w-150px">Authors</th>
                            <th class="min-w-100px">Amount</th>
                            <th class="min-w-120px">Payment Method</th>
                            <th class="min-w-120px">Transaction No</th>
                            <th class="min-w-100px">Status</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->

                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($withdrawal_statement as $withdrawal_state)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px me-5">
                                            <img src="assets/media/{{ $user->photo }}" alt="" />
                                        </div>
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">
                                                {{ $user->name }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted fw-bold d-block fs-7">
                                        {{ $withdrawal_state->amount }}.00
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted fw-bold d-block fs-7">
                                        {{ $withdrawal_state->payment_method }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted fw-bold d-block fs-7">
                                        {{ $withdrawal_state->account_number }}
                                    </span>
                                </td>
                                <td>
                                    <span style="text-transform: capitalize;" class="text-muted fw-bold d-block fs-7">
                                        {{ $withdrawal_state->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Tables Widget 9-->
</div>
@include('header');

<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
    <!--begin::Card header-->
    <div class="card-header cursor-pointer">
        <!--begin::Card title-->
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Team Details</h3>
        </div>
        <!--end::Card title-->
    </div>
    <!--begin::Card header-->
    <!--begin::Card body-->
    <div class="card-body p-9">
        <!--begin::Row-->
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Team Leader</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                @if ($teamLeader)
                <span class="fw-bolder fs-6 text-gray-800">{{ $teamLeader->name }}</span>
                @else
                <h3>No Team Leader Found</h3>
@endif
            </div>
            <!--end::Col-->
        </div>
        @foreach ($teamMembers as $member)
        <div class="row mb-7">
            <!--begin::Label-->
            <label class="col-lg-4 fw-bold text-muted">Member</label>
            <!--end::Label-->
            <!--begin::Col-->
            <div class="col-lg-8">
                <span class="fw-bolder fs-6 text-gray-800">{{ $member->name }}</span>
            </div>
            <!--end::Col-->
        </div>
        @endforeach
    </div>
</div>

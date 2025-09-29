@extends('admin.dashboard')
@section('admin')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between flex-wrap gap g-2">
                <div class="nk-block-head-content">
                    <h2 class="display-6">All Plans</h2>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools">
                        <li><a class="btn btn-primary" href="{{ route('admin.plans.add') }}"><em class="icon ni ni-plus"></em><span>Add Plan</span></a></li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-page-head -->

        <div class="d-flex align-items-center justify-content-between border-bottom border-light mt-5 mb-4 pb-2">
            <h5>Billing History</h5>
        </div>
        <div class="card">
            <table class="table table-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="tb-col">
                            <div class="fs-13px text-base">sl</div>
                        </th>
                        <th class="tb-col tb-col-md">
                            <div class="fs-13px text-base">Name</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Monthly Word Limit</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Price</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Templates</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Actions</div>
                        </th>
                        <th class="tb-col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $key => $plan)
                    <tr>
                        <td class="tb-col">
                            <div class="caption-text">{{ $key + 1}} <div class="d-sm-none dot bg-success"></div>
                            </div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <div class="fs-6 text-light d-inline-flex flex-wrap gap gx-2">{{ $plan->name }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="fs-6 text-light">{{ $plan->monthly_word_limit }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="badge text-bg-success-soft rounded-pill px-2 py-1 fs-6 lh-sm">${{ $plan->price }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="badge text-bg-success-soft rounded-pill px-2 py-1 fs-6 lh-sm">{{ $plan->template }}</div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <a href="{{ route('admin.plans.delete', $plan->id) }}" id="delete" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
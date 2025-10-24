@extends('admin.dashboard')
@section('admin')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between flex-wrap gap g-2">
                <div class="nk-block-head-content">
                    <h2 class="display-6">All Orders</h2>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools">
                        <li><a class="btn btn-primary" href="{{ route('admin.plans.add') }}"><em class="icon ni ni-plus"></em><span>Add Plan</span></a></li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-page-head -->

        <div class="d-flex align-items-center justify-content-between border-bottom border-light mt-5 mb-4 pb-2">
            <h5>All Orders</h5>
        </div>
        <div class="card">
            <table class="table table-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="tb-col">
                            <div class="fs-13px text-base">sl</div>
                        </th>
                        <th class="tb-col tb-col-md">
                            <div class="fs-13px text-base">User</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Plan</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Date</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Price</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Status</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Actions</div>
                        </th>
                        <th class="tb-col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($billingHistories as $key => $billing)
                    <tr>
                        <td class="tb-col">
                            <div class="caption-text">{{ $key + 1}} <div class="d-sm-none dot bg-success"></div>
                            </div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <div class="fs-6 text-light d-inline-flex flex-wrap gap gx-2">{{ $billing->user->name }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="fs-6 text-light">{{ $billing->plan->name }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="badge text-bg-success-soft rounded-pill px-2 py-1 fs-6 lh-sm">${{ \Carbon\Carbon::parse($billing->payment_date)->format('Y-m-d') }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="badge text-bg-success-soft rounded-pill px-2 py-1 fs-6 lh-sm">{{ number_format($billing->total, 2) }}</div>
                        </td>
                            @php
                                switch ($billing->status) {
                                    case 'Paid':
                                        $bgClass = 'text-bg-success-soft';
                                    break;
                                    case 'Pending':
                                        $bgClass = 'text-bg-info-soft';
                                    break;
                                    case 'Failed':
                                        $bgClass = 'text-bg-warning-soft';
                                    break;
                                }
                            @endphp

                        <td class="tb-col tb-col-sm">
                             <div class="badge {{$bgClass}} rounded-pill px-2 py-1 fs-6 lh-sm">{{ $billing->status }}</div>
                        </td>
                        <td class="tb-col tb-col-md">
                            @if ($billing->status == 'Pending')
                                <a href="{{ route('update.order.status', $billing->id) }}" class="btn btn-success btn-sm">Update</a>
                            @else
                                <span class="badge text-bg-secondary-soft px-2 py-1 fs-6 1h-sm">No action needed.</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
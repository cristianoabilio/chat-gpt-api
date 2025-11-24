@extends('admin.dashboard')
@section('admin')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between flex-wrap gap g-2">
                <div class="nk-block-head-content">
                    <h2 class="display-6">All Contacts</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->

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
                            <div class="fs-13px text-base">Email</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Price</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Subject</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Actions</div>
                        </th>
                        <th class="tb-col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $key => $contact)
                    <tr>
                        <td class="tb-col">
                            <div class="caption-text">{{ $key + 1}} <div class="d-sm-none dot bg-success"></div>
                            </div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <div class="fs-6 text-light d-inline-flex flex-wrap gap gx-2">{{ $contact->name }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="fs-6 text-light">{{ $contact->email }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="badge text-bg-success-soft rounded-pill px-2 py-1 fs-6 lh-sm">{{ $contact->subject }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="badge text-bg-success-soft rounded-pill px-2 py-1 fs-6 lh-sm">{{ $contact->message }}</div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <a href="{{ route('admin.contact.delete', $contact->id) }}" id="delete" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
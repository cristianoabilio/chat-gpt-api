@extends('admin.dashboard')
@section('admin')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between flex-wrap gap g-2">
                <div class="nk-block-head-content">
                    <h2 class="display-6">All Questions</h2>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools">
                        <li><a class="btn btn-primary" href="{{ route('add.questions') }}"><em class="icon ni ni-plus"></em><span>Add Question</span></a></li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-page-head -->

        <div class="d-flex align-items-center justify-content-between border-bottom border-light mt-5 mb-4 pb-2">
            <h5>Headings</h5>
        </div>
        <div class="card">
            <table class="table table-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="tb-col">
                            <div class="fs-13px text-base">sl</div>
                        </th>
                        <th class="tb-col tb-col-md">
                            <div class="fs-13px text-base">Title</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Description</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Actions</div>
                        </th>
                        <th class="tb-col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $key => $question)
                    <tr>
                        <td class="tb-col">
                            <div class="caption-text">{{ $key + 1}} <div class="d-sm-none dot bg-success"></div>
                            </div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <div class="fs-6 text-light d-inline-flex flex-wrap gap gx-2">{{ $question->title }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="fs-6 text-light">{!! Str::limit($question->description, 50, '...') !!}</div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <a href="{{ route('edit.questions', $question->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <a href="{{ route('delete.questions', $question->id) }}" id="delete" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
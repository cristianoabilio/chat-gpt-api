@extends('admin.dashboard')
@section('admin')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Generated Audios</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->

        <div class="d-flex align-items-center justify-content-between border-bottom border-light mt-5 mb-4 pb-2">
            <h5>Generated Audios</h5>
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
                            <div class="fs-13px text-base">Prompt</div>
                        </th>
                        <th class="tb-col tb-col-sm">
                            <div class="fs-13px text-base">Audio</div>
                        </th>
                        <th class="tb-col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audios as $key => $audio)
                    <tr>
                        <td class="tb-col">
                            <div class="caption-text">{{ $key + 1}} <div class="d-sm-none dot bg-success"></div>
                            </div>
                        </td>
                        <td class="tb-col tb-col-md">
                            <div class="fs-6 text-light d-inline-flex flex-wrap gap gx-2">{{ $audio->user->name }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <div class="fs-6 text-light">{{ $audio->prompt }}</div>
                        </td>
                        <td class="tb-col tb-col-sm">
                            <audio controls>
                                <source src="{{ asset($audio->audio_path) }}" type="audio/mpeg" />
                            </audio>
                            <a href="{{ asset($audio->audio_path) }}" download class="btn btn-sm btn-success mt-2"> Download MP3 </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
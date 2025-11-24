@extends('admin.dashboard')
@section('admin')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Generate Image</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <div class="nk-block">
            <div class="card shadown-none">
                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        @foreach ($images as $image)
                        <div class="col-md-8">
                            <div class="card">
                                <img src="{{ asset($image->image_path) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Prompt Code</h5>
                                    <p class="card-text">{{ $image->prompt }}</p>
                                </div>
                            </div>
                        </div><!-- .col -->
                        @endforeach
                    </div><!-- .row -->
                </div><!-- .card-body -->
            </div>
        </div>
    </div>
</div>
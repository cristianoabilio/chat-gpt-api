@extends('admin.dashboard')
@section('admin')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Slider</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <form action="{{ route('update.slider') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{ $slider->id }}" >
        <div class="nk-block">
            <div class="card shadown-none">

                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="form-label">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title', $slider->title) }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{old('description', $slider->description)}}">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link" class="form-label">Link</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{old('link', $slider->link)}}">
                                    @error('link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image" class="form-label">Image</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{old('image')}}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image" class="form-label">Image</label>
                                <div class="form-control-wrap">
                                    <img id="showImage" src="{{ asset($slider->image) }}" class="rounded-circle avatar-xl img-thumbnail float-starts" width="100px" height="100px">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-xl-12">
                            <button type="submit" class="btn btn-secondary">Save Changes</button>
                        </div>

                    </div>
                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
        </form>
    </div>
</div>
@endsection
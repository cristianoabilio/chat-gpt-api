@extends('admin.dashboard')
@section('admin')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Add Plans</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <form action="{{ route('admin.plans.store') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="nk-block">
            <div class="card shadown-none">

                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Plan Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="monthly_word_limit" class="form-label">Monthly Word Limit</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('monthly_word_limit') is-invalid @enderror" id="monthly_word_limit" name="monthly_word_limit" value="{{old('monthly_word_limit')}}">
                                    @error('monthly_word_limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-label">Price</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{old('price')}}">
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="template" class="form-label">Template</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('template') is-invalid @enderror" id="template" name="template" value="{{old('template')}}">
                                    @error('template')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
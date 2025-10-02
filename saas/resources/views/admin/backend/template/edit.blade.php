@extends('admin.dashboard')
@section('admin')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Add Template</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <form action="{{ route('admin.template.update', $template->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="id" value="{{ $template->id }}" />

        <div class="nk-block">
            <div class="card shadown-none">

                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Template Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="name" name="title" value="{{old('title', $template->title) }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description" class="form-label">Template Description</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{old('description', $template->description)}}">
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category" class="form-label">Template Category</label>
                                <div class="form-control-wrap">
                                    <select class="form-select @error('category') is-invalid @enderror" id="category"  name="category" aria-label="Default select example">
                                        <option selected="">Select Category</option>
                                        <option value="Ads" {{ $template->category == 'Ads' ? 'selected' : '' }}>Ads</option>
                                        <option value="Articles and Content" {{ $template->category == 'Articles and Content' ? 'selected' : '' }}>Articles and Content</option>
                                        <option value="Blog Post" {{ $template->category == 'Blog Post' ? 'selected' : '' }}>Blog Post</option>
                                        <option value="E-commerce" {{ $template->category == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                        <option value="Website" {{ $template->category == 'Website' ? 'selected' : '' }}>Website</option>
                                        <option value="Social Media" {{ $template->category == 'Social Media' ? 'selected' : '' }}>Social Media</option>
                                        <option value="Email" {{ $template->category == 'Email' ? 'selected' : '' }}>Email</option>
                                        <option value="Marketing" {{ $template->category == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon" class="form-label">Icon</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" placeholder="(e.g., &lt;i class=&quot;fa-solid fa-book&quot;&gt;&lt;/i&gt;)" name="icon" value="{{old('icon', $template->icon)}}">
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="is_active" {{ $template->is_active ? "checked" : "" }}>
                                    <label class="form-check-label" for="is_active"> Active Template </label>
                                    <input type="hidden" name="is_active" value="{{ $template->is_active ? 1 : 0 }}" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="input-fields">
                                <div class="row input-field-row">

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="input_fields_0_title" class="form-label">Input Field Title * </label>
                                <div class="form-control-wrap">
                                    <input type="text" name="input_fields[0][title]" id="input_fields_0_title" class="form-control" value="{{ $inputFields->title }}" required  >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="input_fields_0_description" class="form-label">Input Field Description * </label>
                                <div class="form-control-wrap">
                                    <input type="text" name="input_fields[0][description]" id="input_fields_0_description" class="form-control" value="{{ $inputFields->description }}" required  >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">

                            <div class="form-group">
                                <label for="input_fields_0_type" class="form-label"> Field Type * </label>
                                <div class="form-control-wrap">
                        <select name="input_fields[0][type]" class="form-control" id="input_fields_0_type"  >
                            <option value="text" {{ $inputFields->type == 'text' ? 'selected': '' }}>Input Field</option>
                            <option value="textarea" {{ $inputFields->type == 'textarea' ? 'selected': '' }}>Textarea Field</option>
                        </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3">

                            <div class="form-group">
                                <label class="form-label">  </label>
                                <div class="form-control-wrap">
                        <input type="hidden" name="input_fields[0][is_required]"    value="1">
                                </div>
                            </div>
                        </div>
                                </div>
                            </div>


                        <div class="form-group mt-2">
                            <label for="prompt">Custom Prompt</label>
                            <textarea placeholder="Add Your Prompt Code" class="form-control" name="prompt" rows="3">{{ $template->prompt }}</textarea>
                            <small>Write a 400 world aticale about {topic} with an introductions</small>
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
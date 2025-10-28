@extends('admin.dashboard')
@section('admin')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Add Chat Assistant</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <form action="{{ route('chat.assistant.store') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="nk-block">
            <div class="card shadown-none">

                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="avatar" class="form-label">Select Chat Assistant Avatar</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" >
                                    @error('avatar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_active" class="form-label">Active Chat Assistant</label>
                                <div class="form-control-wrap">
                                    <input type="checkbox" class="@error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="{{old('is_active', 1)}}">
                                    @error('is_active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Chat Assistant Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_description" class="form-label">Chat Assistant Role Description</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('role_description') is-invalid @enderror" id="role_description" name="role_description" value="{{old('role_description')}}">
                                    @error('role_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="welcome_message" class="form-label">Chat Assistant Welcome Message</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('welcome_message') is-invalid @enderror" id="welcome_message" name="welcome_message" value="{{old('welcome_message')}}">
                                    @error('welcome_message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category" class="form-label">Chat Assistant Group</label>
                                <div class="form-control-wrap">
                                    <select name="category" class="form-control" id="category"  >
                                        <option selected="">Open this select menu</option>
                                        <option value="Business">Business</option>
                                        <option value="Education">Education</option>
                                        <option value="Health">Health</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-12">
                            <label for="instructions">Chat Instructions</label>
                            <textarea class="form-control" placeholder="Explain in details what IA Chat needs to do." name="instructions" rows="3"></textarea>
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
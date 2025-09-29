@extends('admin.dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Change Password</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <form action="{{ route('admin.password.update') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="nk-block">
            <div class="card shadown-none">

                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="old_password" class="form-label">Old Password</label>
                                <div class="form-control-wrap">
                                    <input type="password" class="form-control
                                    @error('old_password') is-invalid @enderror" id="old_password" name="old_password" >
                                    @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="new_password" class="form-label">New Password</label>
                                <div class="form-control-wrap">
                                    <input type="password"  id="new_password" name="new_password" class="form-control
                                    @error('new_password') is-invalid @enderror" >
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="new_password-confirmation" class="form-label">New Password Confirmation</label>
                                <div class="form-control-wrap">
                                    <input type="password"  id="new_password-confirmation" name="new_password_confirmation" class="form-control"  >
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
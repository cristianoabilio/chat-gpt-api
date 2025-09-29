@extends('admin.dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Personal Profile</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="nk-block">
            <div class="card shadown-none">

                <div class="card-body">
                    <div class="row g-3 gx-gs">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $profile->name)}}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <div class="form-control-wrap">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email', $profile->email)}}"">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{old('phone', $profile->phone)}}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{old('address', $profile->address)}}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo" class="form-label">Profile Image</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control" id="image" name="photo">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="photo" class="form-label">Profile Image</label>
                                <div class="form-control-wrap">
                                    <img id="showImage" src="{{ (! empty($profile->photo))
                                    ? url('upload/admin_images/' . $profile->photo)
                                    : url('upload/no_image.jpg') }}" class="rounded-circle avatar-xl img-thumbnail float-starts" width="80px" height="80px">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>
@endsection
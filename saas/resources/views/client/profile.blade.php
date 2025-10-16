@extends('client.dashboard')
@section('client')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-page-head">
            <div class="nk-block-head-between">
                <div class="nk-block-head-content">
                    <h2 class="display-6">Personal Account</h2>
                </div>
            </div>
        </div><!-- .nk-page-head -->
        <div class="nk-block">
            <ul class="nav nav-tabs mb-3 nav-tabs-s1">
                <li class="nav-item">
                    <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#profile-tab-pane">Profile</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#payment-billing-tab-pane">Payment &amp; Billing</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#payment-billing-2-tab-pane">Payment &amp; Billing v2</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="profile-tab-pane">
                    <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
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
                                                    ? url('upload/user_images/' . $profile->photo)
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
                </div><!-- .tab-pane -->

                @include('client.body.payment_billing')

                @include('client.body.payment_billing_two')

            </div><!-- .tab-content -->
        </div><!-- .nk-block -->
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
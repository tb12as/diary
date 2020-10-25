@extends('layouts.app')

@section('content')
@include('layouts.loading')

<div class="container">
    <h3>User Setting</h3>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h4>General</h4>
            <ul id="error"></ul>
            <form action="{{ route('settings.save') }}" method="post" id="generalForm">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" placeholder="Name" value="{{ Auth::user()->name }}" id="name" name="name">
                </div>

                <div class="form-group password-input" style="opacity: 0.5">
                    <label for="password">Password</label>
                    <input type="password" class="form-control disabled" placeholder="Change Password" id="password" value="{{ Str::random(10) }}" autocomplete="new-password" disabled>
                </div>
                <div class="form-group password-input" style="opacity: 0.5">
                    <label for="passwordCon">Password Confirmation</label>
                    <input type="password" class="form-control disabled" placeholder="Password Confirmation" id="passwordCon" value="{{ Str::random(10) }}" autocomplete="new-password" disabled>
                </div>
                <div class="form-group">
                    <button type="button" id="changePassword" class="btn btn-outline-danger btn-sm">Change Password</button>
                    <button type="button" id="changePasswordCencel" class="btn btn-danger btn-sm d-none">Cencel</button>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm float-right">Update Setting</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <h4>User Profile Picture</h4>
            <ul id="errorProfile"></ul>
            <p class="text-muted">Change Profile Picture</p>
            <div class="d-flex justify-content-center">
                <img src="{{ Auth::user()->profile_pic ? asset('profile_images').'/'.Auth::user()->profile_pic : 'https://ui-avatars.com/api/?background=303030&color=fff&name='.Auth::user()->name.'&size=240' }}" alt="{{ Auth::user()->name }}" class="rounded-circle my-4 w-50" id="profileImagePreview">
            </div>
            <form action="{{ route('setting.updatePhotoProfile') }}" id="updatePhotoProfileForm" enctype="multipart/form-data">
                <div class="custom-file my-2">
                    <input type="file" class="custom-file-input" id="profileImage" name="profile_img">
                    <label class="custom-file-label" for="profileImage">Profile Image</label>
                </div>

                <div class="form-group d-flex justify-content-between">
                    <button class="btn btn-danger btn-sm {{ Auth::user()->profile_pic ?? 'd-none' }}" id="removeProfile">Remove Profile Picture</button>
                    <button type="submit" class="btn btn-primary btn-sm float-right">Update Profile Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="snackbar snackbar-ff">
    <div class="alert alert-success px-5" role="alert">
        <strong>Setting Updated</strong>
    </div>
</div>
<div class="snackbar snackbar-profile-image">
    <div class="alert alert-success px-5" role="alert">
        <strong>Profile Picture Updated!</strong>
    </div>
</div>
<div class="snackbar snackbar-profile-image-delete">
    <div class="alert alert-danger px-5" role="alert">
        <strong>Profile Picture Deleted!</strong>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function() {
        setTitle('Settings');
        $('.loading').addClass('false');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        $('#changePassword').click(function(event) {
            event.preventDefault();
            $('.password-input').css('opacity', '1');
            $('input[type="password"]').removeClass('disabled');
            $('input[type="password"]').removeAttr('disabled');
            $('input[type="password"]').removeAttr('value');
            $('#password').attr('name', 'password');
            $('#passwordCon').attr('name', 'password_confirmation');
            //
            $(this).addClass('d-none');
            $('#changePasswordCencel').removeClass('d-none');
        });

        function cencelChangePassword() {
            $('.password-input').css('opacity', '0.5');
            $('input[type="password"]').addClass('disabled');
            $('input[type="password"]').attr('disabled', 'true');
            $('input[type="password"]').attr('value', '{{ Str::random(10) }}');
            $('#password').attr('name', '');
            $('#passwordCon').attr('name', '');
        }

        $('#changePasswordCencel').click(function(event) {
            event.preventDefault();
            cencelChangePassword();
            //
            $(this).addClass('d-none');
            $('#changePassword').removeClass('d-none');
        });

        $('#generalForm').submit(function(e) {
            e.preventDefault();
            let data = $(this).serialize();

            $.ajax({
                url: '{{ route('settings.save') }}',
                type: 'POST',
                data: data,
                success: (res) => {
                    $('.error-list').remove();
                    $('input[name="name"]').val(res.name);

                    if(res.change_password) {
                        cencelChangePassword();
                    }
                    $('.snackbar-ff').addClass('true');
                    setTimeout(() => {
                        $('.snackbar-ff').removeClass('true');
                    }, 1500);
                }, 
                error: (err) => {
                    console.log(err.responseJSON);
                    // let errors = err.responseJSON.errors;
                    if(err.responseJSON.errors) {
                        $('.error-list').remove();
                        $.each(err.responseJSON.errors, function(index, val) {
                            $('#error').append(`<li class="text-danger error-list"><b>${val}</b></li>`);
                        }); 
                    }
                }
            })
            
        });

        function changeImagePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profileImagePreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#profileImage').change(function(event) {
            event.preventDefault();
            changeImagePreview(this);
            if (this.files && this.files[0]) {
                $(this).next('label').html(this.files[0].name);
            } else {
                $(this).next('label').html('No file choosen');
            }
        });

        $('#updatePhotoProfileForm').submit(function(event) {
            event.preventDefault();
            let data = new FormData(this);

            $.ajax({
                url: '{{ route('setting.updatePhotoProfile') }}',
                type: 'POST',
                data: data,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: (res) => {
                    $('.error-list').remove();
                    $('#updatePhotoProfile').trigger('reset');
                    $('#profileImage').next('label').html('Profile Image');
                    $('#profileImagePreview').attr('src', '{{ asset('profile_images') }}/'+res.fileName);
                    $('.snackbar-profile-image').addClass('true');
                    setTimeout(() => {
                        $('.snackbar-profile-image').removeClass('true');
                    }, 2000);
                    $('#removeProfile').removeClass('d-none');
                },
                error: (err) => {
                    console.log(err);
                    if (err.responseJSON.errors) {
                        $('.error-list').remove();
                        $.each(err.responseJSON.errors, function(i, v) {
                            $('#errorProfile').append(`<li class="text-danger font-weight-bold error-list">${v}</li>`);
                        });
                    }
                }
            }); 
        });

        $('#removeProfile').click((e) => {
            e.preventDefault();
            $.ajax({
                url: '{{ route('setting.deletePhotoProfile') }}',
                type: 'PUT',
                success: (res) => {
                    $('#profileImagePreview').attr('src', 'https://ui-avatars.com/api/?background=303030&color=fff&name={{ Auth::user()->name }}&size=240');
                    $('.snackbar-profile-image-delete').addClass('true');
                    setTimeout(() => {
                        $('.snackbar-profile-image-delete').removeClass('true');
                    }, 2000);
                    $('#removeProfile').addClass('d-none');
                },
                error: (e) => {
                    console.log(e);
                }
            });
        })
    }); // ready 
</script>
@endsection

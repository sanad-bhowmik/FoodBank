@extends('frontend.layouts.app')
@section('main-content')

<style>
    #custom-toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: rgba(255, 0, 0, 0.7);
        /* Red background with some transparency for a glass effect */
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        display: none;
        z-index: 9999;
        backdrop-filter: blur(10px);
        /* Adjust the blur value based on your preference */
        -webkit-backdrop-filter: blur(10px);
        /* For compatibility with some browsers */
    }

    #custom-toast-container.show {
        display: block;
        animation: slideIn 0.5s ease-in-out;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }
</style>
<!--======= LOGIN PART START ========-->
<section class="auth">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="auth-content"style="
    box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
">
                    <nav class="auth-navs">
                        <a class="nav-link active" href="{{ route('login') }}"> {{ __('login') }} </a>
                        <a class="nav-link" href="{{ route('register') }}"> {{ __('register') }}</a>
                    </nav>
                    <div class="auth-tabs">
                        <div class="auth-header">
                            <h3>{{ __('Welcome Back!') }}</h3>
                            <p> {{ __('Please enter your login details below') }}</p>
                        </div>
                        <form method="POST" class="login" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="type" value="frontend">

                            <div class="form-group">
                                <label for="email" class="form-label"> {{ __('PHONE') }} </label>
                                <input id="demoemail" type="text" class="form-control  @if ($errors->has('email') || session('block')) is-invalid @endif" name="phone" value="{{ old('email') }}"  >
                                <small class="form-alert red" style="color: #9ADE7B;">{{ __("We'll never share your info with anyone else.") }}</small>
                                <br>
                                @if ($errors->has('phone'))
                                <span class="is-invalid" role="alert">
                                    <strong class="text-danger">Number or Password dosen't match.</strong>
                                </span>
                                @elseif(session('block'))
                                <span class="is-invalid" role="alert">
                                    <strong>{{ session('block') }}</strong>
                                </span>
                                @endif
                            </div>
                            <!-- Add this somewhere in your HTML -->
                            <div id="custom-toast-container"></div>

                            <div class="form-group">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input placeholder="Password" id="demopassword" type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" name="password" autocomplete="current-password">
                                    <div class="input-group-append" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                                        <span class="input-group-text" style="height: 48px;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                <span class="is-invalid" role="alert">
                                    <strong class="text-danger">{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>


                            <div class="d-flex justify-content-between">
                                <div class="form-group form-check-group">
                                    <input type="checkbox" id="remember-me" name="check">
                                    <label for="remember-me"> {{ __('Remember me') }}</label>
                                </div>

                                <div class="col-md-6 d-flex justify-content-end">
                                    <label for="forgot password">
                                        <a class="linkTxt" href="{{ route('password.request') }}" class="text-primary">{{ __('Forgot Password?') }}</a>
                                    </label>
                                </div>
                            </div>


                            <input type="submit" class="form-btn" value="Login">

                            @if (setting('facebook_key') || setting('google_key'))
                            <div class="auth-divide"><span>{{ __('or login with ') }}</span></div>
                            @endif

                            <nav class="auth-sync">
                                @if (setting('google_key'))
                                <a href="{{ route('social-login', 'google') }}">
                                    <img src="{{ asset('frontend/images/social/google.png') }}" alt="social">
                                    <span>{{ __('Google') }}</span>
                                </a>
                                @endif

                                @if (setting('facebook_key'))
                                <a href="{{ route('social-login', 'facebook') }}">
                                    <img src="{{ asset('frontend/images/social/facebook.png') }}" alt="social">
                                    <span>{{ __('Facebook ') }}</span>
                                </a>
                                @endif
                            </nav>
                        </form>
                    </div>

                    @if (env('DEMO_MODE'))
                    <div class="card demo-login mx-auto text-center mt-2 border-0">

                        <div class="card-body border-0">
                            <h5 class="mb-2">{{ __('For Quick Demo Login Click Below...') }}</h5>
                            <div class="buttons">
                                <button id="demoadmin" class="btn btn-sm btn-primary">{{ __('Admin') }}</button>
                                <button id="democustomer" class="btn  btn-sm  btn-info ">{{ __('Customer') }}</button>
                                <button id="demorestaurantowner" class="btn btn-success  btn-sm">{{ __('Restaurant Owner') }}</button>
                                <button id="demodeliveryboy" class="btn btn-warning  btn-sm ">{{ __('Delivery Boy') }}</button>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <img class="auth-banner" src="https://static.wixstatic.com/media/4e54b4_23effb86517f41409f60c1423244bc96~mv2.gif/v1/fill/w_800,h_600,al_c,q_90/file.jpg" alt="auth" style="margin-top:40px">
    <!--<img class="auth-banner" src="{{ asset('frontend/images/auth.jpg') }}" alt="auth">-->
</section>
<!--======== LOGIN PART END ========-->
@endsection

@push('js')
<script src="{{ asset('frontend/js/demo-login.js') }}"></script>

<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("demopassword");
        var eyeIcon = document.querySelector(".input-group-text i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<script>
    function showToast(message) {
        var customToastContainer = document.getElementById('custom-toast-container');
        customToastContainer.innerHTML = message;

        customToastContainer.classList.add('show');

        setTimeout(function() {
            customToastContainer.classList.remove('show');
        }, 3000); // Adjust the timeout according to your preference
    }

 
</script>
<script>
  
</script>

@endpush
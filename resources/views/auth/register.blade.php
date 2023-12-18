@extends('frontend.layouts.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/lib/inttelinput/css/intlTelInput.css') }}">
@endpush
<style>
    @media screen and (max-width: 767px) {
        .form-group div>div:first-child {
            display: none !important;
        }

        .form-control {
            /* width: 193% ; */
        }

        #phone {
            width: 193% !important;
        }

        .form-group label {
            font-size: 12px;
        }

        .form-group div {}

        .form-group div>div:last-child input {}
    }
</style>
@section('main-content')
    <!--========= REGISTER PART START =======-->
    <section class="auth">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="auth-content"style="
                    box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;">
                        <nav class="auth-navs">
                            <a class="nav-link active" href="{{ route('register') }}"> {{ __('register') }}</a>
                               <a class="nav-link" href="{{ route('login') }}"> {{ __('login') }} </a>
                        </nav>
                        <div class="auth-tabs">
                            <form method="POST" class="register" action="{{ route('register') }}">
                                @csrf
                                <ul class="auth-types">
                                    <li style="display: none;">
                                        <input type="radio" id="CustomerRegister" name="roles" value="2"
                                            {{ old('roles', 2) == 2 ? 'checked' : 'checked' }}>
                                        <label for="CustomerRegister">{{ __('Customer') }}</label>
                                    </li>
                                    <!--<li>-->
                                    <!--    <input type="radio" id="RestaurantOwnerRegister" name="roles" value="3"-->
                                    <!--        {{ old('roles', 3) == 3 ? 'checked' : '' }}>-->
                                    <!--    <label for="RestaurantOwnerRegister">{{ __('Restaurant Owner') }}</label>-->
                                    <!--</li>-->
                                    <!--<li>-->
                                    <!--    <input type="radio" id="DeliveryRegister" name="roles" value="3"-->
                                    <!--        {{ old('roles', 3) == 3 ? 'checked' : '' }}>-->
                                    <!--    <label for="DeliveryRegister">{{ __('Delivery Man') }}</label>-->
                                    <!--</li>-->
                                </ul>
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="first_name"
                                                class="form-label required">{{ __('First name') }}</label>
                                            <input name="first_name" value="{{ old('first_name') }}" type="text"
                                                class="form-control @if ($errors->has('first_name')) is-invalid @endif"
                                                placeholder="John">
                                            @if ($errors->has('first_name'))
                                                <div class="invalid-feadback text-danger" role="alert">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name"
                                                class="form-label required">{{ __('Last Name') }}</label>
                                            <input name="last_name" value="{{ old('last_name') }}" type="text"
                                                class="form-control @if ($errors->has('last_name')) is-invalid @endif"
                                                placeholder="Doe">
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feadback text-danger" role="alert">
                                                    {{ $errors->first('last_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!--<div class="col-12 col-sm-6" >-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label for="username" class="form-label required">{{ __('Username') }}</label>-->
                                    <!--        <input id="username" name="username" value="{{ old('username') }}"-->
                                    <!--            type="text"-->
                                    <!--            class="form-control @if ($errors->has('username')) is-invalid @endif"-->
                                    <!--            placeholder="john">-->
                                    <!--        @if ($errors->has('username'))-->
                                    <!--            <div class="invalid-feadback text-danger" role="alert">-->
                                    <!--                {{ $errors->first('username') }}-->
                                    <!--            </div>-->
                                    <!--        @endif-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="register_email"
                                                class="form-label required">{{ __('Email Address') }} </label>
                                            <input name="register_email" value="{{ old('register_email') }}" type="email"
                                                class="form-control @if ($errors->has('register_email')) is-invalid @endif"
                                                placeholder="user@example.com">
                                            @if ($errors->has('register_email'))
                                                <span class="is-invalid" role="alert">
                                                    <strong
                                                        class="text-danger">{{ $errors->first('register_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                <div class="col-12">
    <div class="form-group">
        <label class="form-label required">{{ __('Phone') }} </label>
        <div style="display: flex;">
            <div style="display: flex;height: 48px; font-size: 14px;font-weight: 500;line-height: 20px;padding: 11px 12px;border-radius: 8px;color: var(--secondary);border: 1px solid var(--border-gray);">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Flag_of_Bangladesh.svg/1200px-Flag_of_Bangladesh.svg.png" alt="Flag" style="height: 13px;margin-top: 3px;">
                <p style="margin-left: 6px;font-size: 14px;color: gray;">+88</p>
                <p style="margin-left: 6px;width: 0;height: 0;border-left: 3px solid transparent;border-right: 3px solid transparent;border-top: 4px solid #555; margin-top: 8px;"></p>
            </div>
            <div>
                <input class="form-control mobilenumber @error('mobile') is-invalid @enderror phone" type="tel" id="phone" name="phone" onkeypress='validate(event)' style="width: 152%;" value="{{ old('phone') }}">
            </div>
        </div>
        <input type="hidden" id="code" name="countrycode" value="">
        @error('phone')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address" class="form-label required">{{ __('Address') }}</label>
                                            <input id="address" name="address" value="{{ old('address') }}"
                                                type="text"
                                                class="form-control @if ($errors->has('address')) is-invalid @endif"
                                                placeholder="House#10, Section#1, Dhaka 1216, Bangladesh">
                                        </div>
                                    </div>
                                   <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label required">{{ __('Password') }}</label>
                                        <input name="password" id="password" class="form-control @if ($errors->has('password')) is-invalid @endif" type="password" placeholder="Create password">
                                        @if ($errors->has('password'))
                                        <div class="invalid-feadback text-danger" role="alert">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="password2"
                                                class="form-label required">{{ __('Repeat Password') }}</label>
                                            <input name="password_confirmation"
                                                class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif"
                                                type="password" placeholder="repeat password">
                                            @if ($errors->has('password_confirmation'))
                                                <span class="is-invalid" role="alert">
                                                    <strong
                                                        class="text-danger">{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" class="form-btn mt-2" name="register" value="Register" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img class="auth-banner" src="https://admin.adelaidecentralplaza.com.au/getmedia/7b414bf9-f972-41d9-a722-59fa9951d519/Super-Egg-Korean-Rice-Bowls.gif?width=1322&height=881&ext=.gif" alt="auth">
        <!--<img class="auth-banner" src="{{ asset('frontend/images/auth.jpg') }}" alt="auth">-->
    </section>
    <!--======== REGISTER PART END ======-->
@endsection

@push('js')
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput-jquery.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/intlTelInput.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/utils.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/data.js') }}"></script>
    <script defer src="{{ asset('frontend/lib/inttelinput/js/init.js') }}"></script>
    <script src="{{ asset('js/phone_validation/index.js') }}"></script>
@endpush

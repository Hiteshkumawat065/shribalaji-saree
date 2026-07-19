@extends('frontend.layouts.outer') 
@section('content')  
      <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-7">
          <div class="card mb-3">
            <div class="login-logo">
              <a href="{{ route('frontend.index') }}" class="logo">
                <img src="{{ asset('img/frontend/Greener-Dentistry_europe-curve-web.svg')}}" alt="Logo">
              </a>
            </div>
            <div class="card-body p-4">
              <div class="">
                <h5 class="card-title text-center mb-4">Reset Password </h5>
              </div>

              
              <form class="row g-3 needs-validation" method="POST" action="{{ route('admin.auth.resetpasswords.post') }}">
              @csrf
              <input type="hidden" value="{{isset($token) ? $token : '' }}" name="token">
                <div class="col-12"> 
                  <label for="yourUsername" class="form-label">Email address</label>
                  <div class="input-group"> 
                    <span class="input-group-text" id="inputGroupPrepend">
                      <i class="fa-solid fa-envelope"></i>
                    </span>  
                    {{ html()->text('email',$email)
                          ->class('form-control')
                          ->attribute('readonly')
                           ->placeholder(__('validation.attributes.frontend.registration.email'))
                          ->attribute('maxlength', 191) 
                           }} 
                    @if($errors->has('email'))
                      <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }} </strong></span>
                    @endif 

                  </div>
                </div>  

                <div class="col-12"> 
                {{ html()->label(__('validation.attributes.frontend.registration.password'))->class('form-label')->for('password') }} 
                  <div class="input-group"> 
                    <span class="input-group-text" id="inputGroupPrepend">
                    <i class="fa-solid fa-lock"></i>
                    </span>  
                    {{ html()->password('password')
                          ->class('form-control')
                           ->placeholder(__('validation.attributes.frontend.registration.password'))
                          ->attribute('maxlength', 191) 
                           }}

                    @if($errors->has('password'))
                      <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }} </strong></span>
                    @endif 

                  </div>
                </div>  

                <div class="col-12"> 
                {{ html()->label(__('validation.attributes.frontend.registration.confirm_password'))->class('form-label')->for('confirm_password') }} 
                  <div class="input-group"> 
                    <span class="input-group-text" id="inputGroupPrepend">
                    <i class="fa-solid fa-lock"></i>
                    </span>  
                    {{ html()->password('password_confirmation')
                          ->class('form-control')
                           ->placeholder(__('validation.attributes.frontend.registration.confirm_password'))
                          ->attribute('maxlength', 191) 
                           }}

                    @if($errors->has('confirm_password'))
                      <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('confirm_password') }} </strong></span>
                    @endif 

                  </div>
                </div>     
                <div class="col-12"> 
                  <button class="btn green-btn w-100" type="submit">{{ __('Submit') }}</button> 
                </div>
                <div class="col-12">
                  <p class="mb-0 text-center">You have an account? 
                    <a href="{{ route('admin.login') }}">Sign In</a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div> 
@endsection

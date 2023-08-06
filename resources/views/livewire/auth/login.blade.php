<div class="container">
    <div class="row justify-content-around">
        <div class="d-none d-lg-block col-lg-7 text-center p-5">
           <img src="{{ asset('images/ecommerce-checkout.svg') }}" 
                class="img-fluid" alt="Company logo" width="400">
           <h1>B&D E-commerce</h1>

           <div>
              <h3>Find what you love and love what you find.</h3>
           </div>
        </div>

        <div class="col-md-8 col-lg-5 p-4">
            <form class="shadow-sm border rounded p-3 p-md-5" wire:submit="login">
                @csrf
                <h1 class="mt-4" align="center"><u>Login</u></h1>

                @if (session()->has('success'))
                    <div wire:poll.3s="hide" class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('danger'))
                    <div wire:poll.3s="hide" class="alert alert-danger" role="alert">
                        {{ session('danger') }}
                    </div>
                @endif

                @if (session()->has('attemptsLeft'))
                    <div class="alert alert-warning">{{ session('attemptsLeft') }} login attempts left</div>
                @endif

                <div class="form-outline mb-4 mt-4">
                    <label class="fw-bold">Username or Email</label>
                    <input type="text" id="login" class="form-control @error('usernameOrEmail') is-invalid  @enderror
                    @if($usernameOrEmail) '' @endif"
                    wire:model.live.debounce.500ms="usernameOrEmail" autocomplete="off" placeholder="Username or Email"/>
                    @error('usernameOrEmail') 
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <label class="fw-bold">Password</label>
                    <input type="{{ $showPassword ? 'text' : 'password' }}" id="password_form" class="form-control @error('password') is-invalid  @enderror
                    @if($usernameOrEmail) '' @endif"
                    wire:model.live.debounce.500ms="password" placeholder="Password"/>
                    @error('password') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="row mb-1">
                   <div class="col d-flex">
                       <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="showPassword" wire:model.live="showPassword"/>
                           <label class="form-check-label" for="showPassword">
                               Show password 
                            </label>
                        </div>
                    </div>
                    
                    <div class="col d-flex justify-content-end">
                        <a href="#!">Forgot password?</a>
                    </div>
                </div>
                
                <!-- Submit button -->
                <div align="center">
                    <div class="text-start mb-1">
                        <input class="form-check-input" type="checkbox" id="rememberMe" wire:model.live="remember"/>
                        <label class="form-check-label" for="rememberMe">
                            Remember me? 
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary mb-4 shadow-sm" >
                        Sign in
                    </button>
                </div>

                <div class="text-center">
                    <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                </div>
            </form>
        </div>
     </div>
</div>
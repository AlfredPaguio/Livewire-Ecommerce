<div class="container">
    <div class="row justify-content-around">
        <div class="d-none d-lg-block col-lg-7 text-center p-5 my-auto">
           <img src="{{ asset('images/ecommerce-checkout.svg') }}" 
                class="img-fluid" alt="Company logo" width="400">
           <h1>B&D E-commerce</h1>

           <div>
              <h3>Find what you love and love what you find.</h3>
           </div>
        </div>

        <div class="col-md-8 col-lg-5 p-4">
            <form class="shadow-sm border rounded p-3 p-md-5" wire:submit="register">
                @csrf
                <h1 class="mt-4" align="center"><u>Register</u></h1>
                <div class="form-outline mb-4 mt-4">
                    <label class="fw-bold">Username</label>
                    <input type="text" id="username" 
                    class="form-control @error('username') is-invalid  @enderror
                    @if($username) is-valid @endif" 
                    wire:model.live.debounce.500ms="username" autocomplete="off" placeholder="Username"/>
                    
                    @error('username') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="form-outline mb-4 mt-4">
                    <label class="fw-bold">Email</label>
                    <input type="email" id="email" 
                    class="form-control @error('email') is-invalid  @enderror
                    @if($email) is-valid @endif" 
                    wire:model.live.debounce.500ms="email" autocomplete="off" placeholder="Email"/>
                    @error('email') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <label class="fw-bold">Password</label>
                    <input type="{{ $showPassword ? 'text' : 'password' }}" id="password" 
                    class="form-control @error('password') is-invalid  @enderror
                    @if($password) is-valid @endif" 
                    wire:model.live.debounce.500ms="password" placeholder="Password"/>
                    @error('password') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="form-outline mb-4">
                    <label class="fw-bold">Confirm Password</label>
                    <input type="{{ $showPassword ? 'text' : 'password' }}" id="confirm_password" 
                    class="form-control @error('confirm_password') is-invalid @enderror 
                    @if($password != '' && $password == $confirm_password) is-valid @endif" 
                    wire:model.live.debounce.500ms="confirm_password" placeholder="Confirm Password"/>
                    @error('confirm_password') 
                        <small class="text-danger">{{ $message }}</small> 
                    @enderror
                </div>

                <div class="row mb-4">
                   <div class="col d-flex">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" wire:model.live="showPassword"/>
                        <label class="form-check-label" for="showPassword">
                            Show password 
                        </label>
                      </div>
                   </div>
                </div>

                <!-- Submit button -->
                <div align="center">
                    <button type="submit" class="btn btn-outline-primary mb-4 shadow-sm" >
                        Sign Up
                    </button>
                </div>

                <div class="text-center">
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </form>
        </div>
     </div>
</div>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ config('app.name', 'Laravel') }}</title>

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.bunny.net">
      <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" 
      rel="stylesheet" />
      
      <!-- Font Awesome -->
      <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

      <!-- Boostrap Css -->
      @vite(['resources/css/app.css'])

      <!-- Livewire Styles -->
      @livewireStyles
   </head>
   <body>
      <section id="nav" class="sticky-top">
         <nav class="navbar navbar-expand-lg bg-light p-3 shadow-sm">
            <div class="container-fluid">
               <div class="d-none d-sm-block">
                  <a class="navbar-brand fs-3" href="/">
                     <span class="bg-dark text-white rounded shadow px-2 me-2">B&D</span>
                     <span>Ecommerce</span>
                  </a>
               </div>
               
               <form id="search" class="d-flex w-50" role="search">
                  <input class="form-control" type="search" 
                  placeholder="Search" aria-label="Search">
                  <button class="btn d-none d-md-block" type="submit">
                     <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
               </form>
               
               <div class="d-flex justify-content-end">
                  <a href="#" class="link-dark btn position-relative" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Cart">
                     <i class="fa-solid fa-cart-shopping fs-5"></i>
                     @auth 
                     <span class="position-absolute p-1 top-0 start-100 translate-middle badge 
                     rounded-pill bg-danger">10 
                        <span class="visually-hidden">
                           on cart
                        </span>
                     </span>
                     @endauth
                  </a>

                  @auth
                  <div>
                     <a class="link-dark btn" href="{{ route('account') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Account">
                        <i class="fa-regular fa-user fs-5"></i>
                     </a>
                  </div>
                  @endauth

                  @auth
                     @if(Auth::user()->role == 'admin')
                     <div>
                        <a class="btn btn-outline-dark" href="{{ route('admin.dashboard') }}">
                           Admin
                        </a>
                     </div>
                     @endif
                  @endauth

                  @guest
                  <a class="link-secondary py-2 px-1 fs-6 text-decoration-none auth" href="{{ route('login') }}">
                     Login
                  </a>
                  <span class="text-secondary py-2 px-1 fs-6">|</span>
                  <a class="link-secondary py-2 px-1 fs-6 text-decoration-none auth" href="{{ route('register') }}">
                     Signup
                  </a>
                  @endguest
               </div>
            </div>
         </nav>
      </section>

      
      @yield('content')

      
      <!-- Boostrap Js -->
      @vite(['resources/js/app.js'])

      <!-- Livewire Scripts -->
      @livewireScripts
   </body>
</html>
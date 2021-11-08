@extends('layouts.landing_app')
@section('content')
<div class="transition2"></div>
<div class="wrapper">
  <div class="container landingpage">
    <div class="row">
      <div class="col-lg-6">
          <img class="logo"src="sources/logo.png" alt="logo">
          <p class="introduction">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <span id="einloggen"><a  href="/login"></a></span>
      </div>
      <div class="col-lg-6">
        <img class="workpicture"src="sources/work.png" alt="work">
      </div>
    </div>
  </div>
</div>
<div class="transition1"></div>
<footer class="text-center text-lg-start">
  <div class="text-center p-3 foot">
    Tik Tasks 2021: This app is designed only for educational purposes
  </div>
</footer>
@endsection
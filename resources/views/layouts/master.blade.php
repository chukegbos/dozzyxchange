<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->sitename }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  </head>

  <body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <strong>Balance:</strong> <span>&#8358;</span>{{ number_format(Auth::user()->balance,2) }}
            </li>
          </ul>
        </div>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-link" style="background: white">
          <img src="{{ asset('account/img/favicon.png') }}" alt="Dozzy Xchange" class="brand-image">
          <span class="brand-text" style="color: black; font-weight: bolder;">Dozzy<span style="color: #ae0200; font-weight: bolder;">xchange</span></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              @if(!Auth::user()->image)
                <img src="{{ asset('account/img/avartar.jpg') }}" class="img-circle elevation-2" alt="{{ Auth::user()->username }}">
              @else
                <img src="{{ asset('storage') }}/{{ Auth::user()->image }}" class="img-circle elevation-2" alt="{{ Auth::user()->username }}">
              @endif
              <span class="ml-2" style="color: #000; font-weight: bolder;">Welcome, </span><span class="ml-2" style="color: #ae0200; font-weight: bolder;">{{ Auth::user()->username }}</span>

            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <router-link to="/home" class="nav-link">
                  <i class="nav-icon fa fa-tachometer"></i>
                  <p>Dashboard</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/services" class="nav-link">
                  <i class="nav-icon fa fa-hourglass-o"></i>
                  <p>Services</p>
                </router-link>
              </li>

              <li class="nav-item has-treeview">
                  <a href="#" class="nav-link link-text">
                    <i class="nav-icon fa fa-th"></i>
                    <p>
                      My Transactions
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <router-link to="/transaction/airtime" class="nav-link ml-3">
                        <i class="fa fa-circle nav-icon"></i>
                        <p>Airtime2cash</p>
                      </router-link>
                    </li>

                    <li class="nav-item">
                      <router-link to="/transaction/crypto" class="nav-link ml-3">
                        <i class="fa fa-circle nav-icon"></i>
                        <p>Crypto</p>
                      </router-link>
                    </li>

                    <li class="nav-item">
                      <router-link to="/transaction/gift-card" class="nav-link ml-3">
                        <i class="fa fa-circle nav-icon"></i>
                        <p>Gift Cards</p>
                      </router-link>
                    </li>

                  </ul>
              </li>

              <li class="nav-item">
                <router-link to="/wallet" class="nav-link">
                  <i class="nav-icon fa fa-credit-card-alt "></i>
                  <p>Wallet</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/account" class="nav-link">
                  <i class="nav-icon fa fa-money"></i>
                  <p>Accounts</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/rates" class="nav-link">
                  <i class="nav-icon fa fa-tint"></i>
                  <p>Rates</p>
                </router-link>
              </li>
            </ul>

            <hr>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <router-link to="/setting" class="nav-link">
                  <i class="nav-icon fa fa-ticket"></i>
                  <p>Support</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/setting" class="nav-link">
                  <i class="nav-icon fa fa-lightbulb-o"></i>
                  <p>Give Suggestion</p>
                </router-link>
              </li>


              <li class="nav-item">
                <router-link to="/setting" class="nav-link">
                  <i class="nav-icon fa fa-book"></i>
                  <p>FAQ</p>
                </router-link>
              </li>


              <li class="nav-item">
                <router-link to="/user" class="nav-link">
                  <i class="nav-icon fa fa-cogs"></i>
                  <p>Profile</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/password" class="nav-link">
                  <i class="nav-icon fa fa-key"></i>
                  <p>Change Password</p>
                </router-link>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  <i class="nav-icon fa fa-power-off"></i>
                  <p>{{ __('Logout') }}</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </li>
            
            </ul>
          </nav>
        </div>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>


  </body>
</html>

<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ url('/') }}" class="brand-link" style="background: white">
          <img src="{{ asset('account/img/favicon.png') }}" alt="Dozzy Xchange" class="brand-image">
          <span class="brand-text" style="color: black; font-weight: bolder;">Dozzy<span style="color: #ae0200; font-weight: bolder;">xchange</span></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <span class="p-1">
                Admin
              </span>
              <span class="dot"></span>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


              <li class="nav-item">
                <a href="{{ url('/home') }}" class="nav-link">
                  <i class="nav-icon fa fa-th"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/services') }}" class="nav-link">
                  <i class="nav-icon fa fa-book"></i>
                  <p>Services</p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-shopping-cart"></i>
                    <p>
                      Transactions
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ url('/admin/transactions/airtime') }}" class="nav-link ml-3">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Airtime2cash</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="{{ url('/admin/transactions/crypto') }}" class="nav-link ml-3">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Crypto Currency</p>
                      </a>
                    </li>
                  </ul>
              </li>

              <li class="nav-item">
                <a href="{{ url('/admin/wallet') }}" class="nav-link">
                  <i class="nav-icon fa fa-credit-card-alt "></i>
                  <p>Wallet Transactions</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('/admin/withdraw') }}" class="nav-link">
                  <i class="nav-icon fa fa-money"></i>
                  <p>Withdraw Request</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('/admin/users') }}" class="nav-link">
                  <i class="nav-icon fa fa-user"></i>
                  <p>Users</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('/admin/setting') }}" class="nav-link">
                  <i class="nav-icon fa fa-cogs"></i>
                  <p>App Settings</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  <i class="nav-icon fa fa-power-off text-red"></i>
                  <p>{{ __('Logout') }}</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
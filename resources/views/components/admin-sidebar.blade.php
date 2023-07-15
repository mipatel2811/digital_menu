<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    @php
        $user = auth()->user()
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ $user->profile_image ? '/images/users/'.$user->profile_image : asset('images/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $user->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> --}}

          

          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>            
          </li>

          <li class="nav-item {{ request()->is('bars*') ? 'menu-open' : '' }}">
            <a href="{{ route('bars.index') }}" class="nav-link {{ request()->is('bars*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-glass-cheers"></i>                    
              <p>
                Bars / Restaurants
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('bars.index') }}" class="nav-link {{ request()->is('bars') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Bars</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('bars.create') }}" class="nav-link {{ request()->is('bars/create*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Bar</p>
                </a>
              </li>              
            </ul>
          </li>

          <li class="nav-item {{ request()->is('items*') ? 'menu-open' : '' }}">
            <a href="{{ route('items.index') }}" class="nav-link {{ request()->is('items*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-glass-martini-alt"></i>
              <p>
                Items
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('items.index') }}" class="nav-link {{ request()->is('items') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Items</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('items.create') }}" class="nav-link {{ request()->is('items/create*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Item</p>
                </a>
              </li>              
            </ul>
          </li>

          <li class="nav-item {{ request()->is('category*') ? 'menu-open' : '' }}">
            <a href="{{ route('category.index') }}" class="nav-link {{ request()->is('category*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>              
              <p>
                Categories
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link {{ request()->is('category') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Categories</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.create') }}" class="nav-link {{ request()->is('category/create*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Category</p>
                </a>
              </li>              
            </ul>
          </li>

          <li class="nav-item {{ request()->is('ingredients*') ? 'menu-open' : '' }}">
            <a href="{{ route('ingredients.index') }}" class="nav-link {{ request()->is('ingredients*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>              
              <p>
                Ingredients
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('ingredients.index') }}" class="nav-link {{ request()->is('ingredients') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Ingredients</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('ingredients.create') }}" class="nav-link {{ request()->is('ingredients/create*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Ingredients</p>
                </a>
              </li>              
            </ul>
          </li>

          <li class="nav-item {{ request()->is('brands*') ? 'menu-open' : '' }}">
            <a href="{{ route('brands.index') }}" class="nav-link {{ request()->is('brands*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>              
              <p>
                Brands
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('brands.index') }}" class="nav-link {{ request()->is('brands') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Brands</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('brands.create') }}" class="nav-link {{ request()->is('brands/create*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Brand</p>
                </a>
              </li>              
            </ul>
          </li>

          <li class="nav-item {{ request()->is('users*') ? 'menu-open' : '' }}">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>              
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('users.create') }}" class="nav-link {{ request()->is('users/create*') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>              
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<style>
    #left-sidebar {
        background-color: #6378f1 !important;
    }

    #left-sidebar .nav-link {
        color: #fff;
        font-weight: 500;
    }

    .brand-link {
        color: #fff;
        font-weight: 900;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4" id="left-sidebar">
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Jalani Kumkum</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-header">Site Module</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-gears nav-icon"></i>
                        <p>Configuration</p>
                        <i class="right fas fa-angle-left"></i>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('config.slider.index') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Sliders</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('config.trending.slider.index') }}" class="nav-link">
                                <i class="fas fa-circle nav-icon"></i>
                                <p>Trending</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>Add Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('color.index') }}" class="nav-link">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>Color</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('measurment.index') }}" class="nav-link">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>Measurment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link">
                        <i class="fas fa-bars nav-icon"></i>
                        <p>Add Product</p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</aside>

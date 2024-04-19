<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="accueil.php" class="brand-link">
        <img src="img/logo.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">ISGA RH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Nommmm</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-outline-light">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Gestion Employer -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Gestion Employer
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./ajouter_employe.php" class="nav-link">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Ajouter Employe</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./liste_employe.php" class="nav-link">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Liste des employés</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Gestion Finance -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Gestion Finance
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./bulletin_paie.php" class="nav-link">
                                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                <p>Calcul bulletin de paie</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Logout -->
                <li class="nav-item">
                    <a href="./logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="sidebar border-right col-md-3 col-lg-2 bg-body-tertiary border p-0">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Aoki - FSWD 1</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column pt-lg-3 overflow-y-auto p-0">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex gap-2 {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">
                        <i class="bi bi-house-door"></i>
                        <span>Home</span>
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-content-center px-3 mt-4 mb-1 text-muted">
                <span>Management Employees</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex gap-2 {{ Request::is('employees*') ? 'active' : '' }}" aria-current="page" href="{{ route('employees.index') }}">
                        <i class="bi bi-person"></i>
                        <span>Employees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex gap-2 {{ Request::is('new-employees*') ? 'active' : '' }}" aria-current="page" href="{{ route('employees.newEmployees') }}">
                        <i class="bi bi-person-plus"></i>
                        <span>New Employees</span>
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-content-center px-3 mt-4 mb-1 text-muted">
                <span>Management Leaves</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex gap-2 {{ Request::is('leaves*') ? 'active' : '' }}" aria-current="page" href="{{ route('leaves.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>Leaves</span>
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex gap-2 {{ Request::is('leave-balances*') ? 'active' : '' }}" aria-current="page" href="{{ route('leaves.leaveBalances') }}">
                        <i class="bi bi-calendar"></i>
                        <span>Leave Balances</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>
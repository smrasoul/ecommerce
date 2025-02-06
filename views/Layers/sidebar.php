<ul class="list-group">
    <li class="list-group-item <?= ($activePage == 'dashboard') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'dashboard') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="../dashboard">Dashboard</a>
    </li>
    <li class="list-group-item <?= ($activePage == 'account-info') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'account-info') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="../account-info">Account information</a>
    </li>
    <li class="list-group-item <?= ($activePage == 'orders-history') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'orders-history') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="../orders-history">Orders history</a>
    </li>
    <?php if ($GLOBALS['canViewProduct']): ?>
        <li class="list-group-item <?= ($activePage == 'product-management') ? 'active' : '' ?>">
            <a class="<?= ($activePage == 'product-management') ? 'text-light link-light' : 'text-dark link-dark' ?>
            link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="../product-management">Product Management</a>
        </li>
    <?php endif; ?>
    <?php if ($GLOBALS['canManageUser']): ?>
        <li class="list-group-item <?= ($activePage == 'user-management') ? 'active' : '' ?>">
            <a class="<?= ($activePage == 'user-management') ? 'text-light link-light' : 'text-dark link-dark' ?>
            link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="../user-management">User Management</a>
        </li>
    <?php endif ?>
</ul>
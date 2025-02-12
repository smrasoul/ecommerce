<ul class="list-group">
    <li class="list-group-item <?= ($activePage == 'dashboard') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'dashboard') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="/user/dashboard">Dashboard</a>
    </li>
    <li class="list-group-item <?= ($activePage == 'account-info') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'account-info') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="/user/account">Account information</a>
    </li>
    <li class="list-group-item <?= ($activePage == 'orders-history') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'orders-history') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="/user/orders-history">Orders history</a>
    </li>
    <?php if ($GLOBALS['canManageProduct']): ?>
        <li class="list-group-item <?= ($activePage == 'product') ? 'active' : '' ?>">
            <a class="<?= ($activePage == 'product') ? 'text-light link-light' : 'text-dark link-dark' ?>
            link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="/admin/product">Product Management</a>
        </li>
    <?php endif; ?>
    <?php if ($GLOBALS['canManageUser']): ?>
        <li class="list-group-item <?= ($activePage == 'user-management') ? 'active' : '' ?>">
            <a class="<?= ($activePage == 'user-management') ? 'text-light link-light' : 'text-dark link-dark' ?>
            link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="/admin/user-management">User Management</a>
        </li>
    <?php endif ?>
</ul>
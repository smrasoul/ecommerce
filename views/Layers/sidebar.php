<ul class="list-group">
    <li class="list-group-item <?= ($activePage == 'dashboard') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'dashboard') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="dashboard">Dashboard</a>
    </li>
    <li class="list-group-item <?= ($activePage == 'account-info') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'account-info') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="account-info">Account information</a>
    </li>
    <li class="list-group-item <?= ($activePage == 'orders-history') ? 'active' : '' ?>">
        <a class="<?= ($activePage == 'orders-history') ? 'text-light link-light' : 'text-dark link-dark' ?>
        link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="orders-history">Orders history</a>
    </li>
    <?php if ($GLOBALS['canViewProduct']): ?>
        <li class="list-group-item <?= ($activePage == 'view-product') ? 'active' : '' ?>">
            <a class="<?= ($activePage == 'view-product') ? 'text-light link-light' : 'text-dark link-dark' ?>
            link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="view-product.php">Product Management</a>
        </li>
    <?php endif; ?>
    <?php if ($GLOBALS['canManageUser']): ?>
        <li class="list-group-item <?= ($activePage == 'manage-user') ? 'active' : '' ?>">
            <a class="<?= ($activePage == 'manage-user') ? 'text-light link-light' : 'text-dark link-dark' ?>
            link-offset-3 link-underline-opacity-0 link-underline-opacity-100-hover" href="manage-user.php">User Management</a>
        </li>
    <?php endif ?>
</ul>
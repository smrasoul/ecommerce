

<nav class="navbar navbar-expand-lg bg-light">
    <a class="navbar-brand" href="/index.php">My Shop</a>
    <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['username'])) : ?>
            <li class="nav-item">
                <a class="nav-link" href="/logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
            </li>


            <?php if ( hasPermission('view_product')) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/dashboard.php">Administration</a>
                </li>
        <?php endif; ?>
        <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="/login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/signup.php">Sign Up</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

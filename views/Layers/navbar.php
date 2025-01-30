<nav class="navbar navbar-expand-lg bg-light">
    <a class="navbar-brand" href="/">My Shop</a>
    <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?>
        <li class="nav-item">
            <a class="nav-link" href="/dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout.php">Logout</a>
        </li>
        <?php else : ?>
        <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/signup.php">Sign Up</a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<nav class="px-2 navbar navbar-expand-lg bg-secondary-subtle rounded">
    <a class="navbar-brand" href="/">My Shop</a>
    <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?>
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/logout">Logout</a>
        </li>
        <?php else : ?>
        <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/signup">Sign Up</a>
        </li>
        <?php endif; ?>
    </ul>
</nav>

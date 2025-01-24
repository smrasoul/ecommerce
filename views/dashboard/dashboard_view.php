<?php

function renderDashboard($user, $latestOrder, $activePage, $canViewProduct, $canManageUser) {
    require 'views/Layers/header.php';
    ?>
    <h1 class="my-4">Dashboard</h1>
    <div class="row">
        <div class="col-3">
            <?php require 'views/Layers/sidebar.php'; ?>
        </div>
        <div class="col-9 border rounded p-4">
            <?php require 'dashboard_summary.php'; ?>
        </div>
    </div>
    <?php
    require 'views/Layers/footer.php';
}
?>
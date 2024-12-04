<?php

function is_admin(): bool {
    return isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1;
}

function has_permission($permission) {
    return in_array($permission, $_SESSION['permissions'] ?? []);
}

<?php

require 'includes/init.php';
require 'controllers/ProductController.php';

require 'views/Layers/header.php';

showProducts($conn);

require 'views/Layers/footer.php'; ?>

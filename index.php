<?php

require 'init.php';
require 'controllers/ProductController.php';

require 'views/Layers/header.php';

showProductListPage($conn);

require 'views/Layers/footer.php'; ?>

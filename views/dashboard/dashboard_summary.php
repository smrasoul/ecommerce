<div class="row mb-4 border rounded p-4">
    <div class="row mb-3">
        <h5 class="col-4 border-bottom">Account Information</h5>
    </div>
    <div class="row col-6">
        <label for="firstName" class="col-4 fw-bold">First Name</label>
        <div class="col-8">
            <input type="text" class="form-control-plaintext"
                   id="firstName" name="firstName" readonly value="<?= $user['first_name'] ?>">
        </div>
    </div>

    <div class="row col-6">
        <label for="lastName" class="col-4 fw-bold">Last Name</label>
        <div class="col-8">
            <input type="text" class="form-control-plaintext"
                   id="lastName" name="lastName" readonly value="<?= $user['last_name'] ?>">
        </div>
    </div>
</div>


<div class="row mb-4 border rounded p-4">
    <div class="row mb-3">
        <h5 class="col-3 border-bottom">Latest Order</h5>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Order Number</th>
            <th>Date</th>
            <th>Payment Information</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($latestOrder): ?>
        <tr>
            <td class="align-content-center"><?= htmlspecialchars($latestOrder['order_number']) ?></td>
            <td class="align-content-center"><?= htmlspecialchars($latestOrder['date']) ?></td>
            <td class="align-content-center"><?= htmlspecialchars($latestOrder['payment']) ?></td>
            <td class="align-content-center"><?= htmlspecialchars($latestOrder['status']) ?></td>
            <td class="align-content-center"><a href="#" class="btn btn-warning btn-sm">Details</a></td>
        </tr>
        <?php else: ?>
            <tr>
                <td  colspan="5">No Orders found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>


<?php if ($GLOBALS['canManageUser'] || $GLOBALS['canManageProduct']): ?>
    <div class="border rounded p-4 mb-4 row">
        <div class="row mb-3">
            <h5 class="col-3 border-bottom">Management</h5>
        </div>
        <div class="col-2"></div>
        <?php if ($GLOBALS['canManageUser']): ?>
            <a class="col-3 link-dark link-underline-opacity-0 text-light btn btn-success fw-bold" href="user-management">User
                Management</a>
        <?php endif; ?>
        <div class="col-2"></div>
        <?php if ($GLOBALS['canManageProduct']): ?>
            <a class="col-3 link-dark link-underline-opacity-0 text-light btn btn-success fw-bold" href="product-management">Product
                Management</a>
        <?php endif; ?>
        <div class="col-2"></div>
    </div>
<?php endif; ?>

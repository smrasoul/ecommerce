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
    <?php if ($orders): ?>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td class="align-content-center"><?= htmlspecialchars($order['order_number']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($order['date']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($order['payment']) ?></td>
                <td class="align-content-center"><?= htmlspecialchars($order['status']) ?></td>
                <td class="align-content-center"><a href="#" class="btn btn-warning btn-sm">Details</a></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td  colspan="5">No Orders found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
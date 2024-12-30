<div class="row mb-4">
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

<div class="row mb-4">
    <div class="row col-6">
        <label for="email" class="col-4 fw-bold">Email</label>
        <div class="col-8">
            <input type="email" class="form-control-plaintext"
                   id="email" name="email" readonly value="<?= $user['email']  ?>">
        </div>
    </div>
    <div class="row col-6">
        <label for="username" class="col-4 fw-bold">Username</label>
        <div class="col-8">
            <input type="text" class="form-control-plaintext"
                   id="username" name="username" readonly value="<?= $user['username'] ?>">
        </div>
    </div>
</div>

<div class="d-flex justify-content-end">

    <a class="link-dark link-underline-opacity-0 btn btn-warning" href="edit-account-info.php">Edit information</a>

</div>
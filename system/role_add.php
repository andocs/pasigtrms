<div class="container-fluid"><br />
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Add User Record</li>
    </ol>
    <!-- Page Content -->
    <div class="container">
        <div class="card card-register mx-auto mt-5">
            <div class="card-header">
                <h2>Add New User</h2>
            </div>
            <div class="card-body">
                <form role="form" method="post" action="trms.php?page=roletrans&action=add">
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <input class="form-control" placeholder="Name" name="name" required>
                        </div>
                        <div class="col-6">
                            <input class="form-control" placeholder="Username" name="username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Email Address" name="email" required>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <input type="password" class="form-control" placeholder="********" name="password" required>
                        </div>
                        <div class="col-6">
                            <input type="password" class="form-control" placeholder="********" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-between">
                        <div class="col-6">
                            <select class="form-control" placeholder="Role" name="role" required>
                                <option value="" selected>Select Role</option>
                                <option value="admin" selected>Admin</option>
                                <option value="approver" selected>Approver</option>
                                <option value="encoder" selected>Encoder</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <input type="file" class="form-control" name="picture">
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-default">Save Record</button>
                        <button type="reset" class="btn btn-default">Clear Entry</button>
                        <button type="back" class="btn btn-default" onclick="history.back();">Back</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
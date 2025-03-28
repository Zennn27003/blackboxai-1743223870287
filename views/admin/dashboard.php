<?php require_once 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'includes/admin_nav.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Admin Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text display-4"><?php echo count($users); ?></p>
                            <a href="<?php echo URL_ROOT; ?>/admin/users" class="text-white">View all</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Active Trainings</h5>
                            <p class="card-text display-4">12</p>
                            <a href="<?php echo URL_ROOT; ?>/admin/courses" class="text-white">View all</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Pending Approvals</h5>
                            <p class="card-text display-4">3</p>
                            <a href="<?php echo URL_ROOT; ?>/admin/users" class="text-white">Review</a>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Recent Activities</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Dr. Smith</td>
                            <td>Completed CPR Training</td>
                            <td>2 hours ago</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Nurse Johnson</td>
                            <td>Started HIPAA Course</td>
                            <td>5 hours ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
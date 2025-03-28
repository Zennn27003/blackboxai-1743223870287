<?php require_once 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'includes/trainer_nav.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Trainer Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Upcoming Sessions</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php foreach ($upcoming_sessions as $session): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= htmlspecialchars($session['title']) ?></h6>
                                        <small><?= htmlspecialchars($session['date']) ?> at <?= htmlspecialchars($session['time']) ?></small>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary mt-2">View Details</a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Training Materials</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <?php foreach ($materials as $material): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= htmlspecialchars($material['name']) ?></h6>
                                        <small>Uploaded on: <?= htmlspecialchars($material['upload_date']) ?></small>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-success mt-2">Download</a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
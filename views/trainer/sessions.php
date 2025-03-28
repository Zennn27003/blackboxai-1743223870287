<?php require_once 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'includes/trainer_nav.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Training Sessions</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= URL_ROOT ?>/trainer/sessions/create" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> New Session
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sessions as $session): ?>
                        <tr>
                            <td><?= htmlspecialchars($session['title']) ?></td>
                            <td><?= htmlspecialchars($session['date']) ?></td>
                            <td><?= htmlspecialchars($session['time']) ?></td>
                            <td><?= htmlspecialchars($session['location']) ?></td>
                            <td>
                                <span class="badge bg-<?= 
                                    $session['status'] === 'completed' ? 'success' : 
                                    ($session['status'] === 'cancelled' ? 'danger' : 'primary') 
                                ?>">
                                    <?= ucfirst(htmlspecialchars($session['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= URL_ROOT ?>/trainer/sessions/edit/<?= $session['id'] ?>" 
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= URL_ROOT ?>/trainer/sessions/attendance/<?= $session['id'] ?>" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-clipboard-check"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
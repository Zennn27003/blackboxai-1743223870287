<?php require_once 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'includes/trainer_nav.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Upload Training Material</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= URL_ROOT ?>/trainer/materials" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Materials
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="<?= URL_ROOT ?>/trainer/materials/store" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Select Course</label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <option value="">Choose a course...</option>
                                <!-- Populate with courses from the database -->
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= htmlspecialchars($course['id']) ?>"><?= htmlspecialchars($course['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Material Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Material</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
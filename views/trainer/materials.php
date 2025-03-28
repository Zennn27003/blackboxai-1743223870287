<?php require_once 'includes/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <?php require_once 'includes/trainer_nav.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Training Materials</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?= URL_ROOT ?>/trainer/materials/upload" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-upload me-1"></i> Upload Material
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Upload Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materials as $material): ?>
                        <tr>
                            <td><?= htmlspecialchars($material['name']) ?></td>
                            <td><?= strtoupper(htmlspecialchars($material['file_type'])) ?></td>
                            <td><?= formatSizeUnits($material['file_size']) ?></td>
                            <td><?= htmlspecialchars($material['uploaded_at']) ?></td>
                            <td>
                                <a href="<?= URL_ROOT ?>/trainer/materials/download/<?= $material['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger delete-material" 
                                        data-id="<?= $material['id'] ?>"
                                        data-name="<?= htmlspecialchars($material['name']) ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <strong id="materialName"></strong>?</p>
        <p class="text-danger">This action cannot be undone.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-material');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const materialName = document.getElementById('materialName');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const materialId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            materialName.textContent = name;
            confirmDeleteBtn.href = `<?= URL_ROOT ?>/trainer/materials/delete/${materialId}`;
            
            deleteModal.show();
        });
    });
});
</script>

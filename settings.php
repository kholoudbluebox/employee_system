<?php
session_start();
include 'includes/connect.php';
include 'includes/header.php';

// Fetch roles safely
$roles = $conn->query("SELECT * FROM roles ORDER BY id DESC");
if(!$roles){
    die("Error fetching roles: " . $conn->error);
}
?>

<h2 class="fw-bold text-primary mb-3">Settings ⚙️</h2>

<div class="row">
  <!-- Add Role -->
  <div class="col-md-4">
    <div class="card shadow-sm p-4 border-0">
      <h5 class="mb-3">Add New Role</h5>

      <form method="POST" action="actions/add_role.php">
        <input type="text" name="role_name" class="form-control mb-3"
               placeholder="Enter role name" required>
        <button class="btn btn-primary w-100">Add Role</button>
      </form>
    </div>
  </div>

  <!-- Roles List -->
  <div class="col-md-8">
    <div class="card shadow-sm p-4 border-0">
      <h5 class="mb-3">Existing Roles</h5>

      <?php if($roles->num_rows > 0): ?>
      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th></th>
            <th>Role Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while($r = $roles->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r['id']) ?></td>
            <td><?= htmlspecialchars($r['role_name']) ?></td>
            <td>
              <a href="actions/delete_role.php?id=<?= $r['id'] ?>"
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Delete this role?')">
                 Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
      <?php else: ?>
        <p class="text-muted">No roles found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

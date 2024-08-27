<?php
require_once 'includes/db_connection.php';
require_once 'includes/header.php';
require_once 'includes/session.php';


$stmt = $conn->prepare('SELECT users.name, users.email, users.username, users.picture, roles.role_id, roles.role_name 
    FROM users 
    LEFT JOIN roles ON users.role = roles.role_id 
    WHERE users.userid = ?
');

$stmt->bind_param('i', $_SESSION['userid']);
$stmt->execute();
$stmt->bind_result($name, $email, $username, $picture, $role_id, $role_name);
$stmt->fetch();
$stmt->close();
?>
<div class="container-fluid d-flex flex-column"> </br>
	<!-- Breadcrumbs-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="trms.php?page=homepage">Dashboard</a>
		</li>
		<li class="breadcrumb-item active">Profile</li>
	</ol>
	<h2>My Profile</h2>

	<div class="container">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<form role="form" method="post" action="trms.php?page=profiletrans" enctype="multipart/form-data">
						<input type="hidden" name="user_id" value="<?= $_SESSION['userid'] ?>">
						<div class="row">
							<div class="col-md-4 text-center">
								<h7><?= ucfirst(htmlspecialchars($role_name)) ?></h7>
								<div class="mb-3">
									<img id="profile_picture_preview" src="<?= htmlspecialchars($picture) ?>" class="img-fluid img-thumbnail" alt="Profile Picture" width="150" height="150">
								</div>
								<button type="button" class="btn btn-primary" onclick="document.getElementById('profile_picture').click();">Edit Picture</button>
								<input type="file" class="d-none" id="profile_picture" name="picture" accept="image/png, image/jpeg" onchange="previewProfilePicture(event, 'profile_picture_preview')">
							</div>
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-6">
										<label for="name" class="form-label">Name</label>
										<input class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
									</div>
									<div class="col-6">
										<label for="username" class="form-label">Username</label>
										<input class="form-control" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="form-label">Email Address</label>
									<input class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
								</div>
								<div class="d-flex justify-content-end">
									<button type="submit" class="btn btn-success">Save Changes</button>
									<a href="trms.php?page=homepage" class="btn btn-outline-danger ml-2">Cancel</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		function previewProfilePicture(event, previewElementId) {
			var reader = new FileReader();
			reader.onload = function() {
				var output = document.getElementById(previewElementId);
				output.src = reader.result;
			};
			reader.readAsDataURL(event.target.files[0]);
		}
	</script>
</div>
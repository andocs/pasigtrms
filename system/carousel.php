<?php
if (!hasPermission(10)) {
    redirectTo('warning', 'You do not have access!', 'trms.php?page=unauthorized');
}

// Define directories
$announcementDir = 'uploads/announcements/';
$eventsDir = 'uploads/events/';

// Handle image upload
if (isset($_POST['upload'])) {
    $target_dir = ($_POST['image_type'] == 'announcement') ? $announcementDir : $eventsDir;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if ($check !== false) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Insert image info into the database
            $stmt = $conn->prepare("INSERT INTO carousel_images (image_type, image_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $_POST['image_type'], basename($_FILES["fileToUpload"]["name"]));
            $stmt->execute();
            redirectTo('success',"The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.",'trms.php?page=carousel');
        } else {
        redirectTo('warning','Sorry, there was an error uploading your file.','trms.php?page=carousel');
        }
    } else {
        redirectTo('warning','File is not an image.','trms.php?page=carousel');
    }
}

// Handle image deletion
if (isset($_GET['delete'])) {
    $imageId = $_GET['delete'];
    // Fetch the file name
    $stmt = $conn->prepare("SELECT image_path, image_type FROM carousel_images WHERE id = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $stmt->bind_result($fileName, $type);
    $stmt->fetch();
    $stmt->close();

    $filePath = ($type == 'announcement') ? $announcementDir . $fileName : $eventsDir . $fileName;

    if (file_exists($filePath)) {
        unlink($filePath);
        // Delete image info from the database
        $stmt = $conn->prepare("DELETE FROM carousel_images WHERE id = ?");
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        redirectTo('success','Image deleted successfully.','trms.php?page=carousel');
    } else {
        redirectTo('warning','File does not exist.','trms.php?page=carousel');
    }
}

// Fetch images from database
$query = "SELECT * FROM carousel_images";
$result = mysqli_query($conn, $query);
$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<div class="container-fluid"><br/>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms.php?page=homepage">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Carousel Management</li>
    </ol>
    <h2>Manage Carousel</h2>
    <form action="trms.php?page=carousel" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg" class="form-control">
        </div>
        <div class="form-group">
            <label for="image_type">Image Type:</label>
            <select name="image_type" id="image_type" class="form-control">
                <option value="announcement">Announcement</option>
                <option value="event">Event</option>
            </select>
        </div>
        <button type="submit" name="upload" class="btn btn-primary">Upload Image</button>
    </form>
    <hr>
    <h3>Announcement Images</h3>
    <div class="row">
        <?php foreach ($images as $image) : ?>
            <?php if ($image['image_type'] == 'announcement') : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="uploads/announcements/<?php echo $image['image_path']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Announcement</p>
                            <a href="trms.php?page=carousel&delete=<?php echo $image['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <hr>
    <h3>Event Images</h3>
    <div class="row">
        <?php foreach ($images as $image) : ?>
            <?php if ($image['image_type'] == 'event') : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="uploads/events/<?php echo $image['image_path']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Event</p>
                            <a href="trms.php?page=carousel&delete=<?php echo $image['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
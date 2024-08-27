<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/db_connection.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Fetch images from database
$query = "SELECT * FROM carousel_images";
$result = mysqli_query($conn, $query);
$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="container-fluid"><br />
    <!-- Breadcrumbs -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="trms?page=homepage">
                <h2>Transportation and Regulatory Management System</h2>
            </a>
        </li>
    </ol>
    <!-- Page Content -->
    <div class="container-fluid d-flex flex-column text-black page-content">
        <h3>ANNOUNCEMENTS</h3>
        <div id="announcementsCarousel" class="carousel carousel-dark d-flex slide custom-carousel" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $active = 'active';
                foreach ($images as $image) {
                    if ($image['image_type'] == 'announcement') {
                        echo '<div class="carousel-item ' . $active . '">';
                        echo '<img class="d-block w-auto h-100 m-auto" src="uploads/announcements/'. $image['image_path'] . '" alt="Announcement">';
                        echo '</div>';
                        $active = '';
                    }
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#announcementsCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#announcementsCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <h3>EVENTS</h3>
        <div id="eventsCarousel" class="carousel carousel-dark d-flex slide custom-carousel" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $active = 'active';
                foreach ($images as $image) {
                    if ($image['image_type'] == 'event') {
                        echo '<div class="carousel-item ' . $active . '">';
                        echo '<img class="d-block w-auto h-100 m-auto" src="uploads/events/' . $image['image_path'] . '" alt="Event">';
                        echo '</div>';
                        $active = '';
                    }
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#eventsCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#eventsCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
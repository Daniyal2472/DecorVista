<?php
include("header.php");
if ($_SESSION['role'] !== 'User') {
    echo "<script>
    window.location.href = 'login.php';
    </script>";
    exit();
  }

$user_id = $_SESSION['user_id'];

// SQL query to fetch data from `wishlist`
$sql = "SELECT
    w.id, 
    ig.image_url 
FROM 
    wishlist w
JOIN 
    inspiration_gallery ig ON w.gallery_id = ig.inspiration_id
WHERE 
    w.user_id = ?;  -- Replace ? with the actual user_id or bind it in prepared statements
";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_GET['delete_id'])) {
    $inspiration_id = intval($_GET['delete_id']); // Sanitize input

    // SQL query to delete the item from the wishlist
    $deleteQuery = "DELETE FROM `wishlist` WHERE `id` = ?";
    $deleteStmt = $con->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $inspiration_id);

    if ($deleteStmt->execute()) {
        echo "<script>alert('Image deleted successfully');</script>";
        echo "<script>window.location.href='whishlist.php';</script>"; // Redirect to refresh the page
    } else {
        echo "<script>alert('Error deleting image: " . $con->error . "');</script>";
    }

    $deleteStmt->close();
}

$stmt->close();
?>

<style>
    :root {
        --surface-color: #fff;
        --curve: 40;
    }

    h1 {
        text-align: center;
        margin: 20px 0;
        color: #6A515E;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        list-style-type: none;
        padding: 20px 0; /* Added padding for top and bottom spacing */
    }

    .card {
        position: relative;
        display: block;
        height: 100%;
        border-radius: calc(var(--curve) * 1px);
        overflow: hidden;
        text-decoration: none;
    }

    .card__image {
        width: 100%;
        height: auto;
    }

    .card__overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1;
        border-radius: calc(var(--curve) * 1px);
        background-color: var(--surface-color);
        transform: translateY(100%);
        transition: .2s ease-in-out;
    }

    .card:hover .card__overlay {
        transform: translateY(0);
    }

    .card__buttons {
        display: flex;
        justify-content: space-around;
        padding: 1em;
    }

    .btn {
        padding: 0.5em 1em;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-delete {
        background-color: #c0392b; /* Dark Red for delete */
    }

    .btn-detail {
        background-color: black; /* Blue for detail */
    }

    .btn-delete:hover {
        background-color: #a83224; /* Darker Red on hover */
    }

    .btn-detail:hover {
        background-color: #24d278; /* Darker Blue on hover */
    }
</style>

<div class="heading_container pt-4 justify-content-center">
    <h2>Your Saved Images</h2>
</div>    

<ul class="cards">
    <?php 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            ?>
            <li>
                <a href="#" class="card">
                    <img src="../admin/uploads/gallery/<?php echo $row['image_url']; ?>" class="card__image" alt="Image" />
                    <div class="card__overlay">
                        <div class="card__buttons">
                            <!-- Form for Delete button -->
                            <form method="GET" action="whishlist.php" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </a>
            </li>
            <?php
        }
    } else {
        echo "<p>No images found in the gallery.</p>";
    }
    ?>
</ul>

<?php
include("footer.php");
?>
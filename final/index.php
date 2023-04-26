<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Demo (Hello world edition)</title>

        <link href="vendor/bootstrap.min.css" rel="stylesheet">
        <link href="ui.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="vendor/jquery.min.js"></script>
    
        <!-- Bootstrap JS -->        
        <script src="vendor/bootstrap.bundle.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->
        
        <!-- thumbnail grid -->
        <script src="thumbnail-grid.js"></script>

        <!-- input validator -->
        <script src="input-validator.js"></script>

        <!-- sql to thumbnail grid interop -->
        <script src="sql-backend.php"></script>


    </head>
    <body>
        <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        session_start();
        $db_host = "localhost";
        $db_username = "cen4010sp23g03";
        $db_password = "ASpring#2023";
        $db_name = "cen4010sp23g03";
        $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);
        if (!$db) { die("No connection to MySQL database!" . mysqli_connect_error()); }
        
        ?>
        <!-- top area -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="logo.png" alt="Overview logo" height="50" class="d-inline-block align-text-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <form>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php
                                        if (isset($_SESSION["user_id"]))
                                        {
                                            $userid = $_SESSION["user_id"];
                                            $result = mysqli_query($db, "SELECT username FROM user_accounts WHERE user_id = '$userid'");
                                            if ($row = mysqli_fetch_assoc($result)) 
                                            {
                                                echo $row["username"];
                                            }
                                            else
                                            {
                                                echo "username";
                                            }
                                        }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#save-new-image-modal" href="#">Save New Image</a></li>
                                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </form>
                    <div class="container">
                        <form class="mx-auto" id="search-form" method="post" action="index.php">
                            <div class="input-group">
                                <input type="text" class="form-control me-2" id="search-box" placeholder="Find images with a given tag" name="searchbox">
                                <button class="btn btn-primary" id="search-button" type="submit">Search</button>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Save New Image Modal -->
        <div class="modal fade" id="save-new-image-modal" tabindex="-1" aria-labelledby="save-new-image-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="save-new-image-modal-label">Save a new image</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <form id="save-new-image-modal-form" method="post" action="index.php">
                            <div class="mb-3">
                                <label for="image-url" class="col-form-label">Image URL:</label>
                                <input type="text" class="form-control" id="image-url-modal-input-field" name="imageurl_input" required>
                            </div>
                            <div class="mb-3">
                                <label for="image-tags" class="col-form-label">Specify tags for this image (use , to delimit):</label>
                                <textarea class="form-control" id="image-tags" name="imagetags_input" required></textarea>
                            </div>
                            <div id="modal-info-area"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Image Modal -->
        <div class="modal fade" id="manage-image-modal" tabindex="-1" aria-labelledby="manage-image-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="manage-image-modal-label">Delete this image?</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="manage-image-modal-form" method="post" action="index.php">
                            <div class="mb-3">
                                <label for="image-url" class="col-form-label">Image URL:</label>
                                <input type="text" class="form-control" id="manage-image-modal-url-input-field" name="manage_imageurl_input" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags column -->
        
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="tags-column">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Tags</h4>
                                <ul class="list-group tag-list" id="the-tag-list">
                                    <!-- tag list generated by thumbnail-grid.js -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <!-- Thumbnail grid -->
        <div class="container-fluid">
            <div class="row" id="thumbnail-grid-notification-area">
                <!-- generated from notification.js -->
            </div>
            <div class="row" id="thumbnail-grid">
                <!-- generated from thumbnail-grid.js -->
            </div>
        </div>

        <script>validate_image_url();</script>

        <!-- php -->
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if ($_POST["imageurl_input"] && $_POST["imagetags_input"])
            {
                $image_url = $_POST["imageurl_input"];
                $image_tags = $_POST["imagetags_input"];

                session_start();
                if(!isset($_SESSION["user_id"]))
                {
                    echo "User is not logged in!"; // shouldn't really happen as the plan is make save image function work only when session token is set
                    exit;   
                }
                $userid = $_SESSION["user_id"]; // matches user_id found in SQL DB

                // get sha256 hash of image found at url and filename based on url
                $image_sha256 = hash('sha256', file_get_contents($image_url));

                $stmt = $db->prepare('INSERT INTO images (user_id, image_hash, url, tags) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('isss', $userid, $image_sha256, $image_url, $image_tags);
                $stmt->execute();

                $b64 = base64_encode(json_encode($rows));
                echo '<script>set_notification_success();</script>';
                echo "<script>process_sql('$b64', '$query');</script>";
            }
            else if($_POST["manage_imageurl_input"])
            {
                session_start();
                if(!isset($_SESSION["user_id"]))
                {
                    echo "User is not logged in!";
                    exit;
                }

                $userid = $_SESSION["user_id"];
                $image_url = $_POST["manage_imageurl_input"];

                $stmt = $db->prepare('DELETE FROM images WHERE url = ?');
                $stmt->bind_param('s', $image_url);
                $stmt->execute();

                // todo: show delete success notif

            }
            else if ($_POST["searchbox"])
            {
                session_start();
                if(!isset($_SESSION["user_id"]))
                {
                    echo "User is not logged in!"; // shouldn't happen...
                    exit;
                }

                $userid = $_SESSION["user_id"];
                $query = $_POST["searchbox"];
                $b64 = "";
                if ($query == "user:all")
                {
                    $stmt = $db->prepare("SELECT * FROM images WHERE user_id = '$userid' LIMIT 15");
                    $stmt->execute();
                    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $b64 = base64_encode(json_encode($results));                    
                }
                else
                {
                    $prefix = substr($query, 0, 3);
                    $logical_operation = "AND";
                    if($prefix == "OR:")
                    {
                        $logical_operation = "OR";
                        $query = substr($query, 3);
                    }
                    
                    $substrings = explode(",", $query);
                    $sql = "SELECT * FROM images WHERE user_id = '$userid' AND ";
                    $placeholders = "";
                    foreach($substrings as $substring)
                    {
                        $placeholders .= "tags LIKE CONCAT('%', ?, '%') " . $logical_operation . " ";
                    }
                    $placeholders = rtrim($placeholders, " " . $logical_operation . " ");
                    $sql .= $placeholders;
                    $stmt = $db->prepare($sql);
    
                    $bind_params = array(str_repeat("s", count($substrings)));
                    foreach($substrings as $index => $substring) {
                        $bind_params[] = &$substrings[$index];
                    }
                    call_user_func_array(array($stmt, 'bind_param'), $bind_params);
                    
                    $stmt->execute();
                    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                    $b64 = base64_encode(json_encode($results));
                }
                $original_query = $_POST["searchbox"];
                echo "<script>process_sql('$b64', '$original_query');</script>";
            }   
        }
        else if(isset($_SESSION["user_id"]))
        {
            // populate thumbnail grid with first 15 entries of user's saved images - also populate tag list
            $userid = $_SESSION["user_id"];

            $stmt = $db->prepare('SELECT * FROM images WHERE user_id = ? LIMIT 15');
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = array();
            while($row = $result->fetch_assoc()) { $rows[] = $row; }
            if (!$rows) { echo "<script>console.log('rows php variable was empty!');</script>"; }

            $query = "user:all";
            $b64 = base64_encode(json_encode($rows));
            echo "<script>process_sql('$b64', '$query');</script>";
        }
        ?>
    </body>
</html>

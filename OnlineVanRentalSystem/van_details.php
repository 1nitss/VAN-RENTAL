<?php
session_start();
?>

<?php
if (!(isset($_SESSION['username']))) {
    echo "Please Log in Your Account First, Redirecting...";
    header("Refresh: 3 ; url = login.php");
} else {
    require "connection.php";

    $query = mysqli_query($connect, "SELECT * FROM `user_account` WHERE '" . $_SESSION['username'] . "' = username and '" . $_SESSION['password'] . "' = password");
    $row = mysqli_fetch_array($query);
    $userNo = $row['user_no'];
    $_SESSION['imp'] = $row['user_no'];
    $_SESSION['full name'] = $row['full_name'];


    if (isset($_GET['vanId'])) {
        $vanId = $_GET['vanId'];
        $_SESSION['Global_van'] = $_GET['vanId'];
        $showInfo = mysqli_query($connect, "SELECT * FROM van_information JOIN shop_owner ON van_information.owner_id = shop_owner.owner_id AND van_no = '".$vanId."'");
        $row1 = mysqli_fetch_array($showInfo);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Details</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="bootstrap/js/bootstrap.js"></script>
        <link rel="stylesheet" href="css/vanDetailsStyles.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/fonts.css">
        <link rel="stylesheet" href="fontawesome/css/all.css">
        <link rel="stylesheet" href="css/star_rating.css">
        <script src="jquery.js"></script>
        <script src="rate.js"></script>
    </head>

    <body>
        <div class="hero">
            <nav>
                <img src="Images/rentavan_logo.png" alt="RentAvan" class="logo" style="width: 200px">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="transaction.php">Transactions</a></li>
                    <li><a href="search.php">Search</a></li>
                </ul>
                <img src="<?php if ($row["profile_pic"] === "") {
                    echo "profile_pictures/default_profile_picture.png";
                } else {
                    echo "profile_pictures/" . $row['profile_pic'];
                } ?>" alt="RentAvan" class="user-pic" onclick="toggleMenu()">
                <a href="user_profile.php">
                    <?php echo $row["full_name"]; ?>
                </a>

                <form action="logout.php" method="post">
                    <div class="sub-menu-container" id="subMenu">
                        <div class="sub-menu">
                            <div class="user-info">
                                <img src="<?php if ($row["profile_pic"] === "") {
                                    echo "profile_pictures/default_profile_picture.png";
                                } else {
                                    echo "profile_pictures/" . $row['profile_pic'];
                                } ?>" alt="RentAvan" class="user-pic" onclick="toggleMenu()">
                                <h3>
                                    <?php echo $row["full_name"]; ?>
                                </h3>
                            </div>
                            <hr>
                            <a href='update_profile.php?user_no=<?php echo $userNo ?>' class="sub-menu-link">
                                <img src="icons/profile-user.png" alt="">
                                <p>edit profile</p>
                                <span>></span>
                            </a>

                            <a href="favorite.php" class="sub-menu-link">
                                <img src="icons/favorite (1).png" alt="">
                                <p>Favorites</p>
                                <span>></span>
                            </a>

                            <a href="" class="sub-menu-link">
                                <img src="icons/log-out.png" alt="">
                                <input type="submit" class="btn btn-danger" value="Log Out" name="logout">
                                <span style="margin-left: 43%">></span>
                            </a>
                        </div>
                    </div>
                </form>
            </nav>
        </div><br>
        <?php

        if (isset($_POST['comment'])) {
            $vanNo = $_SESSION['Global_van'];
            $ratings = $_POST['rating'];
            $comment = $_POST['user_comment'];
            $curr_date = date('Y-m-d H:i:s');

            $addComments = "INSERT INTO comment VALUES('', '".$_SESSION['imp']."', '$vanNo', '$comment', '$ratings', '$curr_date')";

            $insertQuery = $connect->query($addComments);
            if ($insertQuery) {
                header('refresh: 2 ; url = van_details.php?vanId=' . $vanId . '');
            }

        }

        ?>
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php if ($row1["van_image"] === "") {
                        echo " https://dummyimage.com/600x700/dee2e6/6c757d.jpg";
                    } else {
                        echo "shop_owner/img/" . $row1['van_image'];
                    } ?>" alt="..." /></div>
                    <div class="col-md-6">
                    <p class="lead">
                            <?php echo $row1['full_name'] ?>
                        </p>
                        <h1 class="display-5 fw-bolder">
                            <?php echo $row1['van_model'] ?>
                        </h1>
                        <p class="lead">
                            <?php echo $row1['van_name'] ?>
                        </p>
                        <div class="fs-5 mb-5">
                            <span>
                                <?php echo $row1['price'] ?> Pesos per day
                            </span>
                            
                        <p class="lead">
                            <?php echo $row1['description'] ?>
                        </p>
                        </div>
                        <div class="d-flex">
                            <a href="complete_info.php?id=<?php echo $row1['van_no'] ?>"><input class="btn btn-primary" value="Rent Now" name="rent"></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr style="margin-left:5%; margin-right: 5%">
        <form action="" method="post">
            <div class="container bootdey">
                <div class="col-md-12 bootstrap snippets">
                    <div class="panel">
                        <div class="panel-body">
                            <textarea class="form-control" rows="2" placeholder="Type your feedback here"
                                name="user_comment"></textarea><br>
                            <div style = 'z-index: 0'class="rateyo" id="rating" data-rateyo-rating="4" data-rateyo-num-stars="5"
                                data-rateyo-score="3">
                            </div>

                            <span class='result'>0</span>
                            <input type="hidden" name="rating">
                            <div class="mar-top clearfix">
                                <button class="btn btn-sm btn-primary pull-right" type="submit" name="comment"> Send <i
                                        class="fa-solid fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php

                    $selectAll = "SELECT user_account.full_name, user_account.profile_pic, comment.comment_no, comment.comment, comment.rating,comment.date 
                    FROM comment 
                    INNER JOIN user_account ON comment.user_no = user_account.user_no
                    WHERE comment.van_no = '".$_SESSION['Global_van']."'";
                    $dataset2 = $connect->query($selectAll);
                    if ($dataset2) {
                        while ($data = $dataset2->fetch_assoc()) {
                            ?>
                            <div class='panel'>
                            <div class='panel-body'>
                                <div class='media-block'>
                                    <p class='media-left'><img class='img-circle img-sm' alt='Profile Picture'
                                            src='profile_pictures/<?php echo $data['profile_pic'] ?>'></p>
                                    <div class='media-body'>
                                        <div class='mar-btm'>
                                            <h5 class='text-semibold media-heading box-inline'><?php echo $data['full_name'] ?></h5>
                                            <p class='text-muted text-sm'><?php $data['date'] ?></p>

                                        </div>
                                        <p>
                                            <?php echo $data['comment'] ?>
                                        </p>
                                        <p class='text-muted text-sm' style = 'color: grey!important'>Ratings: <?php
                                        
                                        if($data['rating'] == 5.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] == 4.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] == 3.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] == 2.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }
                                        elseif($data['rating'] == 1.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] == 0.0){
                                            echo "<i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] < 5.0 && $data['rating'] > 4.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star-half-stroke' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] < 4.0 && $data['rating'] > 3.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star-half-stroke' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] < 3.0 && $data['rating'] > 2.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star-half-stroke' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] < 2.0 && $data['rating'] > 1.0){
                                            echo "<i class='fa-solid fa-star' style = 'color: yellow'></i><i class='fa-solid fa-star-half-stroke' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }elseif($data['rating'] < 1.0 && $data['rating'] > 0.0){
                                            echo "<i class='fa-solid fa-star-half-stroke' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i><i class='fa-regular fa-star' style = 'color: yellow'></i>";
                                        }
                                        ?></p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }

                    ?>
                    <!-- comment -->

                    <!-- Comment -->
                </div>
            </div>
        </form>
        <script>


            $(function () {
                $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
                    var rating = data.rating;
                    $(this).parent().find('.score').text('score :' + $(this).attr('data-rateyo-score'));
                    $(this).parent().find('.result').text('rating :' + rating);
                    $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
                });
            });

        </script>
        <script>
            let subMenu = document.getElementById("subMenu");
            function toggleMenu() {
                subMenu.classList.toggle("open-menu");
            }
        </script>
    </body>

    </html>
<?php } ?>
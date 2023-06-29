<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/fonts.css">
    <title>Product Landing Page</title>
</head>

<body>
    <nav>
        <div class="logo"><img src="Images/rentavan_logo.png" alt="" width="200px"></div>
        <!-- toggle menu button -->
        <span class="menubtn" onclick="openNav()">&#9776;</span>

        <div class="navLinks">
            <ul>
                <button type="button" style="background-color: rgb(243, 42, 42);">HOME</button>
                <li><a href="signup.php">SIGN UP</a></li>
                <li><a href="login.php">LOG IN</a></li>
            </ul>
        </div>
    </nav>
    <div class="sideNav" id="sidenav">
        <a href="#" class="closeBtn" onclick="closeNav()"> &#10006;</a>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
        <a href="#">Login</a>
    </div>

    <div class="row">
        <div class="column1">
            <h1>RentAVan</h1>
            <p>Drive your journey with ease, rent a van online today!</p>
            <button style="background-color: rgb(243, 42, 42);" id = 'myButton'>BE OUR PARTNER</button>
            <script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "shop_owner/signup.php";
    };
</script>
        </div>
        <div class="column2">
            <img src="Images/19MBSprinter.png" alt="banner" width="600px">
        </div>
    </div>
    <div>
        <center>
            <p style="text-align: center; margin: 50px; font-size: 17px;">RentAVan provides an unlimited selection of
                vans for rental. With its easy-to-use platform, you can rent a van with just one tap, making the process
                faster and more convenient than ever before. The company offers a wide range of van sizes and models to
                suit your transportation needs, so you can choose the perfect van for your trip. Whether you need a
                small passenger van or a larger commercial one, RentAVan has got you covered with its user-friendly
                platform and wide selection of vans.</p>
        </center>
    </div>

    <script>
        function openNav() {
            document.getElementById("sidenav").style.width = "50%";
        }
        function closeNav() {
            document.getElementById("sidenav").style.width = "0%";
        }
    </script>

</body>

</html>
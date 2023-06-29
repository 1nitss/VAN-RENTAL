<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/signupStyles.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../sweet alert/sweetalert2.min.css">
    <script src="../sweet alert/sweetalert2.js"></script>
</head>
<body>
    
<?php 
    
    if(isset($_POST['register'])){
        $_SESSION['fname'] = $_POST['full_name'];
        $_SESSION['user_name'] = $_POST['username'];
    $_SESSION['pass'] = $_POST['password'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['birthday'] = $_POST['birthday'];
    $_SESSION['region'] = $_POST['region'];
    $_SESSION['city'] = $_POST['city'];
    $_SESSION['street2'] = $_POST['street'];
    $_SESSION['zip'] = $_POST['zipcode'];
    $_SESSION['p_no'] = $_POST['phone'];
    
    header("location: payment.php");
    }

    ?>
    <div class="page-content">
        <div class="form-v10-content">
            <form class="form-detail" method="post">
                <div class="form-left">
                    <h2>General Infomation</h2>
                    <div class="form-row">
                        <input type="text" name="full_name" class="input-text" placeholder="Full Name" required>
                        <span class="select-btn">
                            <i class="zmdi zmdi-chevron-down"></i>
						</span>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="text" name="username"  class="input-text" placeholder="Username" required>
						</div>

						<div class="form-row form-row-2">
							<input type="password" name="password"class="input-text" placeholder="Password" required>
						</div>
					</div>
                    
                    <div class="form-row">
                        <select name="gender">
                            <option value="position">Select Gender</option>
                            <option value="Male">Male</option>
						    <option value="Female">Female</option>
						    <option value="Others">Others</option>
						</select>
					</div>
                    
                    <div class="form-row">
                        &nbsp&nbsp<label for="">Birthday</label>
						<input type="date" name="birthday" class="company" id="company"required>
					</div>
                </div>
                
                <div class="form-right">
                    <h2>Contact Details</h2>
                    <div class="form-row">
                        <input type="text" name="region" class="street" placeholder="Region" required>
                    </div>

                    <div class="form-row">
                        <input type="text" name="city" class="street" placeholder="City" required>
                    </div>

                    <div class="form-row">
                        <input type="text" name="street" id="your_email" class="input-text" placeholder="Street">
                    </div>
                    
                    <div class="form-group">
                        <div class="form-row form-row-1">
                            <input type="number" name="zipcode" class="code" placeholder="Zip Code" required>
                        </div>
                        
                        <div class="form-row form-row-2">
                            <input type="text" name="phone" class="phone" id="phone" placeholder="Phone Number" required>
                        </div>
                    
                    </div>
                    <div class="form-checkbox">
                        <label class="container"><p>I do accept the <a href="#" class="text">Terms and Conditions</a> of your site.</p>
                            <input type="checkbox" name="checkbox" required>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="form-row-last">
                        <input type="submit" name="register" class="register" value="Sign Up Now"><br>
                        <a href="login.php" style="color: white;text-decoration: none;" class="login">OR LOG IN YOUR ACCOUNT</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
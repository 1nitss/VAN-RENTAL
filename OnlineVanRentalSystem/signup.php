<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/signupStyles.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="sweet alert/sweetalert2.min.css">
    <script src="sweet alert/sweetalert2.js"></script>
</head>
<body>
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
                        <input type="submit" name="register" class="register" value="Sign Up Now">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php 
    
    if(isset($_POST['register'])){
        require_once "connection.php";
        $fullname=mysqli_real_escape_string($connect, $_POST['full_name']);
        $username=mysqli_real_escape_string($connect, $_POST['username']);
        $password=mysqli_real_escape_string($connect, $_POST['password']);
        $gender=mysqli_real_escape_string($connect, $_POST['gender']);
        $birthday=mysqli_real_escape_string($connect, $_POST['birthday']);
        $region=mysqli_real_escape_string($connect, $_POST['region']);
        $city=mysqli_real_escape_string($connect, $_POST['city']);
        $street=mysqli_real_escape_string($connect, $_POST['street']);
        $zipcode=mysqli_real_escape_string($connect, $_POST['zipcode']);
        $phone=mysqli_real_escape_string($connect, $_POST['phone']);

        $addQuery = "INSERT INTO `user_account`(`user_no`, `profile_pic`, `full_name`, `username`, `password`, `gender`, `birthday`, `phone_number`, `street`, `city`, `region`, `zip_code`) VALUES ('','default_profile_picture.png','$fullname','$username','$password','$gender','$birthday','$phone','$street','$city','$region','$zipcode')";

        $dataset=$connect->query($addQuery)or die("Error Query");

		if ($dataset){
			echo "<script>Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'The record has been added',
			  showConfirmButton: false,
			  timer: 2000
			})</script>";
            $_SESSION['uname'] = $username;
            $_SESSION['pass'] = $password;
            header("Refresh: 3 ;url=login.php");
		}
    }

    ?>
</body>

</html>
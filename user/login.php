<?php
include '../connection.php';
if(isset($_SESSION['admin_name']))
{
    header("location:./user");
    exit();
}


if(isset($_POST['submit']))
{
    $username  = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username))
    {
        $_SESSION['errorMsg']="Enter username";
        header("location: ./login.php");
        exit();
    }
    else if(empty($password))
    {
        $_SESSION['errorMsg']="Enter password";
        header("location: ./login.php");
        exit();
    }
    else
    {

        //password bcrypt
        $hashPassword= hash('sha256',$password);


        //check user validation
        $q= "SELECT `admin_name`,`login_status` FROM `admin` WHERE `user_name`='$username' AND `password`='$hashPassword'";
        $result = mysqli_query($con,$q);
        
        if($result->num_rows==1)
        {
            $row = $result->fetch_assoc();
            $status = $row['login_status'];
            
            if($status=='blocked')
            {
                $_SESSION['errorMsg']="Your account have been blocked";
                header("location: ./login.php");
                exit();
            }
            else
            {
                $_SESSION['user_name']=$userame;
                header('location: member/');
                exit();
            }
        }
        else
        {
            $_SESSION['errorMsg']="Wrong username or password";
            header("location: ./login.php");
            exit();
        }

        
    }





}


?>

<!doctype html>
<html lang="en">
<head>
    
        <meta charset="utf-8">
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
        <meta content="Themesbrand" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">
    
        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
    
    </head>

    <body>

        <!-- Loader -->
            <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

         <!-- Begin page -->
         <div class="accountbg" style="background: url('../assets/images/bg.jpg');background-size: cover;background-position: center;"></div>

        <div class="account-pages mt-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                            <?php
								if(isset($_SESSION['errorMsg']))
								{
									echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<strong>Error!</strong> '.$_SESSION['errorMsg'].'
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>';
										unset($_SESSION['errorMsg']);
								}

								if(isset($_SESSION['successMsg']))
								{
									echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
									<strong>Success!</strong> '.$_SESSION['successMsg'].'
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>';

									unset($_SESSION['successMsg']);
								}
								?>
                               <form method="POST" action="login.php"> <!-- Corrected action attribute -->
    <div class="text-center mt-4">
        <div class="mb-3">
            <a href="index.html"><img src="../assets/images/logo.png" height="30" alt="logo"></a>
        </div>
    </div>
    <div class="p-3">
        <h4 class="font-size-18 mt-2 text-center">Welcome Back !</h4>
        <p class="text-muted text-center mb-4">Sign in to continue to Admiria.</p>

        <!-- Corrected name attributes -->
        <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
        </div>

        <div class="mb-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
        </div>

        <div class="row mt-4">
            <div class="col-sm-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="customControlInline">
                    <label class="form-check-label" for="customControlInline">
                        Remember me
                    </label>
                </div>
            </div>
            <div class="col-sm-6 text-end">
                <button class="btn btn-primary w-md waves-effect waves-light" type="submit" name="submit">Log In</button>
            </div>
        </div>

        <div class="mb-0 row">
            <div class="col-12 mt-4">
                <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
            </div>
        </div>
    </div>
</form>

                            </div>
                        </div>
                        <div class="mt-5 text-center position-relative">
                            <p class="text-white">Don't have an account ? <a href="pages-register.html" class="fw-bold text-primary"> Signup Now </a> </p>
                            <p class="text-white"><script>document.write(new Date().getFullYear())</script> © Admiria. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>

                             
        <!-- JAVASCRIPT -->
        <script src="../assets/libs/jquery/jquery.min.js"></script>
        <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="../assets/libs/simplebar/simplebar.min.js"></script>
        <script src="../assets/libs/node-waves/waves.min.js"></script>

        <script src="../assets/js/app.js"></script>

</body>
</html>

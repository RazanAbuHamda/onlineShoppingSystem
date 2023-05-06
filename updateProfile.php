<?php
session_start();
require_once("DbConect.php");

if (isset($_POST['findButton'])) {
    $_SESSION['searchString'] = $_POST['searchInput'];
    header("Location:searchResultPage.php");
}
if (isset($_POST['UpdateData']) && isset($_SESSION['cno']) || isset($_POST['cname']) || isset($_POST['cstreet']) || isset($_POST['ccity']) || isset($_POST['cstate']) || isset($_POST['czip']) || isset($_POST['cphone']) || isset($_POST['cemail']) || isset($_POST['cpass'])) {
    $cno = $_SESSION['cno'];
    if (!empty($_POST['cname'])) {
        $cname = $_POST['cname'];
    }
    if (!empty($_POST['cstreet'])) {
        $cstreet = $_POST['cstreet'];
    }
    if (!empty($_POST['ccity'])) {
        $ccity = $_POST['ccity'];
    }
    if (!empty($_POST['cstate'])) {
        $cstate = $_POST['cstate'];
    }
    if (!empty($_POST['czip'])) {
        $czip = $_POST['czip'];
    }
    if (!empty($_POST['cphone'])) {
        $cphone = $_POST['cphone'];
    }
    if (!empty($_POST['cpass'])) {
        $cpass = mysqli_real_escape_string($con, $_POST['cpass']);
        $Hash = password_hash($cpass, PASSWORD_DEFAULT);
    }
    if (!empty($_POST['cemail'])) {
        $cemail = $_POST['cemail'];
    }

    $sql = "SELECT * FROM customers where cno='" . $_SESSION['cno'] . "'";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if (empty($_POST['cname'])) {
            $cname = $row['cname'];
        }
        if (empty($_POST['cstreet'])) {
            $cstreet = $row['street'];
        }
        if (empty($_POST['ccity'])) {
            $ccity = $row['city'];
        }
        if (empty($_POST['cstate'])) {
            $cstate = $row['state'];
        }
        if (empty($_POST['czip'])) {
            $czip = $row['zip'];
        }
        if (empty($_POST['cphone'])) {
            $cphone = $row['phone'];
        }
        if (empty($_POST['cpass'])) {
            $cpass = mysqli_real_escape_string($con, $row['password']);
            $Hash = password_hash($cpass, PASSWORD_DEFAULT);
        }
        if (empty($_POST['cemail'])) {
            $cemail = $row['email'];
        }
    }


    $query = "UPDATE customers SET cname='$cname' , city='$ccity',
                            street='$cstreet',state='$cstate',zip='$czip', phone='$cphone',
                            email='$cemail',password='$Hash' WHERE cno='$cno'";

    $result = mysqli_query($con, $query);
    if (mysqli_query($con, $result)) {
        header('Location:updateProfile.php');
    }
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Web Shopping Application New Customer Login Page</title>
        <style>

            h1 {
                text-align:center;
                color:green;
            }
            body {
                /*width:70%;*/
                text-align:center;
            }
            .container .box {
                text-align:center;
                display : flex;
                flex-direction : row;
                justify-content: center;

            }


            .container .box .box-cell.box1 {
                text-align:justify;
                float: left;
                display: inline-block;  
                margin: 2px;
                border: 1px solid green;
                padding: 4px;

            }
            .container .box .box-cell.box2 {
                text-align:justify;
                float:right;
                margin: 2px;
                border: 1px solid green;
                padding: 4px;

            }
            .box-row{
                border: 5px solid #FFFF00;
                justify-content: center;
                padding: 4px;
                margin: 10px;
            }
            label {
                display: inline-block;
                width: 150px;
                padding: 7.5px 8px;
                /*margin-right:15px;*/
            }
            input {
                padding: 7px 15px;
                margin-bottom: 5px;
            }
            button {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
                border: 2px solid green;
                height: 30px;
                width: 120px;
                border-radius: 5px;
            }
            a,input{
                padding: 5px;

            }
        </style>
    </head>
    <body>
        <?php
        if (isset($_SESSION['cno'])) {
            $sql = "SELECT cname FROM customers where cno='" . $_SESSION['cno'] . "'";
            $result = mysqli_query($con, $sql);
        }
        if (!mysqli_query($con, $sql)) {
            echo("Error description: " . mysqli_error($con));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <h2>Welcome to the Web Shopping Application System<br>Welcome <?php echo $row['cname']; ?></h2><?php
            }
        }
        ?>
        <form method = "post" action="">
            <div class="container">
                <div class="box">
                    <div class="box-cell box1">
                        <h2 style="text-align: left;">Customer Menu</h2><br>
                        <a href="checkOut.php">CheckOut</a><br><br><br>
                        <a href="checkOrderStatus.php">Check Order State</a><br><br><br>
                        <a href="updateProfile.php">Update Profile</a><br><br><br>
                        <a href="viewEditCart.php">View Edit Cart</a><br><br><br>
                        <a href="logOut.php">Logout</a><br><br><br><br>                       
                        <div style="text-align: center;">
                            <label><strong>Search By Keyword</strong></label><br>
                            <input type="text" name="searchInput">
                            <button type="submit" name="findButton">Find</button>
                        </div>


                    </div>

                    <div class="container" >
                        <div class="box">
                            <div class="box-cell box1">
                                <label>Name: </label><br>
                                <hr>
                                <label>street: </label><br>
                                <hr>
                                <label>City: </label><br>
                                <hr>
                                <label>State: </label><br>
                                <hr>
                                <label>zip: </label><br>
                                <hr>
                                <label>phone: </label><br>
                                <hr>
                                <label>E-mail Address: </label><br>
                                <hr>
                                <label>password: </label>

                            </div>
                            <div class="box-cell box2">
                                <input type="text" name="cname"><br><br>
                                <input type="text" name="cstreet"><br><br>                
                                <input type="text" name="ccity"><br><br>                 
                                <input type="text" name="cstate"><br><br>                   
                                <input type="text" name="czip"><br><br>                
                                <input type="text" name="cphone"><br><br>               
                                <input type="text" name="cemail"><br><br>                     
                                <input type="text" name="cpass">
                            </div><br><br>
                        </div>

                        <button name="UpdateData">Upadte</button>
                    </div><br><br>

                </div>

            </div>
        </form>
    </body>
</html>
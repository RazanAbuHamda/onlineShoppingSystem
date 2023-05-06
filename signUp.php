<?php
session_start();
require_once("DbConect.php");
if (isset($_POST['proceedButton'])) {
    if (isset($_POST['cname']) || isset($_POST['cstreet']) || isset($_POST['ccity']) || isset($_POST['cstate']) || isset($_POST['czip']) || isset($_POST['cphone']) || isset($_POST['cemail']) || isset($_POST['cpass'])) {
        $cname = $_POST['cname'];
        $cstreet = $_POST['cstreet'];
        $ccity = $_POST['ccity'];
        $cstate = $_POST['cstate'];
        $czip = $_POST['czip'];
        $cphone = $_POST['cphone'];
        $cpass = mysqli_real_escape_string($con, $_POST['cpass']);
        $cemail = $_POST['cemail'];
        $emailQuery = "select * from customers where email='" . $cemail."'";
        $result = mysqli_query($con, $emailQuery);
        if (mysqli_fetch_assoc($result)) {
            echo "This email is already signed up !";
        } else {
            $Hash = password_hash($cpass, PASSWORD_DEFAULT);
            $query = " INSERT INTO customers (cname,street,city,state,zip,phone,email,password)"
                    . " values ('$cname', '$cstreet', '$ccity', '$cstate', '$czip', '$cphone','$cemail',  '$Hash')";
            $result = mysqli_query($con, $query);
            echo "sucssessfully added";
            header("location:index.php");
        }
    }
}
mysqli_close($con);
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
            }
            button {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
                border: 2px solid green;
                height: 30px;
                width: 120px;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>

        <h1>Welcome to the Web Shopping Application System</h1>
        <h1>New Customer Sign_Up</h1>
        <form method = 'post'>
            <div class="container">
                <div class="box">
                    <div class="box-row">
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
                </div>
                <button type="submit" name="proceedButton">Proceed</button>
                <button type="clear" name="clearButton">Clear</button>
            </div>
        </form>
    </body>
</html>


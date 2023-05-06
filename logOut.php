<?php
session_start();
require_once("DbConect.php");
if (isset($_POST['findButton'])) {
    $_SESSION['searchString'] = $_POST['searchInput'];
    header("Location:searchResultPage.php");
}

$query_str = "SELECT * FROM cart";
$result = mysqli_query($con, $query_str);
if (mysqli_num_rows($result) == 0) {
    session_start();
    session_unset();
    session_destroy();
    header("Location:index.php");
    exit();
} elseif (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if (isset($_POST['logOutButton'])) {
            if ($_POST['radio'] == 'CheckOut') {
                header("Location:checkOut.php");
            } elseif ($_POST['radio'] == 'Save Cart and Logout') {
                $_SESSION['saveLogOut'] = "1";
                $sql = "SELECT * FROM cart where cno='" . $_SESSION['cno'] . "'";
                $result = mysqli_query($con, $sql);
                $cno = $_SESSION['cno'];
                $ship = "0000-00-00 00:00:00";
                $reci = $mysqltime = date('Y-m-d H:i:s');
                if (!mysqli_query($con, $sql)) {
                    echo("Error description: " . mysqli_error($con));
                }
                if (mysqli_num_rows($result) > 0) {
                    $sqlono = "SELECT ono FROM orders";
                    $res2 = mysqli_query($con, $sqlono);
                    if (mysqli_num_rows($res2) == 0) {
                        $quOr = " INSERT INTO orders (ono,cno,received,shipped)"
                                . " values ('1000','$cno', '$reci', '$ship')";
                        $_SESSION['ono'] = '1000';
                    } elseif (mysqli_num_rows($res2) >= 1) {
                        $quOr = " INSERT INTO orders (cno,received,shipped)"
                                . " values ('$cno', '$reci', '$ship')";

                        $max = "SELECT * FROM orders ORDER BY ono DESC LIMIT 1";
                        $resmax = mysqli_query($con, $max);
                        while ($row = mysqli_fetch_assoc($resmax)) {
                            $_SESSION['ono'] = $row['ono'];
                        }
                    }
                    $res1 = mysqli_query($con, $quOr);
                    $ono = $_SESSION['ono'];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pno = $row['pno'];
                        $qty = $row['qty'];

                        $query = " INSERT INTO odetails (ono,pno,qty)"
                                . " values ('$ono', '$pno', '$qty')";
                    }
                    $res3 = mysqli_query($con, $query);
                    $delete = "TRUNCATE TABLE cart";
                    $truncatetable = mysqli_query($con, $delete);
                    session_start();
                    session_unset();
                    session_destroy();
                    header("Location:index.php");
                    exit();
                }
            } elseif ($_POST['radio'] == 'Empty Cart and Logout') {
                $delete = "TRUNCATE TABLE cart";
                $truncatetable = mysqli_query($con, $delete);
                session_start();
                session_unset();
                session_destroy();
                header("Location:index.php");
                exit();
            }
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Web Shopping Application-Customer Menu</title>
        <style>
            h2 {
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


            .container .box .box-cell.box2 {
                text-align:center;
                float: left;
                display: inline-block;  
                margin: 2px;
                border: 1px solid green;
                padding: 4px;
                width: 80%;
                height: 450px;

            }
            .container .box .box-cell.box1 {
                text-align:left;
                float:right;
                margin: 2px;
                border: 1px solid green;
                padding: 4px;
                width: 20%;
                height: 450px;

            }
            label {
                display: inline-block;
                width: 150px;
                padding: 7.5px 8px;
                /*margin-right:15px;*/
            }
            input {
                padding: 7px 15px;
                height: 7px;
                width: 40px;
            }
            button {
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
                border: 2px solid green;
                height: 20px;
                width: 40px;
                border-radius: 5px;
            }
            thead, tfoot {
                background: url(leopardskin.jpg);
                color: white;
                text-shadow: 1px 1px 1px black;
            }

            thead th, tfoot th, tfoot td {
                background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5));
                border: 3px solid purple;
            }
            #test {
                width:30%;
                height:30%;
            }
            table {
                margin: 0 auto; /* or margin: 0 auto 0 auto */
            }
            h2, a{
                padding-left: 20px;
            }
        </style>
    </head>
    <body>
        <h2>Welcome to the Web Shopping Application System</h2>
        <form method="post">
            <div class="container">
                <div class="box">
                    <div class="box-cell box1">

                        <h2 style="text-align: left;">Customer Menu</h2><br>
                        <a href="checkOut.php">CheckOut</a><br><br><br>
                        <a href="checkOrderStatus.php">Check Order Status</a><br><br><br>
                        <a href="updateProfile.php">Update Profile</a><br><br><br>
                        <a href="viewEditCart.php">View Edit Cart</a><br><br><br>
                        <a href="logOut.php">Logout</a><br><br><br><br>                       
                        <div style="text-align: center;">
                            <label><strong>Search By Keyword</strong></label><br>
                            <input type="text" name="searchInput">
                            <button type="submit" name="findButton">Find</button>
                        </div>
                    </div>

                    <div class="box-cell box2">
                        <h3 style="text-align: center;">LogOut Page</h3><br><br><br>
                        <p>Your Shopping Cart has items in it!<br>
                            please choose one of the following options before logging out.</p><br>
                        <input type="radio" value="CheckOut" name="radio">
                        <label>CheckOut</label><br>
                        <input type="radio" value="Save Cart and Logout" name="radio">
                        <label>Save Cart and Logout</label><br>
                        <input type="radio" value="Empty Cart and Logout" name="radio">
                        <label>Empty Cart and Logout</label><br><br><br>
                        <button type="submit" name="logOutButton" style="height: 30px ; width: 
                                100px;">Submit</button>





                    </div><br><br>

                </div>

            </div>
        </form>
    </body>
</html>


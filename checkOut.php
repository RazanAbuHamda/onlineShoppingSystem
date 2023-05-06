<?php
session_start();
require_once("DbConect.php");
if (isset($_POST['findButton'])) {
    $_SESSION['searchString'] = $_POST['searchInput'];
    header("Location:searchResultPage.php");
}
if (isset($_SESSION['saveLogOut']) == "1") {
    session_start();
    session_unset();
    session_destroy();
    header("Location:index.php");
    exit();
}
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
        $res3 = mysqli_query($con, $query);
        $delete = "TRUNCATE TABLE cart";
        $truncatetable = mysqli_query($con, $delete);
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
                /*background: url(leopardskin.jpg);*/
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
        ?></h3>

    <form>
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
                    <?php
                    if (isset($_SESSION['cno'])) {
                        $sql = "SELECT * FROM customers where cno='" . $_SESSION['cno'] . "'";
                        $result = mysqli_query($con, $sql);
                    }
                    if (!mysqli_query($con, $sql)) {
                        echo("Error description: " . mysqli_error($con));
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <h3 style="text-align: center;">Invoice for <?php echo $row['cname']; ?></h3>

                            <h4>Shipping Address : <?php
                                echo $row['street'] . "<br>" . $row['city'] . " " . $row['state'] . " " . $row['city'] . " " . $row['zip'];
                            }
                        }
                        ?></h4><br><br><br>
                    <p>order number : <?php
                        $query_str = "SELECT * FROM orders where cno='" . $_SESSION['cno'] . "'";
                        $result = mysqli_query($con, $query_str);
                        $_SESSION['noOfOno'] = 0;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $_SESSION['noOfOno'] += 1;
                            }
                        }

                        if (isset($_SESSION['noOfOno'])) {
                            echo $_SESSION['noOfOno'];
                        }
                        ?></p>
                    <table style="text-align: center;" id="test">
                        <thead  class=" text-primary">
                        <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                            PNO
                        </th>
                        <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                            PNAME
                        </th>
                        <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                            PRICE
                        </th>
                        <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                            QTY
                        </th>
                        <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                            COST
                        </th>
                        </thead>
                        <tbody>
                            <?php
                            $sqlCart = "SELECT DISTINCT(p.pno),p.pname,p.price,d.qty FROM parfts p  NATURAL JOIN odetails d  where  p.pno = d.pno";
                            $results = mysqli_query($con, $sqlCart)or die(mysqli_error($con));
                            $total = 0;
                            if (mysqli_num_rows($results) > 0) {
                                while ($row = mysqli_fetch_array($results)) {
                                    $cost = $row['price'] * $row['qty'];
                                    echo "<tr>";
                                    echo "<td>" . $row['pno'] . "</td>";
                                    echo "<td>" . $row['pname'] . "</td>";
                                    echo "<td>" . $row['price'] . "</td>";
                                    echo "<td>" . $row['qty'] . "</td>";
                                    echo "<td>" . $cost . "</td>";
                                    $total += $cost;
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                echo "<td>" . " " . "</td>";
                                echo "<td>" . " " . "</td>";
                                echo "<td>" . " " . "</td>";
                                echo "<td>" . "Total Cost" . "</td>";
                                echo "<td>" . "" . $total . "</td>";
                                echo "</tr>";
                            }
                            ?>
                    </table><br><br>
                    <p>please print a copy of the invoice for your records</p>
                </div>

            </div>
        </div>
    </form>
</body>
</html>


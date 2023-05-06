<?php
session_start();
require_once("DbConect.php");
if (isset($_POST['findButton'])) {
    $_SESSION['searchString'] = $_POST['searchInput'];
    header("Location:searchResultPage.php");
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
                <h2>Welcome to the Web Shopping Application System<br>Welcome <?php
                    echo $row['cname'];
                }
            }
            ?></h2>
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
                        <h3 style="text-align: center;">Cart Contents</h3>
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
                                $sqlCart = "SELECT DISTINCT(p.pno),p.pname,p.price,c.qty FROM parfts p  NATURAL JOIN cart c  where  p.pno = c.pno";
                                $results = mysqli_query($con, $sqlCart)or die(mysqli_error($con));
                                $total = 0;
                                $i = 0;
                                $index['$i'] = $i;
                                if (mysqli_num_rows($results) > 0) {
                                    while ($row = mysqli_fetch_array($results)) {
                                        $cost = $row['price'] * $row['qty'];
                                        echo "<tr>";
                                        echo "<td>" . $row['pno'] . "</td>";
                                        $index[$i] = $row['pno'];
                                        echo "<td>" . $row['pname'] . "</td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        $pno = $row['pno'];
                                        echo '<td><input type = "text" placeholder ="' . $row['qty'] . '"' . 'name ="' . $pno . '"' . '</td>';
                                        echo "<td>" . $cost . "</td>";
                                        $total += $cost;
                                        $i++;
                                        echo "</tr>";
                                    }
                                    echo "<tr>";
                                    echo "<td>" . " " . "</td>";
                                    echo "<td>" . " " . "</td>";
                                    echo "<td>" . " " . "</td>";
                                    echo "<td>" . "Total Cost" . "</td>";
                                    echo "<td>" . "" . $total . "</td>";
                                    echo "</tr>";
                                    $j = 0;
                                    if (isset($_POST['modify'])) {
                                        $cno = $_SESSION['cno'];
                                        $check = false;
                                        $ch =false;
                                        foreach ($_POST as $key => $val) {
                                            $rows = "select * from parfts p natural join cart where p.pno ='" . $key . "'";
                                            $results = mysqli_query($con, $rows)or die(mysqli_error($con));
                                            if (mysqli_num_rows($results) > 0) {
                                                if ($val != 0 ||$val>0) {
                                                    while ($row = mysqli_fetch_array($results)) {
                                                        if ($val != null) {
                                                            print_r($_POST);
                                                            if ($row['qoh'] >= $val) {
                                                                $query = "UPDATE parfts SET qoh = qoh + '" . $row['qty'] . "' WHERE pno ='" . $key . "' and cno='" . $cno . "'";
                                                                $result2 = mysqli_query($con, $rows);
                                                                $query = "UPDATE cart SET qty = '" . $val . "' WHERE pno ='" . $key . "' and cno='" . $cno . "'";
                                                                $result3 = mysqli_query($con, $query);
                                                                $query = "UPDATE parfts SET qoh = qoh - '" . $val . "' WHERE pno ='" . $key . "' and cno='" . $cno . "'";
                                                                $result1 = mysqli_query($con, $query);
                                                            } else {
                                                                $ch = true;
                                                            }
                                                        }
                                                    }
                                                } elseif($val<0) {
                                                    $check = true;
                                                }
                                            }
                                        }
                                        if ($check) {
                                            echo 'Please Enter A Quantity Number!';
                                            $check = false ;
                                        }
                                         if ($ch) {
                                            echo 'Sorry this quality not available!';
                                            $ch = false;
                                        }
                                    }
                                }
                                ?></table><br><br>
                        <button type="submit" name="modify" style="height: 30px ; width: 
                                100px;">Modify</button>
                        <p>if you are done shopping. please checkOut</p>
                    </div>

                </div>
            </div>
        </form>
    </body>
</html>

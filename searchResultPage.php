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
                        <h3 style="text-align: center;">Search Results</h3>
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
                            </thead>
                            <tbody>

                                <?php
                                $query_str = "SELECT * FROM parfts";
                                $result = mysqli_query($con, $query_str);
                                if (isset($_SESSION['searchString'])) {
                                    $title = strtoupper($_SESSION['searchString']);
                                } elseif (isset($_POST['findButton'])) {
                                    $title = strtoupper($_POST['searchInput']);
                                }if (isset($_POST['findButton']) || isset($_SESSION['searchString'])) {
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $titleFromDB = strtoupper($row['pname']);
                                            if (str_contains($titleFromDB, $title)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['pno'] . "</td>";
                                                $pno = $row['pno'];
                                                echo "<td>" . $row['pname'] . "</td>";
                                                echo "<td>" . $row['price'] . "</td>";
                                                echo '<td><input type = "text" placeholder ="' . $row['qoh'] . '"' . 'name ="' . $pno . '"' . '</td>';
                                                echo "</tr>";
                                            }
                                        }
                                        if (isset($_POST['addToCart'])) {
                                            $cno = $_SESSION['cno'];
                                            foreach ($_POST as $key => $val) {
                                                if (isset($_POST[$key])) {
                                                    if ($val != 0) {
                                                        if ($val != null) {
                                                            $row = "select * from parfts where pno ='" . $key . "'";
                                                            print_r($_POST);
                                                            $result = mysqli_query($con, $row);
                                                            if (mysqli_num_rows($result) > 0) {
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    if ($row['qoh'] >= $val) {
                                                                        $rows = "select * from cart where pno ='" . $key . "'";
                                                                        $results = mysqli_query($con, $rows);
                                                                        if (mysqli_num_rows($results) == 0) {
                                                                            $query = "INSERT INTO cart (cno,pno,qty) values($cno, $key,$val)";
                                                                            $result1 = mysqli_query($con, $query);
                                                                        } elseif (mysqli_num_rows($results) > 0) {
                                                                                
                                                                                $query = "UPDATE cart SET qty = qty + '" . $val . "' WHERE pno ='" . $key . "' and cno='" . $cno . "'";
                                                                                $result1 = mysqli_query($con, $query);
                                                                            
                                                                        }
                                                                        $newQoh = $row['qoh'] - $val;
                                                                        $rows = "update parfts set qoh = '" . $newQoh . "'where pno ='" . $key . "'";
                                                                        $result2 = mysqli_query($con, $rows);
                                                                    } else {
                                                                        echo 'Sorry this quality not available!';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        echo 'Please Enter A Quantity Number!';
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        echo "No records matching your query were found.";
                                    }
                                }
                                ?>

                            </tbody></table><br><br>
                        <button type="submit" name="addToCart" style="height: 30px ; width: 
                                100px;">Add to Cart</button>
                    </div><br><br>
                </div>
            </div>
        </form>
    </body>
</html>


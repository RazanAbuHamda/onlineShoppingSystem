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
                        <table style="text-align: center;" id="test">
                            <thead  class=" text-primary">
                            <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                                ONO
                            </th>
                            <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                                pno
                            </th>
                            <th style="font-weight: 200; font-size: 17px; color: #9c27b0">
                                qty
                            </th>
                            </thead>
                            <tbody>

                                <?php
                                $query_str = "SELECT * FROM odetails where ono='" . $_SESSION['clickedOno'] . "'";
                                $result = mysqli_query($con, $query_str);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['ono'] . "</td>";
                                        echo "<td>" . $row['pno'] . "</td>";
                                        echo "<td>" . $row['qty'] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                echo "</table>";
                                ?>






                            </div><br><br>

                            </div>

                            </div>
                            </form>
                            </body>
                            </html>


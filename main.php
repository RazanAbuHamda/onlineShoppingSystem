<html>
    <head>
        <meta charset="UTF-8">
        <title>Web Shopping Application Login Page</title>
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
                padding: 20px;
                margin: 10px;
            }
            label {
                display: inline-block;
                width: 150px;
                /*margin-right:15px;*/
            }
            input {
                padding: 5px 10px;
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
        <?php
        session_start();
        require_once('DbConect.php');
        if (isset($_POST['send'])) {

            if (!empty($_POST['email']) and!empty($_POST['cpass'])) {
                $customerEmail = "select * from customers where email ='" . $_POST['email'] . "'";
                $result = mysqli_query($con, $customerEmail);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cnodbs = $row['email'];
                        $cpassdbs = $row['password'];
                        $_SESSION['cno'] = $row['cno'];
                        echo "the input : " . $_POST['email'] . $_POST['cpass'];

                        echo "    ///from database : " . $row['email'] . $row['password'];
                    }
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $cpass = mysqli_real_escape_string($con, $_POST['cpass']);
                    $verify = password_verify($cpass, $cpassdbs) . "\n";
                    if ($cnodbs == $email and $verify) {
                        setcookie("cno", $email, time() + 3600);
                        setcookie("cpass", $cpass, time() + 3600);
                        
                        header("Location:customerMenu.php");
                    } else {
                        $error = "Incorrect coustomer's Email or password";
                    }
                } else {
                    $error = "Invalid customer Email";
                }
            } else {
                $error = "ERROR : empty fields";
            }
        }
        ?>
        <h1>Welcome to the Web Shopping Application System</h1>
        <form method="post">
            <div class="container">
                <div class="box">
                    <div class="box-row">
                        <div class="box-cell box1">
                            <label>Customer Email: </label>
                            <input type="text" name="email">
                        </div><br>
                        <div class="box-cell box2">
                            <label>password: </label>
                            <input type="password" name="cpass">
                        </div>
                    </div><br><br>
                </div>
            </div>
            <button name="send">Proceed</button>
            <p>If you are not a customer, sign in <a href="signUp.php">here</a></p>
        </form>
    </body>
</html>

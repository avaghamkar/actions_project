<html>
    <body>
        <?php
            $otp= $_POST['otp'];
            $email= $_POST['email'];

            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = 'root';
            
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
            
            if(! $conn ) {
               die('Could not connect: ' . mysql_error());
            }
            
            $sql = 'SELECT email, otp, timestp FROM otp ORDER BY id DESC LIMIT 1';
            mysqli_select_db($conn, 'test');
            $retval = mysqli_query($conn, $sql);
            
            if(! $retval ) {
               die('Could not get data: ' . mysqli_error());
            }
            
            while($row = mysqli_fetch_array($retval, MYSQLI_NUM)) {
               //echo "email :{$row[0]}  <br> ".
               //"email :{$row[1]}  <br>" ;
               $email1=$row[0];
               $otp1=$row[1];
               $tm1=$row[2];
            }
            
            //echo $tm1;


            $tz = 'Asia/Kolkata';
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $dt=$dt->format('Y-m-d H:i:s');

            //$time = date("Y-m-d H:i:s", time());
            $ts = strtotime($tm1);
            $addtime = date("Y-m-d H:i:s", mktime(date("H", $ts),date("i", $ts),date("s", $ts)+30,date("m", $ts),date("d", $ts),date("Y", $ts)));

            //echo $addtime;


            mysqli_free_result($retval);
            //echo "Fetched data successfully\n";
            
            mysqli_close($conn);

            if ($email1==$email and $otp1==$otp)

                if ($addtime >= $dt)
                    echo '<body style="background-color: lightgreen"> Login Success';
                else
                    echo '<body style="background-color: red"> Login Failure - OTP has expired';

            else
                    echo '<body style="background-color: red"> Login Failure - Email and/or OTP left blank/Wrong'; 
        //Redirect to html
        //header('Location: login.html');
        //exit();
        ?>
    </body>
</html>
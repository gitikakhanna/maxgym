<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "vendor/autoload.php";

    $servername = "localhost";
    $username = "id10326607_root";
    $password = "maxgym";
    $dbname = "id10326607_gym";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "connection";
                                $mail = new PHPMailer(true);
                        
    date_default_timezone_set("Asia/Kolkata");
    $created_date = date("Y-m-d");

    $customers = "Select * from customers where(due_date <= CURDATE())";
    $result = $conn->query($customers);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $overdue_customers = "Select * from notifications where(customer_id = '".$row["id"]."')";
            $over_customer = $conn->query($overdue_customers);
            if($over_customer->num_rows > 0)
            {

            }
            else{
            	$insert_notify = "Insert into notifications (customer_id, customer_name, package_id, due_date, action, created_at, updated_at) values ('".$row["id"]."', '".$row["name"]."', '".$row["package"]."', '".$row["due_date"]."', '0', CURDATE(), CURDATE())";
            	
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPAuth = true;
                            $mail->Username = "averma382@gmail.com";
                            $mail->Password = "averma382maxgym";
                            $mail->SMTPSecure = "tls";
                            $mail->Port = 587;
                            $mail->setFrom('averma382@gmail.com', 'Amit Verma');
                            $mail->addAddress($row["email"], 'To');
                            $mail->Subject = "MAX GYM - Membership Expired";
                            $mail->Body = "Your membership ends on ".date('d M Y', strtotime($row["due_date"])).". In order to continue renew today. For queries please contact us at 9990777229, 9999909502.";
                            $mail->send();
            	if($conn->query($insert_notify) == true)
            	{
        
            	}
            	else{
            		echo "something went wrong";
            	}
            }
            echo $row["id"];
        }
    } else {
        echo "0 results";
    }
    
    $conn->close();
  
?>
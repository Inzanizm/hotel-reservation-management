<?php include('initialize.php');?>
<?php

    if(isset($_POST['register'])) {

        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        $confirm_password=$_POST['confirm_password'];

        if(empty($firstname)) {
            $error_message="Firstname is required!";
        } elseif(empty($lastname)) {
            $error_message="Lastname is required!";
        } elseif(empty($password)) {
            $error_message="Password is required!";
        } elseif(empty($username)) {
            $error_message="Username is required!";
        } elseif(empty($confirm_password)) {
            $error_message="Confirm Password is required!";
        } elseif($confirm_password!==$password) {
            $error_message="Password and confirm password not match!";
        } else{
            $error_message=null;
        }

        if(!empty($error_message)) {
            $_SESSION['alert_message']=$error_message;
            header('Location: register.php');
        } else{

            $sql="INSERT INTO users (
                firstname,lastname,username,password
                ) VALUES ( '".$firstname."','".$lastname."','".$username."','".$password."')";

                if($connection->query($sql)===TRUE) {
                    $_SESSION['alert_message']="Account successfully created. You can now <a href='login.php'>login</a>";
                    $_SESSION['user_firstname']=$firstname;
                    header('Location: register.php');
                } else{

                    die($connection->error);
                }
        }
    } elseif (isset($_POST['login'])) {
        
        $username=$_POST['username'];
        $password=$_POST['password'];

        $sql="SELECT * FROM users WHERE username='".$username."' AND password = '".$password."' ";

        $result=$connection->query($sql);
        $row=mysqli_fetch_assoc($result);

        if ($result->num_rows>0) {
            $_SESSION['alert_message']='You are logged in.';
            $_SESSION['user_firstname']=$row['firstname'];
            $_SESSION['is_login']=true;
            header('Location: user_records.php');
        } else{
            $_SESSION['alert_message']="Username and Password not found!";
            header('Location: login.php');
        }
    } else{
        header('Location: index.php');
    } 
    
?>
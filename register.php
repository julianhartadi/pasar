<?php 
session_start();
include("includes/connect.php");
include("includes/html_codes.php");

if(isset($_POST['submit']) ){
    $error = array();
    
    // validasi username
    if(empty($_POST['username']) ){
        $error[] = 'Silahkan masukkan username. '; //check isian kosong atau isi
    }else if (ctype_alnum($_POST['username']) ){
        $username = $_POST['username']; // check memastikan apakah isian username huruf dan angka saja
    }else{
        $error[] = 'Username hanya huruf dan angka saja ';
    }
    
    //validasi email
    if(empty($_POST['email']) ){
        $error[] = 'Silahkan masukkan email. ';
    }else if(preg_match("/*([a-zA-Z0-9])+([a-zA-Z0-9\.-])*0([a-z-A-Z0-9\._-])+)+$/", $_POST['email'])){
        $email = mysql_real_escape_string($_POST['email']);
    }else{
        $error[] = "Alamat email anda invalid.";
    }
    
    //validasi password
    if(empty($_POST['password']) ){
        $error[] = 'Silahkan masukkan password. ';
    }else{
        $password = mysql_real_escape_string($_POST['password']);
    }
    
    if(empty($error)){
        //informasi mengenai error
        $result = mysql_query("SELECT * FROM users WHERE email='$email' OR username=$username' ")  or die (mysql_error());
        if(mysql_num_rows($result)==0){
            //itu bagus
            $activation = md5(uniqid(rand(), true) );
            $result2 = mysql_query("INSERT INTO tempusers (user_id,username,email,password,activation) VALUES ('','$username','$password','$activation') ")  or die (mysql_error());
            if(!$result2){
                die('Tidak bisa masuk ke database: '.mysql_error() );
            }else{
                $messsage = "Untuk mengaktifkan akun anda, silahkan klik link: \n \n";
                $message = "http://pasar.myidbc.com".'/activate.php?email='.urlencode($email)."&key=$activation";
                mail($email, 'Konfirmasi Registrasi', $message);
                header('Location: prompt.php?x=1');
            }
        }else{
            header('Location: prompt.php?x=2');
        }
    }else{
        $error_message = '<span class="error"">';
            foreach($error as $key => $values){
                $error_message.= "$values";    
            }
        $error_message.="</span><br /><br />";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
	<link rel="stylesheet" href="css/main.css" >
	<link rel="stylesheet" href="css/forms.css" >
	<link rel="stylesheet" href="css/register.css" >
</head>
<body>
	<div id="wrapper">
        <?php headerAndSearchCode(); ?>
		<aside id="left_side">
		  <img src="images/registerbanner.png" />
		</aside>
		<section id="right_side">
		  <form id="generalform" class="container" method="post" action=" ">
            <h3>Register</h3>
            <?php echo $error_message; ?>
            <div class="field">
              <label for="username">Username:</label>
                <input type="text" class="input" id="username" name="username" maxlength="20" />
                <p class="hint">20 karakter maksimum(huruf dan angka)</p>
            </div>
            <div class="field">
              <label for="email">Email:</label>
              <input type="email" class="input" id="email" name="email" maxlength="80" />
            </div>
            <div class="field">
              <label for="password">Password:</label>
              <input type="password" class="input" id="password" name="password" maxlength="20" />
                <p class="hint">20 karakter maksimum</p>
            </div>
            <input type="submit" name="submit" id="submit" class="button" value="Register"/>
          </form>
		</section>
        <?php footerCode(); ?>
	</div>
</body>
</html>
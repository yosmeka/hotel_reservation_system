<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="h.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  </head>
  <body>
  <div class="main-container">
    <div class="hh"><h1>Login</h1></div>
    <div class="ph"><p>Signin to continue</p></div>
    <div class="formdiv1">
      <form action="login.php" method="POST">
      <label for="email">Email</label>
      <input type="text" id="email" name="email">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
      <button type="submit" class="btnsubmit" style="margin-top: 50px; font-weight: 350;font-size: 25px;">Login</button>
      <div class="dp">Don't have an account? Signup <a href="signup.php"> here</a></div>
    </form>
  </div> 
  <div class="fontreg"><i class="fas fa-sign-in-alt fa-5x"></i>
</div>
  </div> 
  </body>
</html>
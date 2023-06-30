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
    <div class="hh"><h1>Create new <br> Account</h1></div>
    <div class="ph"><p>Already Registered? log in<a href="loginpage.php">here</a></p></div>
    <div class="formdiv">
      <form action="auth.php" method="POST">
      <label for="name">Name</label>
      <input type="text" id="name" name="name">
      <label for="email">Email</label>
      <input type="text" id="email" name="email">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
      <button type="submit" class="btnsubmit" style="margin-top: 50px; font-weight: 350;font-size: 25px;">Sign Up</button>
</form>
  </div> 
  <div class="fontreg"> <i class="fas fa-user-plus fa-5x"></i></div>
  </div> 
  </body>
</html>
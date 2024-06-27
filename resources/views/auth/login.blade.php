<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>LOGIN-AMI</title>
<!-- Favicons -->
<link href="assets/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
      *,
*:before,
*:after{
    padding: 0px;
    margin: 0px;
    box-sizing:border-box;
}
body{
    padding: 100px;
    margin: 100px;
    background-position:center;
    background-size:cover;
    background-color: #080710;
    background-image: url('assets-landing/img/jgu-black.png')

}

form{
    height: 500px;
    width: 400px;
    background-color: rgba(255,0,0.3);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    color:aliceblue;
    letter-spacing: 1px;
    outline:#080710;
    border:#080710;
}
form h2{
    font-size: 37px;
    font-weight: 500;
    line-height: 42px;
    text-align:center;
}

label{
    display:block;
    margin-top: 25px;
    font-size: 15px;
    font-weight: 450;
    font-style:normal;
}
input{
    display: block;
    height: 45px;
    width: 100%;
    background-color:rgba(255,255,255,0.13);
    border-radius: 10px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 13px;
    font-weight: 300;
}
::placeholder{
    color:#080710;
}
button{
    margin-top: 20px;
    width: 30%;
    background-color:aliceblue;
    color: #080710;
    padding: 5px 10px;
    font-size: 18px;
    font-weight: 500;
    border-radius: 10px;
    cursor: pointer;
}
.parent {
      display: grid;
      place-items: center;
      padding: 50px 10px;
  	}

</style>
</head>
<body>
    <div class="background">
    </div>
    <form method="POST" action="{{ route('login') }}"><h2>LOGIN</h2>
    <br>
        @csrf
         <!-- Email Address or Username-->
        <label for="login_account">Username or Email</label>
        <input type="text" placeholder="Username or Email" id="login_account"  name="login_account" :value="old('login_account')" autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2"/>

        <!-- Password -->
        <label for="password">Password</label>
        <input type="password" placeholder="Masukkan Password" id="password" name="password"
                             autocomplete="current-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        <div class="parent">
      <button name="button" class="custom">Login</button>
    </div>
    </form>
</body>
</html>

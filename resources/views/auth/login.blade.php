<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-AMI | JGU</title>
  <!--Stylesheet-->
  <link rel="stylesheet" type="text/css" href="https://cdn.prinsh.com/NathanPrinsley-textstyle/nprinsh-stext.css"/>
  <style media="screen">
body {
    margin: 0;
    font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    display: flex;
    height: 100vh;
    align-items: center;
    justify-content: center;
    background-color: #f4f4f4;
}

.split-screen {
    display: flex;
    width: 100%;
    height: 100%;
}

.left, .right {
    display: flex;
    align-items: center;
    justify-content: center;
}

.left {
    flex: 400px;
    background-color: #fff;

}

.image-container {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.image-container img {
    width: 100%;
    height: 100%;
}

.right {
    flex: 100px;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.logo-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
}

.animated-logo {
    width: 310px;
    height: 100px;
    animation: moveUpDown 1.5s infinite alternate;
}

@keyframes moveUpDown {
    100% {
        transform: translateY(10);
    }
    100% {
        transform: translateY(-10px);
    }
}

.logo {
    width: 300px;
}
form {
     width:270px;
     padding: 10px;
     margin: 0 auto;
     background-color: #fff;
 }

.login-container {
    width: 100%;
    max-width: 350px;
    padding: 10px;
    background: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    border-radius: 25px;
    text-align: center;
}

.login-container h2 {
    margin-bottom: 20px;
}
.error-messages {
    color: red;
}

.error-messages ul {
    padding-left: 0;
    list-style:inside;
}

.error-messages li {
    display: flex;
    align-items:center;
    margin-left: 5px;
    font-size: 11px;
}

.error-messages li::before {
    content: '•';
    margin-right: 5px;
    color: red;
}

.input-field {
    margin-bottom: 15px;
    text-align: left;
}

.input-field label {
    display: block;
    margin-bottom: 5px;
}

.input-field input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}


.checkbox {
    display: flex;
    align-items:center;
   font-size: 12px;
}

.checkbox input {
    margin-right: 10px;
}

.btn {
    width: 100%;
    padding: 10px;
    background-color: #b90e0a;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-bottom: 10px;
}

.btn:hover {
    background-color: #a00d09;
}

.links {
    margin-bottom: 15px;
}

.links a {
    color: #007BFF;
    text-decoration: none;
    font-size: 13px;
}

.links a:hover {
    text-decoration: underline;
}
  </style>
</head>
<body>
    <div class="split-screen">
        <div class="left">
            <div class="image-container">
                <img src="../assets/img/header-bg.jpg" alt="JGU Building">
            </div>
        </div>
        <div class="right">
            <div class="logo-container">
                <a href="{{ route('home') }}">
                <img src="../assets-landing/img/ami-jgu.png" alt="Logo" class="animated-logo">
                </a>
            </div>
<!-- form login -->
            <div class="login-container">
                <form method="POST" action="{{ route('login-ami') }}">
            @csrf
            <h2><div class="nprinsley-text-redan">LOGIN | AMI</div></h2>
                <form>

         <!-- Email Address or Username-->
            <div class="input-field">
            <label for="login_account">Username or email</label>
            <input type="text" id="login_account" name="login_account"  placeholder="Enter Username or Email" :value="old('login_account')" autocomplete="username" /></div>

         <!-- Password -->
            <div class="input-field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password" autocomplete="current-password" /></div>

        <!-- pesan kesalahan -->
            @if ($errors->any())
            <div class="error-messages">
            <ul>@foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                 @endforeach
            </ul>
        </div>
    @endif

        <button type="submit" class="btn">Login</button>
            <div class="links">
                @if (Route::has('password.request'))
                    <a class="forgot-password">Forgot Password?</a>
                @endif
                </div>
            </form>
        </div>
    </div>
</body>
</html>

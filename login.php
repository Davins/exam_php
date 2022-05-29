<?php
$_title = 'Log in';
$_className = "signin";
require_once("components/header.php");


?>
<!-- Main HTML START -->

<section class="main-content-form">
  <div class="logo-wrapper">
    <a href="index.php"><img class="logo-black" src="images/logo-black.svg" /></a>
  </div>

  <div class="form-wrapper">
    <h1>
      Log in
    </h1>
    <form id="form-sign-up" onsubmit="login(this); return false">
      <!--<form id="form-sign-up" action="apis/api-login.php" method="post"> -->
      <label for="email">Enter Email</label>
      <input class="form-email" name="user_email" type="text" placeholder="Your Email">
      <p class="wrong-e"></p>
      <label for="password">Enter Password</label>
      <input class="form-pw" name="password" type="password" placeholder="At least 8 characters">
      <p class="wrong-pw"></p>
      <p class="forgot-pw"></p>
      <button class="sign-up-btn" type="submit">Continue</button>

    </form>
    <div class="line-wrapper">
    <a href="forgot-password.php">Forgot your Password?</a>
            <p class="forgot-pw"></p>
      <p>New to Examon?</p>

    </div>

  </div>
  <div class="btn-wrapper">
    <button class="create-btn" onclick="location.href= 'signup.php'">Create your Examon Account </button>
  </div>
</section>
<script>
  function handleResponse(response) {
    if (response.status == 200) {
      location.href="profile.php"
      return
    }
    const formPw = document.querySelector(".form-pw");
    const wrongE = document.querySelector(".wrong-e");
    const wrongPw = document.querySelector(".wrong-pw");
    const forgotPw = document.querySelector(".forgot-pw");

    if (response.info == "wrong credentials") {
      formPw.focus();
      wrongPw.innerHTML = `<span> <img class="excl-icon" src="excl-icon.svg" alt=""></span>Wrong password`;
      forgotPw.innerHTML = `<span> <img class="excl-icon" src="excl-icon.svg" alt=""></span><a class="pw-recovery" href="#">Forgot your password?</a>`;
      return
    }
    if (response.info == "password min 8 characters") {
      formPw.focus();
      wrongPw.innerHTML = `<span> <img class="excl-icon" src="excl-icon.svg" alt=""></span>password is min 8 characters`;
      return
    }
    if (response.info == "email is invalid") {
      wrongE.innerHTML = `<span> <img class="excl-icon" src="excl-icon.svg" alt=""></span>E-mail not found, please enter a valid one`;
      return
    }
    if (response.info == "wrong email") {
      wrongE.innerHTML = `<span> <img class="excl-icon" src="excl-icon.svg" alt=""></span>E-mail not found, please enter a valid one`;
      return
    }
  }
  async function login(form) {
    //const form=document.querySelector("#form-sign-up")
    //console.log(form, new FormData(form))
    try { 
      var formData = new FormData(form),
        result = {};

    for (var entry of formData.entries())
    {
        result[entry[0]] = entry[1];
    }
    result = JSON.stringify(result)
    console.log(result);
      let conn = await fetch("apis/api-login.php", {
      method: "POST",
      body: result,
      headers:{
        'Content-Type': 'application/json'
      }
    })
    let response = await conn.json()
    handleResponse(response)
      
    } catch (error) {console.log(error)
      
    }
   

    

  }
</script>
<!-- Main HTML END  -->
<?php
require_once("components/footer.php");
?>
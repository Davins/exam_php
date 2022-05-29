<?php
$_title = 'Password change';
$_className = "signin";
require_once('components/header.php');
// require_once('apis/api-signup.php');

?>
<!-- Main HTML START -->

<section class="main-content-form">
  <div class="logo-wrapper">
    <a href="index.php"><img class="logo-black" src="images/logo-black.svg" /></a>
  </div>
<div class="form-wrapper">
   <form  id="form-sign-up" onsubmit="return false">
        <label for="email">Email for recovery</label>
        <input type="email" name="user_email">
        <button onclick="recoverPassword()"class="sign-up-btn">Recover Password</button>
        </form>
</div>

<!-- Main HTML END  -->

<script>

async function recoverPassword(){
    const form = document.querySelector("#form-sign-up");
    let conn = await fetch("apis/api-recover-password.php", {
      method: "POST",
      body: new FormData(form)
    })
    let response = await conn.json()
    console.log(response)
}

</script>
<?php
require_once('components/footer.php');
?>
<?php
$_title = 'Forgot Password';
$_className = "recover";
require_once ('components/header.php');

?>

<!-- Main HTML START -->

<div class="form-wrapper">
<form id="form-sign-up" onsubmit="return false">
<label for="email">Email</label>
<input id="email" name="user_email" type="email">
<label for="password">new password</label>
<input type="password" id="password" name="password">
<label for="password-2">re-enter new password</label>
<input type="password" id="password-2" name="password">
<button class="sign-up-btn" onclick="sendRecovery()">Update Password</button>
<p class="info"></p>


</div>
</form>
<script>
async function sendRecovery(){
    const form = document.querySelector("#form-sign-up");
    const data = new FormData(form);
    data.append('recovery_key', '<?= $_GET['key'] ?>');
    let conn = await fetch("apis/api-update-email.php", {
      method: "POST",
      body: data
    })
    let response = await conn.json()
    console.log(response)
    if(conn.ok){
document.querySelector(".info").textContent ="changed info"
      setTimeout(function(){
location.href="index.php"
      },3000)
    }

}
    
</script>
<!-- Main HTML END  -->
<?php
require_once('components/footer.php');

?>



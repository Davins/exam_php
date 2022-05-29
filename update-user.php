<?php
$_title = 'Update Profile';
$_className = "signin";

require_once ('components/header.php');
?>


<section class="main-content-form">
    <div class="logo-wrapper">
        <a href="index.php"><img class="logo-black" src="images/logo-black.svg" /></a>
    </div>

    <div class="form-wrapper">
        <h1>
            Update information
        </h1>
        <form id="form-sign-up" onsubmit="return false">
            <label for="name">First Name</label>
            <input class="form-name" name="user_name" type="text" placeholder="" value="<?= $_SESSION['user_name'];?>">
            <p class="wrong-name"></p>
            <label for="last_name">Last Name</label>
            <input class="form-lname" name="user_last_name" type="text" placeholder="" value="<?= $_SESSION['user_last_name'];?>">
            <p class="wrong-lname"></p>
            <label for="email">Email</label>
            <input class="form-email" name="user_email" type="text" placeholder="" value="<?= $_SESSION['user_email'];?>">
            <p class="wrong-e"></p>
            <label for="email">Phone Number</label>
            <input class="form-phone" name="user_phone" type="text" placeholder="" value="<?= $_SESSION['user_phone'];?>">
            <p class="wrong-phone"></p>
            <a href="forgot-password.php">New Password?</a>
            <p class="forgot-pw"></p>
            <button class="sign-up-btn" onclick="updateUser()">Update</button>

        </form>


    </div>

</section>


<script>
async function updateUser(){
    const form = event.target.form
    let conn = await fetch("apis/api-update-user.php", {
      method: "POST",
      body: new FormData(form)
    })
    let response = await conn.json()
    console.log(response)
  
}

</script>
<?php


require_once ('components/footer.php');

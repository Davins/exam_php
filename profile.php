<?php
$_title = 'Profile';
$_className = "profile-settings";
require_once ('components/header.php');

?>
<!-- Main HTML START -->
<div class="content-wrapper">
    <h1>Your Account</h1>
</div>
<main class="settings-wrapper">

    <div class="profile-container">

        <div onclick='location.href="items.php"' class="profile-item">
            <div class="profile-icon"><img src="images/items.png" alt=""></div>
            <div class="profile-text-wrapper">

                <a href=""></a>
                <h2>Upload items</h2>
                <p>Upload and edit your own items</p>
            </div>
        </div>
        <div onclick='location.href="update-user.php"' class="profile-item">
            <div class="profile-icon"><img src="images/lock.png" alt=""></div>
            <div class="profile-text-wrapper">
                <h2>Security</h2>
                <p>Change password and other info</p>
            </div>
        </div>






    </div>

</main>


<script>
    console.log("<?php $_SESSION['user_name'] ?>")
</script>


<!-- Main HTML END  -->

<?php
require_once ('components/footer.php');
?>
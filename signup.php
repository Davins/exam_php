<?php
$_title = 'Sign Up';
$_className = "signup";
require_once ('components/header.php');
?>

<section class="main-content-form">
    <div class="logo-wrapper">
        <a href="index.php"><img class="logo-black" src="images/logo-black.svg" /></a>
    </div>

    <div class="form-wrapper">
        <h1>Create Account</h1>
        <form id="form-sign-up" onsubmit="return false">
            <label for="name">Name</label>
            <input name="user_name" type="text" placeholder="At least 2 characters" class="form-name">
            <p class="error-name"></p>
            <label for="last_name">Last Name</label>
            <input name="user_last_name" type="text" placeholder="Atleast 2 characters" class="form-lname">
            <p class="error-lname"></p>
            <label for="email">Email</label>
            <input name="user_email" type="text" placeholder="Enter a valid email" class="form-email">
            <p class="error-email"></p>
            <label for="phone">Phone Number</label>
            <input name="user_phone" type="number" placeholder="Enter a valid phone number" class="form-phone">
            <p class="error-phone"></p>
            <label for="password">Password</label>
            <input name="password" type="password" placeholder="At least 8 characters" class="form-password">
            <p class="pw-icon">
                <span> <img class="info-icon" src="images/info.svg" alt=""></span> Passwords must be atleast 8 characters
            </p>
            <p class="error-pw"></p>
            <button class="sign-up-btn" onclick="signUp()">Create your Examon account</button>
        </form>
        <p class="terms">By creating an account, you agree to Examon's Conditions of Use and Privacy Notice.</p>
        <div class="divider"></div>
        <p class="exist-user">Already have an account? <a href="login.php">Log in <span>&#9654;</span></a></p>

    </div>


</section>
<section class="success hide">
    <div class="logo-wrapper">
        <a href="index.php"><img class="logo-black" src="images/logo-black.svg" /></a>
    </div>
    <p>User created</p>
    <p class="email-list"></p>
    <p> <a class="redirect" href="login.php">Click here to log in</a></p>
</section>

<script>
    const inputName = document.querySelector(".form-name");
    inputName.focus();
    inputName.select();
// Frontend validation & Error Handling
function validate(callback) {

const inputLName = document.querySelector(".form-lname");
const inputEmail = document.querySelector(".form-email");
const inputPw = document.querySelector(".form-password");
const inputPhone = document.querySelector(".form-phone");

    // Frontend validation First Name
    if (inputName.value.length < 2) {
        inputName.focus();
        document.querySelector(".error-name").innerHTML = `
            <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Enter your name, min. 2 characters`;
        inputName.style.outline = "1px solid #d00";
        inputName.style.boxShadow = " 0 0 0 3px rgb(221 0 0 / 10%) inset;";
        inputName.addEventListener("blur", function () {
            inputName.style.outline = "none";
        });
        callback(false)
        // Frontend validation Last Name
    } else if (inputLName.value.length < 2) {
        document.querySelector(".error-lname").textContent = "Last Name minimum 2 characters";
        document.querySelector(".error-name").classList.add("hide");
        inputLName.focus();
        document.querySelector(".error-lname").innerHTML = `<span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Enter your last name, min. 2 characters`;
        inputLName.style.outline = "1px solid #d00";
        inputLName.addEventListener("blur", function () {
            inputLName.style.outline = "none";
        });
        callback(false)
        // Frontend validation Phone Number
    } else if (inputPhone.value.length == !8) {
        document.querySelector(".error-email").classList.add("hide");
        inputPhone.focus();
        document.querySelector(".error-phone").innerHTML = `
            <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Phone number must be 8 characters`;
        inputPhone.style.outline = "1px solid #d00";
        inputPhone.addEventListener("blur", function () {
            inputPhone.style.outline = "none";
        });
        callback(false)
        // Frontend validation Password
    } else if (inputPw.value.length < 6) {
        document.querySelector(".error-phone").classList.add("hide");
        inputPw.focus();
        document.querySelector(".error-pw").innerHTML = `
            <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Password must be atleast 8 characters `;
        document.querySelector(".pw-icon").classList.add("hide");
        inputPw.style.outline = "1px solid #d00";
        inputPw.addEventListener("blur", function () {
            inputPw.style.outline = "none";
        });
        callback(false)
    } else {
        callback(true)
    }
}

function handleResponse(response) {
        if (response.status == 200) {
            location.href = "account-created.php";
        } else {
            // From backend - validation Email
            if (response.info === "Email is not valid") {
                document.querySelector(".error-name").classList.add("hide");
                document.querySelector(".error-lname").classList.add("hide");
                inputEmail.focus();
                document.querySelector(".error-email").innerHTML = `
            <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Please enter a valid email`;
                inputEmail.style.outline = "1px solid #d00";
                inputEmail.addEventListener("blur", function () {
                    inputEmail.style.outline = "none";
                });
            } else {
                console.error(response.info)
                return
            }
        }
    }

async function signUp() {
    validate(async (passed) => {
        if (passed) {
            try {
                const form = document.querySelector("#form-sign-up");
                let conn = await fetch("apis/api-signup.php", {
                    method: "POST",
                    body: new FormData(form),
                });
                let response = await conn.json();
                handleResponse(response)
            } catch (error) {
                console.error(error);
            }
        } 
    });
}
function handleResponse(response) {
        if (response.status == 200) {
            location.href = "account-created.php";
        } else {
            // From backend - validation Email
            if (response.info === "Email is not valid") {
                document.querySelector(".error-name").classList.add("hide");
                document.querySelector(".error-lname").classList.add("hide");
                inputEmail.focus();
                document.querySelector(".error-email").innerHTML = `
            <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Please enter a valid email`;
                inputEmail.style.outline = "1px solid #d00";
                inputEmail.addEventListener("blur", function () {
                    inputEmail.style.outline = "none";
                });
            } else {
                console.error(response.info)
                return
            }
        }
    }
</script> 
    <?php
require_once('components/footer.php');
?>
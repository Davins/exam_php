const inputName = document.querySelector(".form-name");
const inputLName = document.querySelector(".form-lname");
const inputEmail = document.querySelector(".form-email");
const inputPw = document.querySelector(".form-password");
const inputPhone = document.querySelector(".form-phone");

inputName.focus();
inputName.select();
async function signUp() {
  const form = document.querySelector("#form-sign-up");
  try {
    let conn = await fetch("apis/api-signup.php", {
      method: "POST",
      body: new FormData(form),
    });
    let response = await conn.json();

    console.log(response);
    validate();
  } catch (error) {
    console.error(error);
  }

  // Frontend validation & Error Handling
  function validate() {
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
      // Frontend validation Last Name
    } else if (inputLName.value.length < 2) {
      document.querySelector(".error-lname").textContent = "Last Name minimum 2 characters";
      document.querySelector(".error-name").classList.add("hide");
      inputLName.focus();
      document.querySelector(".error-lname").innerHTML = `
                <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Enter your last name, min. 2 characters`;
      inputLName.style.outline = "1px solid #d00";
      inputLName.addEventListener("blur", function () {
        inputLName.style.outline = "none";
      });
      // Frontend validation Email duplicate
    } else if (response.info === "Email already exists") {
      document.querySelector(".error-name").classList.add("hide");
      document.querySelector(".error-lname").classList.add("hide");
      inputEmail.focus();
      document.querySelector(".error-email").innerHTML = `
                <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Email already exists`;
      inputEmail.style.outline = "1px solid #d00";
      inputEmail.addEventListener("blur", function () {
        inputEmail.style.outline = "none";
      });
      // Frontend validation Email
    } else if (response.info === "Email is not valid") {
      document.querySelector(".error-name").classList.add("hide");
      document.querySelector(".error-lname").classList.add("hide");
      inputEmail.focus();
      document.querySelector(".error-email").innerHTML = `
                <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Please enter a valid email`;
      inputEmail.style.outline = "1px solid #d00";
      inputEmail.addEventListener("blur", function () {
        inputEmail.style.outline = "none";
      });
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
      // Frontend validation Password
    } else if (inputPw.value.length < 6) {
      document.querySelector(".error-phone").classList.add("hide");
      inputPw.focus();
      document.querySelector(".error-pw").innerHTML = `
                <span> <img class="excl-icon" src="images/excl-icon.svg" alt=""></span>Password must be atleast 6 characters `;
      document.querySelector(".pw-icon").classList.add("hide");
      inputPw.style.outline = "1px solid #d00";
      inputPw.addEventListener("blur", function () {
        inputPw.style.outline = "none";
      });
    }
    location.href = "index.php";
  }
}

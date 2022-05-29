console.log(",best");

// if (document.title != "Amazing | Sign Up") {
//   const content = document.querySelector("#main-content-container");
//   const dropdown = document.querySelector(".log-in-container");
//   const dropdownContent = document.querySelector(".log-in-content");

//   dropdown.addEventListener("mouseenter", function () {
//     content.classList.add("blur");
//   });
//   dropdownContent.addEventListener("mouseenter", function () {
//     content.classList.add("blur");
//   });
//   dropdown.addEventListener("mouseleave", function () {
//     content.classList.remove("blur");
//   });

//   dropdownContent.addEventListener("mouseleave", function () {
//     content.classList.remove("blur");
//   });
// }

if (document.title == "Profile") {
  document.querySelector(".breadcrumbs").style.display = "none";
}

if (document.title == "Profile Settings") {
  document.querySelector(".breadcrumbs").innerHTML =
    "<a class='breadcrumb-link' href='profile.php'>Your Profile</a> <span class='forward-slash'>›<span class='current-page'>Profile Settings</span>";
}

// if (document.body.classList.contains("standard")) {
//   const splashImg = document.querySelector(".splash-img");
//   splashImg.src = "images/splash-1.png";
// }
// // } else {
// //   splashImg.sec = "images/splash-2.png";
// // }

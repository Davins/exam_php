function fnbIsFormValid(oForm) {
  //console.log(oForm);
  fvDo(oForm.querySelectorAll("input[data-type]"), function (oElement) {
    oElement.classList.remove("error");
  });
  fvDo(oForm.querySelectorAll("input[data-type]"), function (oElement) {
    var sValue = oElement.value;
    var sDataType = oElement.getAttribute("data-type"); // $(oInput).attr('data-type')
    var iMin = oElement.getAttribute("data-min"); //$(oInput).attr('data-min')
    var iMax = oElement.getAttribute("data-max"); // $(oInput).attr('data-max')
    switch (sDataType) {
      case "string":
        if (sValue.length < iMin || sValue.length > iMax) {
          oElement.classList.add("error");
        }
        break;
      case "integer":
        if (!parseInt(sValue) || parseInt(sValue) < parseInt(iMin) || parseInt(sValue) > parseInt(iMax)) {
          oElement.classList.add("error");
        }
        break;
      case "email":
        var re =
          /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (re.test(String(sValue).toLowerCase()) == false) {
          oElement.classList.add("error");
        }
        break;
      default:
    }
  });

  if (oForm.querySelectorAll("input.error").length) {
    return false;
  }
  return true;
}

function fileValidation(oInput) {
  var fileInput = document.getElementById(oInput);
  var filePath = fileInput.value;
  var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
  fileInput.classList.remove("error");
  if (!allowedExtensions.exec(filePath)) {
    fileInput.classList.add("error");
    fileInput.value = "";
    return false;
  } else {
    //Image preview
    if (fileInput.files && fileInput.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById("imagePreview").innerHTML = '<img src="' + e.target.result + '"/>';
      };
      reader.readAsDataURL(fileInput.files[0]);
    }
  }
}

function fvAgentSignup(oBtn) {
  //console.log('clicked')
  var frmAgentSignup = document.querySelector("#frmAgent");
  var bIsValid = fnbIsFormValid(frmAgentSignup);
  fileValidation("upload-agent-image");
  if (bIsValid == false) {
    return;
  }
}

function fvUserSignup(oBtn) {
  //console.log('clicked')
  var frmUserSignup = document.querySelector("#frmUser");
  var bIsValid = fnbIsFormValid(frmUserSignup);
  fileValidation("upload-user-image");
  if (bIsValid == false) {
    return;
  }
}

function fvUpdateProfile(oBtn) {
  //console.log('clicked')
  var frmUserUpdate = document.querySelector(".profile-form");
  var bIsValid = fnbIsFormValid(frmUserUpdate);
  if (bIsValid == false) {
    return;
  }
}

function fvUploadProperty(oBtn) {
  //console.log('clicked')
  var frmCreateProperty = document.querySelector("#propertyForm");
  var frmCreatePropertyNumbers = document.querySelector("#propertyForm div");
  var bIsValid = fnbIsFormValid(frmCreateProperty, frmCreatePropertyNumbers);
  fileValidation("upload-property-image");
  if (bIsValid == false) {
    return;
  }
}

function fvUpdateProperty(oInput) {
  //console.log('clicked')
  //console.log(this);
  //console.log(oInput)
  var parentId = oInput.parentElement.parentElement.parentElement.parentElement.getAttribute("id");
  //console.log(parentId)
  var frmUpdateProperty = document.getElementById(parentId);
  var bIsValid = fnbIsFormValid(frmUpdateProperty);
  if (bIsValid == false) {
    return;
  }
}

function fvDo(aElements, fvCallback) {
  for (var i = 0; i < aElements.length; i++) {
    fvCallback(aElements[i]);
  }
}

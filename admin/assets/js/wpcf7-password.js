function cf7checkPasswordStrength() {
  var password = document.getElementById("cf7password").value;
  var strength = 0;
  
  if (password.length < 6) {
    document.getElementById("passwordStrength").innerHTML = "Too short";
    document.querySelector(".progress-bar").style.width = "0%";
  } else {
    if (password.match(/[a-z]+/)) {
      strength += 1;
    }
    if (password.match(/[A-Z]+/)) {
      strength += 1;
    }
    if (password.match(/\d+/)) {
      strength += 1;
    }
    if (password.match(/\W+/)) {
      strength += 1;
    }
    switch (strength) {
      case 1:
        document.getElementById("passwordStrength").innerHTML = "Weak";
        document.querySelector(".progress-bar").style.width = "25%";
        document.querySelector(".progress-bar").classList.add("bg-danger");
        break;
      case 2:
        document.getElementById("passwordStrength").innerHTML = "Moderate";
        document.querySelector(".progress-bar").style.width = "50%";
        document.querySelector(".progress-bar").classList.add("bg-warning");
        break;
      case 3:
        document.getElementById("passwordStrength").innerHTML = "Strong";
        document.querySelector(".progress-bar").style.width = "75%";
        document.querySelector(".progress-bar").classList.add("bg-info");
        break;
      case 4:
        document.getElementById("passwordStrength").innerHTML = "Very Strong";
        document.querySelector(".progress-bar").style.width = "100%";
        document.querySelector(".progress-bar").classList.add("bg-success");
        break;
    }
  }
  }

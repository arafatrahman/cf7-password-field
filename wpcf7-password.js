function cf7checkPasswordStrength() {
    var password = document.getElementById("mypassword").value;
    var strength = 0;
    
    if (password.length < 6) {
      document.getElementById("passwordStrength").innerHTML = "Too short";
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
          break;
        case 2:
          document.getElementById("passwordStrength").innerHTML = "Moderate";
          break;
        case 3:
          document.getElementById("passwordStrength").innerHTML = "Strong";
          break;
        case 4:
          document.getElementById("passwordStrength").innerHTML = "Very Strong";
          break;
      }
    }
  }

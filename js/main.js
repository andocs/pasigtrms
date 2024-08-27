window.addEventListener("load", function () {
  //sliding login signup
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form .signup-link a");
  const cancelBtn = document.getElementById("cancelBtn");
  const clock = document.querySelector(".clock");

  new DataTable("#dataTable", {
    layout: {
      topStart: 'info',
      bottomStart: {
        pageLength: {
          menu: [10, 25, 50, 100],
        },
      },
    },
  });

  if (signupBtn) {
    signupBtn.onclick = () => {
      loginForm.style.marginLeft = "-50%";
      loginText.style.marginLeft = "-50%";
    };
  }

  if (loginBtn) {
    loginBtn.onclick = () => {
      loginForm.style.marginLeft = "0%";
      loginText.style.marginLeft = "0%";
    };
  }

  if (signupLink) {
    signupLink.onclick = () => {
      signupBtn.click();
      return false;
    };
  }

  if (cancelBtn) {
    cancelBtn.onclick = () => {
      window.location.href = "index.php";
    };
  }

  if (clock) {
    // Clock
    const WEEK = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

    function updateTime() {
      var now = new Date();

      document.getElementById("time").innerText =
        zeroPadding(now.getHours(), 2) +
        ":" +
        zeroPadding(now.getMinutes(), 2) +
        ":" +
        zeroPadding(now.getSeconds(), 2);

      document.getElementById("date").innerText =
        now.getFullYear() +
        "-" +
        zeroPadding(now.getMonth() + 1, 2) +
        "-" +
        zeroPadding(now.getDate(), 2) +
        " " +
        WEEK[now.getDay()];
    }

    updateTime();
    setInterval(updateTime, 1000);
    function zeroPadding(num, digit) {
      return String(num).padStart(digit, "0");
    }
  }
});

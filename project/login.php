<!DOCTYPE html>
<html lang="en" class="html">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบจัดการนักเรียนเเละค่าใช้จ่าย</title>
  <?php include("linkframework/css.php"); ?>
</head>

<body>


  <div class="bg-login d-flex justify-content-center align-items-center">

    <div class="login-box">

      <div class="login-logo mb-5">
        <a href="" class=" d-flex justify-content-center align-items-center flex-wrap">
          <img src="./asset/image/logoschool.png" alt="logo" class="logo-login rounded-circle" loading="lazy">
          <b class=" text-dark px-1 text-pachaew">โรงเรียนอนุบาลร่มเย็น</b>
        </a>
      </div>

      <div class="card padding-card-login">
        <div class="card-body ">
          <!-- action="../backend/auth/login.php" -->
          <form method="post" class="form-login" id="form_login">
            <p class="mb-1 mt-3 fw-semibold">ชื่อผู้ใช้</p>
            <div class="input-group mb-3 ">
              <input type="username" class="form-control" placeholder="Username" name="username" require>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-alt"></span>
                </div>
              </div>
            </div>
            <p class="mb-1 mt-3 fw-semibold">รหัสผ่าน</p>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" name="password" id="password" require>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div>
              <input type="checkbox" name="show_password" id="show_password">
              <label for="show_password"> เเสดงรหัสผ่าน</label>
            </div>
            <div class="d-flex flex-column  align-items-center mt-auto">
              <button type="submit" class="btn btn-primary btn-block btn-login">เข้าสู่ระบบ</button>
              <a href="forget_password.php" class="text-dark mt-2 fw-semibold">ลืมรหัสผ่าน</a>
            </div>
          </form>
        </div>
        <div class="header-box">
          <p>LOGIN</p>
        </div>
      </div>
    </div>

  </div>
  <?php include("linkframework/js.php"); ?>
  <script>
    var form_login = document.getElementById("form_login");
    var show_password = document.getElementById("show_password");
    var password = document.getElementById("password");

    form_login.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(form_login);

      if (form_login.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      } else {
        const data = await fetch("../backend/auth/login.php", {
          method: "POST",
          body: formData
        })
        const response = await data.text();
        if (response == "ยินดีต้อนรับเข้าสู่ระบบ") {
          Swal.fire({
            icon: 'success',
            title: response,
          })
          setInterval(() => {
            location.assign("index.php");
          }, 1000);
        } else {
          form_login.reset();
          Swal.fire({
            icon: 'error',
            title: response,
          })
          setInterval(() => {
            location.assign("login.php");
          }, 1000);
        }
      }
    })
    show_password.addEventListener("click", () => {
      if (show_password.checked == true) {
        password.type = 'text';
      } else if ((show_password.checked == false)) {
        password.type = 'password';
      }
    })
  </script>
</body>

</html>
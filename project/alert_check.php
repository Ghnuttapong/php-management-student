  <script src="asset/js/sweetalert.js"></script>
  <script>
    const show_alert = async (e) => {
      const data = await fetch("../backend/auth/check_login.php?nodata=1", {
        method: "GET",
      })
      const response = await data.json();
      console.log(response);
      if (response.massage == "กรุณาเข้าสู่ระบบก่อน") {
        Swal.fire({
          icon: 'error',
          title: response.massage,
        })
        setInterval(() => {
          location.assign("login.php");
        }, 1500);
      }
    }

    show_alert();
  </script>
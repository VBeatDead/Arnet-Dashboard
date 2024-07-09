<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Telkom | Sign In</title>
  <link rel="stylesheet" href="css/main.min.css">
  <link rel="shortcut icon" href="img/LOGO BULAT.png">
  <link rel="stylesheet" href="css/override.css">


  <!-- Theme Color -->
  <meta name="theme-color" content="#008080">
  <!-- <meta name="theme-color" content="#0d6efd"> -->
  <style>
    .bd-login-form {
      min-height: 100vh;
      flex: 4;
      display: flex;
      align-items: center;
      background-position: center;
      background-size: cover;
    }

    .bd-login-cover {
      min-height: 100vh;
      flex: 3;
      background-image: linear-gradient(rgba(0, 0, 0, 0), rgba(0, 0, 0, 1)), url(/img/bg3.jpg);
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body style="background-color: var(--bs-gray-900);">
  <div class="bd-login-layout bg-light d-block d-lg-flex">

    <section class="bd-login-form">
      <!-- login form -->
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card lgn">
              <div class="card-body">
                <form action="" method="post">
                  <h3 class="text-center">Selamat Datang!</h3>
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="d-grid gap-2 mb-3">
                    <!-- <button type="submit" class="btn btn-primary">Login</button> -->
                    <a href="./index.html" class="btn btn-primary">Register</a>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="bd-login-cover p-3 p-5 pb-0 d-flex flex-column justify-content-between">
      <!-- tampilkan logo dan deskripsi aplikasi -->
      <div>
        <img src="/img/LOGO BULAT.png" alt="Logo" height="75" class="mb-3">
      </div>

      <div>
        <div class="card dsc">
          <!-- card body -->
          <div class="card-body ">

            <h1 class="card-title">
              <span style="color: red;">A</span>
              <span style="color: yellow;">K</span>
              <span style="color: red;">H</span>
              <span style="color: orange;">L</span>
              <span style="color: pink;">A</span>
              <span style="color: cyan;">K</span>
            </h1>
            <div class="text-white">
              <p class="text-justify">Merupakan core values yang dimiliki oleh BUMN sebagai identitas dan perekat budaya kerja yang mendukung peningkatan kinerja secara berkelanjutan </p>
              <ul>
                <li><span style="color: red;">A</span>MANAH</li>
                <li><span style="color: yellow;">K</span>OMPETEN</li>
                <li><span style="color: red;">H</span>ARMONIS</li>
                <li><span style="color: orange;">L</span>OYAL</li>
                <li><span style="color: pink;">A</span>DAPTIF</li>
                <li><span style="color: cyan;">K</span>OLABORATIF</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div>
        <p class="text-white">© 2024. All rights reserved.</p>
      </div>
    </section>

  </div>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
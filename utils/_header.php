<?php if (isset($_SESSION['logged-in']) && $_SESSION['logged-in']) : ?>


  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-md-3 mb-2 mb-md-0">
      <a href="/forum/" class="d-inline-flex link-body-emphasis text-decoration-none text-light px-5">
        <strong>Discussion-Dock</strong>
      </a>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="/forum/" class="nav-link px-2">Home</a></li>
      <li><a href="/forum/blogs.php" class="nav-link px-2">Blogs</a></li>
      <li><a href="/forum/categories.php" class="nav-link px-2">Categories</a></li>
    </ul>

    <div class="col-md-3 text-end">



      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

        <li class="nav-item dropdown" data-bs-theme="dark">
          <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
              <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
              <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
            </svg>
          </a>
          <ul class="dropdown-menu">
            <li class="text-center" style="font-size: 14px;">Hello , ' . $_SESSION['username'] . ' </li>
            <li><a class="dropdown-item" href="/forum/profile.php">My Account</a></li>
            <li>

              <hr class="dropdown-divider">

            </li>
            <li><a class="dropdown-item" href="/forum/logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>


    </div>
  </header>
<?php else : ?>
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-md-3 mb-2 mb-md-0">
      <a href="/forum/" class="d-inline-flex link-body-emphasis text-decoration-none text-light px-5">
        <strong>Discussion-Dock</strong>
      </a>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="/forum/" class="nav-link px-2 ">Home</a></li>
      <li><a href="/forum/blogs.php" class="nav-link px-2">Blogs</a></li>
      <li><a href="/forum/categories.php" class="nav-link px-2">Categories</a></li>

    </ul>

    <div class="col-md-3 text-end">

      <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Sign-up</button>

    </div>
  </header>
<?php endif; ?>
<link rel="icon" href="Pic/logo.svg" type="image/x-icon">

<style>

    *{
        font-family: Arial, sans-serif;
    }
    
    .navbar{
            display:none
        }

    .row>h1,h1{
        text-align: center;
        font-size: 30pt;
    }
    


    .main-content{
        height: 100vh;
        overflow-x: hidden;
        padding-left: 5%;
    }

    .main-content{
        position: relative;
        background-color: #f5f7fa;
        top:0;
        left:80px;
        transition: all 0.5s ease;
        width: calc(100% - 80px);
        padding: 1rem;
    }


    @media only screen and (max-width: 992px) {
        .sidebar{
            display: none;
        }

        .main-content{
        top:50px;
        left:0px;
        width: 100%;
        }

        .navbar{
            display: block;
            background-color: #12171e;
        }

        .navbar{
            display: block;
            background-color: #12171e;
        }
        .navbar-toggler{
            height: 30px;
            padding-top: 0px;
        }
        .navbar-toggler-icon{
            font-size: 8pt;
            margin-top: 0px;
        }
    }
</style>


<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">UH ADMIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">MENU</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admin-dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-product.php">Products</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-billiard.php">Billiads</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="admin-song.php">Song</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-order.php">Orders</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-bill.php">Bills</a>
            </li>

            <li class="nav-item">
            <a class="nav-link " href="admin-table.php">Table</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-history.php">History</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-sales.php">Sales</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-staff.php">Staff</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-comment.php">Comment</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="admin-signup.php">Create Account</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admin-concern.php">Customer's Concerns</a>
                </li>

            <style>
                .navlogout{
                    
                    width:20%;
                    background-color: white;
                    color: black;
                    border-radius: 10px;
                }
            </style>

            <div class="lii">
                <form action="" method="post" onsubmit="return confirmLogout()">
                    <button type="submit" name="logout" class="logout-button navlogout">
                        <i class='bx bx-log-out'></i>
                    </button>
                </form>
            </div>

      </div>
    </div>
  </div>
</nav>



<div class="sidebar">
    <div class="top">
        <i class="bx bx-menu" id="btn"></i>
    </div>

    <div class="user">
        <img src="Pic/logo.png" alt="me" class="user-img">
        <div class="logo">
            <span>University Hills</span>
        </div>
        <div>
            <p class="bold">Welcome, Admin!</p>
        </div>
    </div>
        <div class="lii">
            <a href="admin-dashboard.php">
                <i class="bx bxs-grid-alt"></i>
                <span class="nav-item">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </div>
            
        <div class="lii">
            <a href="admin-product.php">
                <i class="fi fi-ss-hamburger-soda"></i>
                <span class="nav-item">Products</span>
            </a>
            <span class="tooltip">Products</span>
        </div>

        <div class="lii">
            <a href="admin-billiard.php">
            <i class="fa-solid fa-bowling-ball"></i>
                <span class="nav-item">Billiard</span>
            </a>
            <span class="tooltip">Billiard</span>
        </div>

        <div class="lii">
            <a href="admin-song.php">
            <i class="fa-solid fa-music"></i>
                <span class="nav-item">Song</span>
            </a>
            <span class="tooltip">Song Request</span>
        </div>

        <div class="lii">
            <a href="admin-order.php">
            <i class="fi fi-bs-shopping-cart-check"></i>
                <span class="nav-item">Order</span>
            </a>
            <span class="tooltip">Order</span>
        </div>

        <div class="lii">
            <a href="admin-bill.php">
            <i class="fa-solid fa-money-check-dollar"></i>
                <span class="nav-item">Bills</span>
            </a>
            <span class="tooltip">Bills</span>
        </div>

        <div class="lii">
            <a href="admin-table.php">
            <i class="fa-solid fa-key"></i>
                <span class="nav-item">Table</span>
            </a>
            <span class="tooltip">Table</span>
        </div>

        <div class="lii">
            <a href="admin-history.php">
                <i class='bx bx-history'></i>
                <span class="nav-item">History</span>
            </a>
            <span class="tooltip">History</span>
        </div>

        <div class="lii">
            <a href="admin-sales.php">
                <i class="fa-solid fa-coins"></i>
                <span class="nav-item">Sales</span>
            </a>
            <span class="tooltip">Sales</span>
        </div>
        
        <div class="lii">
            <a href="admin-staff.php">
                <i class="fa-solid fa-user"></i>
                <span class="nav-item">Staff</span>
            </a>
            <span class="tooltip">Staff</span>
        </div>

        <div class="lii">
            <a href="admin-comment.php">
                <i class="fa-solid fa-comments"></i>
                <span class="nav-item">Comment</span>
            </a>
            <span class="tooltip">Comment</span>
        </div>

        <div class="lii">
            <a href="admin-signup.php">
                <i class="fa-solid fa-user-plus"></i>
                <span class="nav-item">Account</span>
            </a>
            <span class="tooltip">Create Account</span>
        </div>

        <div class="lii">
            <a href="admin-concern.php">
            <i class="fa-solid fa-exclamation-triangle"></i>
                <span class="nav-item">Concerns</span>
            </a>
            <span class="tooltip">Customer's Concerns</span>
        </div>

    

        <div class="lii">
            <form action="" method="post" onsubmit="return confirmLogout()">
                <button type="submit" name="logout" class="logout-button">
                <i class='bx bx-log-out'></i>
                </button>
            </form>
            <span class="tooltip">Logout</span>
        </div>
</div>

<script>
    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }
</script>

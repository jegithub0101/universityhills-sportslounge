<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>
<link rel="icon" href="Pic/logo.svg" type="image/x-icon">
<style>

*{
        font-family: Arial, sans-serif;
    }

        .row>h1,h1{
            text-align: center;
            font-size: 30pt;
        }
        .navbar{
                display:none
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

        }

</style>



<nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">UH STAFF</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="staff-orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff-bills.php">Bills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff-billiard.php">Billiards</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="staff-song.php">Song</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="staff-table.php">Table</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="staff-assist.php">Assist</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="staff-concern.php">Concerns</a>
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
                </ul>
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
                <p class="bold">Welcome, Staff!</p>
            </div>
        </div>
                
        <div class="lii">
            <a href="staff-orders.php">
            <i class="fi fi-bs-shopping-cart-check"></i>
                <span class="nav-item">Orders</span>
            </a>
            <span class="tooltip">Orders</span>
        </div>

        <div class="lii">
            <a href="staff-bills.php">
            <i class="fa-solid fa-money-check-dollar"></i>
                <span class="nav-item">Bills</span>
            </a>
            <span class="tooltip">Bills</span>
        </div>
        

        <div class="lii">
            <a href="staff-billiard.php">
            <i class="fa-solid fa-bowling-ball"></i>
                <span class="nav-item">Billiard</span>
            </a>
            <span class="tooltip">Billiard</span>
        </div>

        <div class="lii">
            <a href="staff-song.php">
                <i class="fa-solid fa-music"></i>
                <span class="nav-item">Song</span>
            </a>
            <span class="tooltip">Song Request</span>
        </div>

        <div class="lii">
            <a href="staff-table.php">
                <i class="fa-solid fa-key"></i>
                <span class="nav-item">Table</span>
            </a>
            <span class="tooltip">Table</span>
        </div>

        <div class="lii">
            <a href="staff-assist.php">
                <i class="fa-solid fa-hands-helping"></i>
                <span class="nav-item">Assist</span>
            </a>
            <span class="tooltip">Staff-Assist </span>
        </div>

        <div class="lii">
            <a href="staff-concern.php">
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
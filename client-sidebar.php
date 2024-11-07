<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-straight/css/uicons-bold-straight.css'>


<?php
        function isAssist()
        {
            return isset($_SESSION['staff_access'] );
        }
?>

<style>

    .nickname{
        text-align: center;
        margin-bottom: 3%;    
        word-wrap: break-word;  /* Allows breaking long words onto a new line */
        white-space: normal;
        max-width: 80%;
        border-bottom: 2px solid white;
        padding-bottom: 10px;
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
        padding-left: 0%;
        
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


<style>

.inputsong{
    width: 30%;
    float: left;
    margin-right: 30px;
    
}
#songform{
    margin-top: 15px;
    margin-bottom: 0px;
}
#songform{
    display: none;
}

.tab{
    background-color: white;
    color: black;
    font-weight: 600;
    margin-left: 1%;
    margin-top: 10px;
}

@media only screen and (max-width: 992px) {
    
    .inputsong{
        width: 70%;
        margin-right:1%;
    }
    .rquestbtn{
        width: 25%;
        font-size: 10pt;
    }
    .foraccurate{
        font-size: 10pt;
        clear: both;
    }

}
@media only screen and (max-width: 840px) {
    .main-content{
        padding-left: 1%;
    }
}

@media only screen and (max-width: 732px){
    .navbar-brand{
        font-size: 13pt;
    }
    .tab{
        background-color: white;
        color: black;
        font-weight: 600;
        margin-top: 10px;
        border: 1px solid #12171e;
        width: 66px;
        font-size: 9pt;
        text-align: center;
    }
    .main-content{
        padding-left: 10px;
        padding-right: 0%;
        
    }
}
@media only screen and (max-width: 380px){
    .tab{
        background-color: white;
        width: 60px;
        font-size: 9pt;
        padding-left: 13px;
        
    }
}
@media only screen and (max-width: 320px){
    .tab{
        background-color: white;
        width: 54px;
        font-size: 9pt;
        padding-left: 9px;
        
    }
}



.sticky-cart {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        background-color: #007bff;
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s, box-shadow 0.3s;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }
    .sticky-cart:hover {
        background-color: #0056b3;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }


        /* General Navigation Tabs Styling */
    .nav-tabs {
        border-bottom: none;
        justify-content: center;
        background-color: #343a40; /* Dark background for the tab area */
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-wrap: wrap;
        width: 95%;
    }

    .nav-link {
        color: #f8f9fa; /* White text for inactive tabs */
        font-weight: 600;
        font-size: 16px;
        padding: 12px 20px;
        margin: 0 10px;
        border: none;
        background-color: #6c757d; /* Gray background for inactive tabs */
        border-radius: 30px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        white-space: nowrap; /* Prevents text from wrapping */
    }

    .nav-link:hover {
        background-color: #495057; /* Darker gray for hover */
        color: #ffffff; /* Bright white for hover state */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow on hover */
    }

    .nav-link.active {
        background-color: #212529; /* Darker for the active tab */
        color: #ffffff; /* White text for active tab */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4); /* Stronger shadow for active */
    }

    .nav-link:focus {
        outline: none;
    }

    .tab {
        cursor: pointer;
    }

    /* Responsive Design for Mobile Devices */
    @media (max-width: 768px) {
        .nav-tabs {
            flex-direction: column;
            align-items: stretch; /* Make tabs stretch across the screen */
        }

        .nav-link {
            width: 100%; /* Full-width tabs */
            text-align: center; /* Center-align text */
            margin: 5px 0; /* Add space between vertical tabs */
            font-size: 18px; /* Increase font size for easier tapping */
            padding: 15px; /* Larger tap area for mobile */
        }
    }

    /* Responsive Design for Extra Small Screens */
    @media (max-width: 480px) {
        .nav-link {
            font-size: 16px; /* Slightly smaller font for very small screens */
            padding: 12px; /* Adjust padding for smaller devices */
        }
    }

</style>



<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">University Hills Sport Lounge</a>
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
                    <a class="nav-link active" aria-current="page" href="client-product.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-cart.php">My Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="client-order.php">Monitoring</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link "  href="client-concern.php">Report Concern</a>
                </li>

                <?php
                if (isAssist()) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link "  href="staff-asssist.php">Assist</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
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
            <p class="bold">Welcome, Table <?php echo $_SESSION['table_number']; ?></p>
            <p class="nickname"> <?php echo $_SESSION['table_name']; ?></p>
        </div>
    </div>
            
        <div class="lii">
            <a href="client-product.php">
                <i class="fi fi-ss-hamburger-soda"></i>
                    <span class="nav-item">Order</span>
            </a>
            <span class="tooltip">Order</span>
        </div>

        <div class="lii">
            <a href="client-cart.php">
            <i class="fa-solid fa-cart-plus"></i>
                <span class="nav-item">Cart</span>
            </a>
            <span class="tooltip">Your Cart</span>
        </div>

        <div class="lii">
            <a href="client-order.php">
            <i class="fi fi-ss-overview"></i>
                <span class="nav-item">Monitoring</span>
            </a>
            <span class="tooltip">Monitoring</span>
        </div>

        <div class="lii">
            <a href="client-concern.php">
            <i class="fa-solid fa-exclamation-triangle"></i>
                <span class="nav-item">Concern</span>
            </a>
            <span class="tooltip">Submit Concern</span>
        </div>
        
        <?php

        if (isAssist()) {
            ?>
            <div class="lii">
                <a href="staff-assist.php">
                    <i class="fa-solid fa-hands-helping"></i>
                    <span class="nav-item">Assist</span>
                </a>
                <span class="tooltip">Staff-Assist </span>
            </div>
            <?php
        }
        ?>
</div>


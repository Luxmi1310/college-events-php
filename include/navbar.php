<div class="main-nav">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md navbar-light">
            
            <a class="navbar-brand" href="index.php" style="display: flex; align-items: center; text-decoration: none;">
                <div style="background: #ffb700; color: #000; padding: 5px 12px; border-radius: 4px; font-weight: 900; font-size: 22px; margin-right: 10px; line-height: 1;">
                    DD
                </div>
                <div style="color: #000; font-weight: 700; font-size: 22px; letter-spacing: 1px; text-transform: uppercase; line-height: 1;">
                    JAIN Events
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About Us</a></li>
                    <li class="nav-item"><a href="schedules.php" class="nav-link">Events</a></li>
                    <li class="nav-item"><a href="sponsors.php" class="nav-link">Sponsors</a></li>
                    <li class="nav-item"><a href="student_Profile.php" class="nav-link">Student Profile</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact Us</a></li>
                </ul>

                <div class="others-option-vg d-flex align-items-center">
                    <div class="option-item">
                        <?php if(!isset($_SESSION['logged_memebers'])): ?>
                            <a href="login.php" class="default-btn">Login <i class='bx bx-plus'></i></a>
                        <?php else : ?>
                            <a href="logout.php" class="default-btn">Logout <i class='bx bx-plus'></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
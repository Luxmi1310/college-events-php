<?php // print_r($_SESSION); ?>
<div class="navbar-area"> 
            <!-- Start Menu For Mobile Device -->  
            <div class="container"> 
                <div class="mobile-nav">  
                    <div class="logo">
                        <a href="index.php"> 
                            <img src="assets/images/logo-one.png" class="logo-light" alt="images">   
                            <img src="assets/images/logo-two.png" class="logo-dark" alt="images">   
                        </a> 
                    </div>
                </div>  
            </div> 
            <!-- End Menu For Mobile Device --> 
            
            <div class="main-nav">         
                <div class="container-fluid">    
                    <nav class="navbar navbar-expand-md navbar-light">   

                        <a href="index.php">   
                            <img src="assets/images/logo-one.png" class="logo-light" alt="images">   
                            <img src="assets/images/logo-two.png" class="logo-dark" alt="images">   
                        </a>   

                         <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent"> 
                            <ul class="navbar-nav m-auto">  
                                <li class="nav-item">  
                                    <a href="index.php" class="nav-link ">
                                        Home
                                    </a>
                                </li> 

                                <li class="nav-item"> 
                                    <a href="about.php" class="nav-link ">
                                        About Us
                                    </a>    
                                </li> 
									<li class="nav-item"> 
                                    <a href="schedules.php" class="nav-link ">
                                        Events
                                    </a>   
                                </li>
								<li class="nav-item"> 
                                    <a href="sponsors.php" class="nav-link">Sponsors</a>     
                                </li>
								<li class="nav-item"> 
                                    <a href="student_Profile.php" class="nav-link">Student_Profile</a>     
                                </li>
                                <li class="nav-item"> 
                                    <a href="contact.php" class="nav-link">Contact Us</a>      
                                </li> 
                            </ul> 
                            <div class="others-option-vg d-flex align-items-center"> 
                               <div class="option-item">
									<?php if(!isset($_SESSION['logged_memebers'])): ?>
                                    <a href="login.php" class="default-btn">Login<i class='bx bx-plus' ></i></a>
									<?php else : ?>
									<a href="logout.php" class="default-btn">Logout<i class='bx bx-plus' ></i></a>	
				
									<?php endif; ?>									
                                </div>
                            </div>
                        </div>
                    </nav> 
                </div>
            </div>  

            <div class="others-option-for-responsive"> 
                <div class="container">
                    <div class="dot-menu">
                        <div class="inner">
                            <div class="circle circle-one"></div>
                            <div class="circle circle-two"></div>
                            <div class="circle circle-three"></div>
                        </div>
                    </div>
                    
                    <div class="container">
                        <div class="option-inner">
                            <div class="others-option justify-content-center d-flex align-items-center">

                                <div class="option-item">
                                    <form class="search-form">
                                        <input class="search-input" placeholder="Search Here" type="text">
            
                                        <button type="submit" class="search-button">
                                            <i class='bx bx-search' ></i>
                                        </button>
                                    </form>
                                </div>

                                 <div class="option-item">
                                    <a href="pricing.html" class="default-btn">Get Free Estimate <i class='bx bx-plus' ></i></a> 
                                </div>
                                
                            </div>
                        </div> 
                    </div>
                </div>
            </div>    
        </div>
<div class="footer-area pt-100 jarallax" data-jarallax='{"speed": 0.3}'>
    <div class="container">
        <div class="row">
            
            <div class="col-xl-3 col-lg-12 col-md-4">
                <div class="footer-widget">
                    <a href="index.php" style="text-decoration: none; display: flex; align-items: center; margin-bottom: 20px;">
                        <div style="display: flex; align-items: center; font-family: sans-serif;">
                            <div style="background:#fbc015; color: #000; padding: 5px 12px; border-radius: 4px; font-weight: 900; font-size: 22px; margin-right: 10px;">DD</div>
                            <div style="color: #fff; font-weight: 700; font-size: 22px; letter-spacing: 1px; text-transform: uppercase;">JAIN events</div>
                        </div>
                    </a>
                    <p>A College Events Management Project involves planning and organizing events like fests, seminars, and sports activities. . The goal is to ensure smooth execution and a successful event experience.</p>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-4">
                <div class="footer-widget footer-widget-link">
                    <h2>Useful Links</h2>
                    <ul class="footer-widget-list">
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="schedules.php">Events</a></li>
                        <li><a href="sponsors.php">Sponsors</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-4">
                <div class="footer-widget footer-widget-link2">
                    <h2>Collage Events</h2>
                    <ul class="footer-widget-list">
                        <li><a href="schedules.php">Events Management</a></li>
					
                        <li><a href="#">Created By Group 2</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-3 col-lg-12 col-md-12">
                <div class="footer-instagram">
                    <h2>Event Gallery</h2>
                    <div class="row px-2">
					
                        <?php
                        // Set a tiny timeout so it doesn't hang the page
                        mysqli_report(MYSQLI_REPORT_OFF); 
                        
                        // TRY TO CONNECT
                        $conn = @mysqli_connect("localhost", "root", "", "event");

                        if ($conn) {
                            // Check if the table exists first to avoid fatal errors
                            $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'create_events'");
                            
                            if (mysqli_num_rows($check_table) > 0) {
                                $query = "SELECT event_image FROM create_events ORDER BY 1 DESC LIMIT 6";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $img = $row['event_image'];
                                        $path = "admin/uploads/" . $img; 
                                        echo '
                                        <div class="col-4 p-1">
                                            <div class="instagram-img">
                                                <img src="'.$path.'" style="width:100%; height:60px; object-fit:cover; border-radius:3px;" 
                                                     onerror="this.style.display=\'none\';">
                                            </div>
                                        </div>';
                                    }
                                } else {
                                    echo "<p style='color:#777; font-size:11px;'>No images found.</p>";
                                }
                            } else {
                                echo "<p style='color:#777; font-size:11px;'>Table not found.</p>";
                            }
                            mysqli_close($conn);
                        } else {
                            // If connection fails, show NOTHING so the page doesn't hang
                            echo "<p style='color:#777; font-size:11px;'>Gallery unavailable.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="copyright-content" style="margin-top: 50px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
            <p>© <b>Events Management</b> | Developed by <span class="text-warning">Luxmi</span></p>
        </div>
    </div>
</div>
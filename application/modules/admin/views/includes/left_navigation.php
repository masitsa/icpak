
    <!-- Sidebar -->
    <div class="sidebar sidebar-fixed">
        <div class="sidebar-dropdown"><a href="#">Navigation</a></div>

        <div class="sidebar-inner">
        
            <!--- Sidebar navigation -->
            <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
            <ul class="navi">

                <!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->
                <?php
                if($this->session->userdata('user_type') == 1)
                {
                    ?>
                    <li><a href="<?php echo base_url()."admin";?>"><i class="icon-desktop"></i> Dashboard</a></li>

                    <!-- Start: Admin Menu -->
                    <li class="has_submenu">
                        <a href="#">
                            <!-- Menu name with icon -->
                            <i class="icon-th"></i> ICPAK Community
                            <!-- Icon for dropdown -->
                        </a>
                        <ul>
                            <li><a href="<?php echo base_url()."all-member";?>">ICPAK Members</a></li>
                            <li><a href="<?php echo base_url()."all-users";?>">ICPAK Live Admins</a></li>
                        </ul>
                    </li>
    				
                    <li class="has_submenu">
                        <a href="#">
                            <!-- Menu name with icon -->
                            <i class="icon-th"></i> Events
                            <!-- Icon for dropdown -->
                        </a>
                        <ul>
                            <li><a href="<?php echo base_url()."all-events";?>">Events</a></li>
                            <li><a href="<?php echo base_url()."all-event-session";?>">Event Sessions</a></li>
                            <li><a href="<?php echo base_url()."all-session-admin";?>">Session Admins</a></li>
                            <li><a href="<?php echo base_url()."live-stream";?>">Live Streaming</a></li>
                            <li><a href="<?php echo base_url()."all-recording";?>">Video recordings</a></li>
                        </ul>
                    </li>

                     <!-- Start: Blog Menu -->
                    <li class="has_submenu">
                        <a href="#">
                            <!-- Menu name with icon -->
                            <i class="icon-th"></i> Pro social
                            <!-- Icon for dropdown -->
                        </a>
                        <ul>
                            <li><a href="<?php echo base_url()."technical-queries";?>">Technical Queries</a></li>
                            <li><a href="<?php echo base_url()."standards-queries";?>">Standards Queries</a></li>
                        </ul>
                    </li>

                     <li class="has_submenu">
                        <a href="#">
                            <!-- Menu name with icon -->
                            <i class="icon-th"></i> User Feedback
                            <!-- Icon for dropdown -->
                        </a>
                        <ul>
                            <li><a href="<?php echo base_url()."feedback";?>">Feedback</a></li>
                        </ul>
                    </li>
                <?php
                }
                else
                {
                    ?>
                    <li><a href="<?php echo base_url()."my-sessions";?>"><i class="icon-desktop"></i> My sessions</a></li>
                    <?php
                }
                ?>

              

            </ul>
        </div>
    </div>
    <!-- Sidebar ends -->

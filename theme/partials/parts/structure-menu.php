<!-- BEGIN MENU BUTTON -->
<div class="minimenu-menu-button-wrapper">
    <div class="minimenu-menu-tooltip"></div>
    <div class="minimenu-menu-button-wrapper-inner">
        <div class="minimenu-menu-button"></div>
        <div class="minimenu-menu-button-middle"></div>
    </div>
    <div class="minimenu-menu-button-text-wrapper">
        <div class="minimenu-menu-button-text">Explore</div>
    </div>
</div>
<!-- END MENU BUTTON -->

<!-- BEGIN MENU + SOCIAL BAR -->
<div class="minimenu-by-bonfire-wrapper">
    
    <!-- BEGIN MENU -->
    <div class="minimenu-close-button"></div>
    <div class="minimenu-by-bonfire">
        <div class="minimenu-by-bonfire-inner">
            <div class="menu-minimenu-menu-container">
                <!-- BEGIN MENU ITEMS -->
                <ul>
                    <li><a href="<?php echo site_url('member/profile') ?>">My Profile</a>
                    <div class="minimenu-menu-item-description">Just a little bit of your background so we can connect.</div></li>
                    <?php if(! current_user_can('administrator') ): ?>
                        <li><a href="#">Ask me</a>
                        <div class="minimenu-menu-item-description">Send the author your post related queries.</div></li>
                    <?php endif; ?>
                    <li class="menu-item-has-children"><a href="#">Account</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo site_url('member/subscribe') ?>">Subscription</a> | </li>
                            <li class="menu-item-has-children"><a href="#">Setup:</a>
                                <ul class="sub-menu">
                                    <li><a href="<?php echo  site_url('member/password/change'); ?>">Password</a></li>
                                    <!-- <li><a href="#">GPU</a>,</li> -->
                                    <!-- <li><a href="#">Motherboard</a> | </li> -->
                                </ul>
                            </li>
                            <!-- <li><a href="#">New tech</a></li> -->
                        </ul>
                    </li>
                    <!-- <li><a href="#">Your Social Network</a>
                    <div class="minimenu-menu-item-description">Share you social.</div></li> -->
                    <li><a href="<?php echo site_url('logout') ?>">Logout</a></li>
                </ul>
                <!-- END MENU ITEMS -->
            </div>
            <!-- <img style="width:100%;" src="minimenu/img/placeholder.jpg"> -->
        </div>
    </div>
    <!-- END MENU -->

    <!-- BEGIN SOCIAL -->
    <div class="minimenu-social-bar-wrapper">
        <div class="minimenu-social-bar-label">SOCIAL:</div>
        <div class="minimenu-social-bar-icons">
            <a href="#">
                <span class="minimenu-icon-youtube"></span>
            </a>
            <a href="#">
                <span class="minimenu-icon-twitter"></span>
            </a>
            <a href="#">
                <span class="minimenu-icon-facebook"></span>
            </a>
            <a href="#">
                <span class="minimenu-icon-instagram"></span>
            </a>
            <a href="#">
                <span class="minimenu-icon-google-plus"></span>
            </a>
        </div>
    </div>
    <!-- END SOCIAL -->
</div>
<!-- BEGIN MENU + SOCIAL BAR -->
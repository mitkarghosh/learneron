<?php $session = $this->request->session(); ?>
<header class="header">
    <div class="header-block header-block-collapse hidden-lg-up">
        <button class="collapse-btn" id="sidebar-collapse-btn">
            <i class="fa fa-bars"></i>
        </button>
    </div>
    <div class="header-block header-block-nav">
        <ul class="nav-profile">
            <li class="profile dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="name">
                      <?php echo $this->request->Session()->read('Auth.Admin.first_name').' '.$this->request->Session()->read('Auth.Admin.last_name'); if($this->request->Session()->read('Auth.Admin.type') == 'SA'): echo "(Super Admin)"; else: "(Account Manager)"; endif; ?>
                    </span>
                </a>
                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="<?php echo $this->request->webroot; ?>admin/admin-details/profile"> <i class="fa fa-user icon"></i> Profile </a>
				<?php if( (!empty($session->read('AdminUser')) && $session->read('AdminUser.type')=='SA') ){?>
					<a class="dropdown-item" href="<?php echo $this->request->webroot; ?>admin/settings"> <i class="fa fa-cog icon"></i> Settings</a>
				<?php } ?>
                    <a target="_blank" class="dropdown-item" href="<?php echo $this->request->webroot; ?>"> <i class="fa fa-external-link icon"></i> Website </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo $this->request->webroot; ?>admin/admin-details/logout"> <i class="fa fa-power-off icon"></i> Logout </a>
                </div>
            </li>
        </ul>
    </div>
</header>
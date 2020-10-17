<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
	        <div class="pull-left image">
	          	<img src="<?php echo base_url() ?>assets/dist/img/profile_pic.png" class="img-circle" alt="User Image">
	        </div>
	        <div class="pull-left info">
	          	<p>Super Admin</p>
	        </div>
	    </div>
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MAIN NAVIGATION</li>
			<li class="<?php if($menu == 'leaders'){ echo 'active';}?>">
				<a href="<?php echo base_url()?>admin-panel/leaders">
					<i class="fa fa-fw fa-university"></i>
					<span>Manage Leader
						<!-- <span class="pull-right-container">
                            <small class="label pull-right count-style">0</small>
                        </span> -->
                   	</span>
				</a>
			</li>
			<li class="<?php if($menu == 'new_leaders'){ echo 'active';}?>">
				<a href="<?php echo base_url()?>admin-panel/new-leaders">
					<i class="fa fa-fw fa-university"></i>
					<span>Manage New Leader
						<!-- <span class="pull-right-container">
                            <small class="label pull-right count-style">0</small>
                        </span> -->
                   	</span>
				</a>
			</li>
		</ul>
	</section>
</aside>
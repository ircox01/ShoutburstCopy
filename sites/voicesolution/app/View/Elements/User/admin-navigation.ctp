<nav>
    <div class="container">
		<?php
		if(AuthComponent::user('id')) { ?>
        <ul class="nav nav-pills  pull-right">
            <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="icon-user"></i><?php echo AuthComponent::user('username') ;?> 
					<i class="icon-caret-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li class="nav-header">
						Logged in as:
					</li>
					<li class="text">
						<?php echo $this->Session->read('Auth.User.username');?>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="<?php echo $this->Html->url('/admin/logout');?>"><i class="icon-share-alt"></i> Logout</a>
					</li>
				</ul>
			</li>			
        </ul>
		<div style="margin-top:-40px;" class="padding0 pull-right">
			<?php } else { ?>
				<ul style="width:70%;" class="nav nav-pills">
				</ul>
			<?php }?>
		</div>		
	 </div>
</nav>
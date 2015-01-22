<nav>
    <div class="container">
		<?php
		if(AuthComponent::user('id')) { ?>
		<ul class="nav nav-pills  pull-left">
            <li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Users <i class="icon-caret-down"></i></a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index'));?>"><i class="icon-edit"></i> View Users</a>
					</li>
					<li class="divider">
					<li>
						<a href="<?php echo $this->Html->url(array('controller' => 'users','action' => 'add'));?>"><i class="icon-user"></i>New Admin User</a>
					</li>
					
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"> Companies <i class="icon-caret-down"></i></a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?php echo $this->Html->url(array('controller' => 'companies', 'action' => 'index'));?>"><i class="icon-edit"></i> View Companies</a>
					</li>
					<li class="divider">
					<li>
						<a href="<?php echo $this->Html->url(array('controller' => 'companies','action' => 'add'));?>"><i class="icon-user"></i>New Company</a>
					</li>
				</ul>
			</li>			
			<li>
				<a href="<?php echo $this->Html->url(array('controller' => 'recordings', 'action' => 'index'));?>"> Recordings </a>
			</li>	
			<li>
				<a href="<?php echo $this->Html->url(array('controller' => 'recordingemails', 'action' => 'index'));?>"> Recording Emails </a>
			</li>	
        </ul>
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
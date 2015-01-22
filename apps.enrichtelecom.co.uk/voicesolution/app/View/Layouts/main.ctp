<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<?php echo $this->element('Base/header'); ?>
    <body>
        <div id="wrap">
            <?php echo $this->element('Content/header'); ?>
            <div id="pages-content" class="wrapper">
                <div class="container">
					
					<div class="row-fluid">
						<div class="col-lg-3">
							&nbsp;
						</div>
						<div class="col-lg-6">
							<?php echo $this->Session->flash(); ?>
							<?php echo $this->fetch('content'); ?>
						</div>
						<div class="col-lg-3">
							&nbsp;
						</div>
					</div>                    
                </div>
            </div>
            <div class="push"></div>            
        </div>        
        <?php            
            
            echo $this->Html->script('bootstrap.min');
            echo $this->Html->script('html5');
            echo $this->Html->script('script');
            echo $this->fetch('script');
        ?>        
    </body>
</html>

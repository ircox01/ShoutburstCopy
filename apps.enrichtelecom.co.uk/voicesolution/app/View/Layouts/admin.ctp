<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Voice2EmailSolution -
        <?php echo $title_for_layout; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- @todo: fill with your company info or remove -->
    <meta name="description" content="">
    <meta name="author" content="alniejacobe.com"> 
    <?php
        
		echo $this->Html->css('bootstrap-responsive');
		echo $this->Html->css('bootstrap');
		echo $this->Html->css('font-awesome');
		echo $this->Html->css('font-awesome-social');
		echo $this->Html->css('voicesolution-style.min');
		echo $this->Html->css('tabs');
		
		echo $this->Html->css('custom');
		
		echo $this->Html->meta('icon');

        echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
    ?>
</head>
<body>
	<div id="wrap">
            <!-- Header -->
            <?php echo $this->element('User/header');?>
            <!-- Header /-->
            <!-- Navigation -->
             <?php
				echo $this->element('User/admin-navigation');
			?>
            <!-- Navigation /-->
            <!-- Content -->
            <div id="pages-content" class="wrapper">
                <div class="container">
                    <div class="row-fluid">
                        <div class="col-lg-12 paddingleft">
                            <div class="row-fluid">
                                <?php echo $this->Session->flash(); ?>
                                <?php echo $this->fetch('content');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Content /-->
            <div class="push"></div>
        </div><!-- wrap /-->
		<!-- Footer -->
        <?php echo $this->element('User/footer');?>
        <!-- Footer /-->
	<!--?php echo $this->element('sql_dump'); 
		  echo $this->Js->writeBuffer();
	?-->
		<!--Scripts --> 
         <?php            
            echo $this->Html->script('jquery');
            echo $this->Html->script('bootstrap.min');
            echo $this->Html->script('html5');
            echo $this->Html->script('script');
            echo $this->fetch('script');

            echo $this->Js->writeBuffer(); // Write cached scripts
        ?>     
</body>
</html>

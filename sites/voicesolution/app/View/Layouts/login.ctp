<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">    
    <title>
        Voice2Email Solutions -
        <?php echo $title_for_layout; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- @todo: fill with your company info or remove -->
    <meta name="description" content="">
    <meta name="author" content="alniejacobe.com"> 
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('font-awesome');
        echo $this->Html->css('font-awesome-social');
        echo $this->Html->css('voicesolution-style.min');


        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>
</head>
    <body class="page page-index">
        <div id="wrap">
             <!-- Header -->
            <?php echo $this->element('User/header'); ?>
            <!-- Header /-->
            <!-- Content -->
            <div id="content">
                <div class="container">
                    <section class="section account-info">
                        <div class="row-fluid">
                            <div class="col-lg-4">
                                &nbsp;
                            </div>
                             <div class="col-lg-4">

                            <h1 style="color:#000;">
                                <!--i class="icon-user"></i> Member's-->
                                <span  style="color:#000;">
                                    Login
                                </span>
                            </h1>
                            <div class="well users form">
                                <!--?php echo $this->Session->flash('auth'); ?-->
                               <fieldset>                                
                                <?php

                                    echo $this->Form->create('User', array(
                                        'action' => 'login',
                                        'inputDefaults'=>array(
                                            'div'=>array('class'=>'form-group'),
                                            'class'=>'form-control placeholder'
                                        ),
                                        'id' => 'LoginForm'));
                                    echo $this->Form->input('username', array(
                                        'label' => __d('username', 'Username')));
                                    echo $this->Form->input('password',  array(
                                        'label' => __d('users', 'Password')));
                                    ?>
                                    <div class="checkbox">
                                        <label>
                                            <?php echo $this->Form->input('remember_me', array('type' => 'checkbox', 'label' =>false,'div'=>false,'class'=>false));?>
                                            Remember me
                                        </label>
                                    </div>
                                    <button class="btn btn-primary col-lg-12 btn-large" type="submit">Sign In<i class="icon-signin"></i></button>
                                    <?php

                                    //echo $this->Form->hidden('User.return_to', array(
                                    //    'value' => $return_to));                                    
                                    echo $this->Form->end(null);
                                ?>
                                <?php echo $this->Html->link(__d('users', 'Forgot your password?'), array('action' => 'reset_password'),array('class'=>'btn btn-link'));?>                               
                            </div>
                            
                            <div class="col-lg-4">&nbsp;</div><!-- spacer -->
                        </div>
                    </section>
                </div>
            </div>
            <div class="push"></div>
            <!-- Content /-->
            <!--?php //echo $this->fetch('content'); ?>
        </div><!-- wrap /-->
        <!-- Footer -->
        <!--?php echo $this->element('User/footer');?-->
        <!-- Footer /-->
         <!--Scripts --> 
         <?php            
            echo $this->Html->script('jquery');
            echo $this->Html->script('bootstrap.min');
            echo $this->Html->script('html5');
            echo $this->Html->script('script');
            echo $this->fetch('script');
        ?>        
    </body>
</html>

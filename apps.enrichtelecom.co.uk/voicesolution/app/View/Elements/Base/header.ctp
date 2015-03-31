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
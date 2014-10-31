<div class="panel panel-info">
    <div class="panel-heading"><h4><i class="icon-file"></i>My Blogs</h4></div>
    <div class="panel-body">
        <?php if (is_array($myBlogs)): ?>
            <ul class="blog-list">
                <?php foreach($myBlogs as $each): ?>

                <li class="media">
                    <a class="pull-left thumbnail" href="#">
                       <img src="http://flickholdr.com/100/100/sunrise" alt="Placeholder image from flickholdr.com" alt="avatar" />
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $this->Html->link(__(ucfirst($each['Blog']['title'])), array('action' => 'view', $each['Blog']['id']), array('class' => '')); ?>  </h4>
                        <p><?php echo $this->Text->excerpt($each['Blog']['content'], 'method', 150, '...'); ?> <small>
                            <?php echo $this->Html->link(__('Read more'), array('action' => 'view', $each['Blog']['id']), array('class' => '')); ?></small></p>
                    </div>
                </li>

               <?php endforeach ?>
            </ul>
             <a href="<?php echo $this->Html->url(array('action' => 'add'));?>" class="btn btn-orange btn-large"><i class="icon-pencil"></i>Create New Blog Post</a>

        <?php else: ?>
            <div class="alert alert-warning ist-warning">
                <p>This DIV will only show if the user does not have a blog. Text urging them to create their own blog.</p>
                <a href="signup.htm" class="btn btn-orange btn-large"><i class="icon-pencil"></i>Create New Blog Post</a>
            </div>
        <?php endif; ?>

        

       
    </div>
</div>

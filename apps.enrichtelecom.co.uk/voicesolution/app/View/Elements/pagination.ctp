<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	
</p>
<?php if($this->Paginator->numbers) { ?>
<div>  
	<ul  class="pagination pagination-right">  
		<?php   
			echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array('disabledTag' => 'span', 'class' => 'disabled', 'tag' => 'li' ) );  
			echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'active', 'currentTag' => 'a' ) );  
			echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled', 'tag' => 'li' ) );  
		?>  
	</ul>  
</div>  
<?php } ?>
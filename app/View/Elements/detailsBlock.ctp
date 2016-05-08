<div class="details-block">
<div class="detail">
	<?php echo $this->Text->autoParagraph($item['details']) ?>
</div>
<a href="<?php echo htmlspecialchars($this->Html->url(array('action' => 'edit', $item['id'])))?>" data-magic-link-frame="content" data-magic-link-history="push"> 
	<i class="material-icons waves-effect waves-circle">edit</i>
</a>
<a class="delete-category"> 
	<i class="material-icons waves-effect waves-circle">delete</i>
</a>
</div>
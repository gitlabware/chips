<div class="almacenes form">
<?php echo $this->Form->create('Almacene'); ?>
	<fieldset>
		<legend><?php echo __('Edit Almacene'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre');
		echo $this->Form->input('sucursal_id');
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Almacene.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Almacene.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Almacenes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sucursals'), array('controller' => 'sucursals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sucursal'), array('controller' => 'sucursals', 'action' => 'add')); ?> </li>
	</ul>
</div>

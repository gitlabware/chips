<div class="almacenes view">
<h2><?php  echo __('Almacene'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($almacene['Almacene']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($almacene['Almacene']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sucursal'); ?></dt>
		<dd>
			<?php echo $this->Html->link($almacene['Sucursal']['id'], array('controller' => 'sucursals', 'action' => 'view', $almacene['Sucursal']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($almacene['Almacene']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($almacene['Almacene']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($almacene['Almacene']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Almacene'), array('action' => 'edit', $almacene['Almacene']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Almacene'), array('action' => 'delete', $almacene['Almacene']['id']), null, __('Are you sure you want to delete # %s?', $almacene['Almacene']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Almacenes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Almacene'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sucursals'), array('controller' => 'sucursals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sucursal'), array('controller' => 'sucursals', 'action' => 'add')); ?> </li>
	</ul>
</div>

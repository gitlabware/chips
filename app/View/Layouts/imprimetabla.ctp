<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)crt
 */
?>
<?php echo $this->Html->css(array('imprimetabla'))?>
<!--permite mantener el estilo al imprimir-->
<?php echo $this->Html->css(array('jquery-1.6.min'), 'stylesheet', array('media' => 'print')); ?>

<?php echo $this->Html->script(array('jquery-1.6.min','print'))?>
<?php echo $this->fetch('content'); ?>

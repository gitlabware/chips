<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</a>
			<a class="brand" href="#">SoleMio (Sistema de Ventas)</a>
			<div class="nav-collapse collapse">
				<p class="navbar-text pull-right">
					Ingreso como:
					<a href="#" class="navbar-link">Username</a>
				</p>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
<style>
    #formulariomoso{
        height: 50px;
        /*width: 355px;*/
        font-size: 24px;
    }
</style>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span4 offset4">
			<h2>
                <?php echo $this->Html->image('mosoLogin.png'); ?>
				INGRESE SU CODIGO
			</h2>
            <?php echo $this->Form->create('User', array('action'=>'verificamoso')) ?>
			<div class="hero-unit">
				<form>
					<fieldset>											
                        <?php echo $this->Form->password('password', array('placeholder'=>'Ingrese su Codigo', 'id'=>'formulariomoso')); ?>
                        <hr />														
						<button class="btn btn-large btn-block btn-primary" type="submit">Ingresar</button>
					</fieldset>
				</form>
			</div>
            </form>
			<!--/span-->
		</div>
		<!--/row-->
		
	</div>
	<!--/.fluid-container-->
    
    <div class="row-fluid">
		<div class="span12">
            <hr />
		<footer>
			<p>
				Desarrollado por C&#38;A Consultores.
			</p>
		</footer>    
        </div>
    </div>
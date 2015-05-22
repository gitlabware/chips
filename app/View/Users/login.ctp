<div id="container">

    <hgroup id="login-title" class="large-margin-bottom">
        <!--<h1 class="login-title-image"></h1>-->
        <h5>&copy; Celulares</h5>
    </hgroup>

    <div id="form-wrapper">

        <div id="form-block" class="scratch-metal">
            <div id="form-viewport">

<!--                <form method="post" action="" id="form-login" class="input-wrapper green-gradient glossy" title="Login">-->
                <?php echo $this->Form->create('User', array('action' => 'login', 'id'=>'form-login', 'class'=>'input-wrapper green-gradient glossy')); ?>
                    <ul class="inputs black-input large">
                        <!-- The autocomplete="off" attributes is the only way to prevent webkit browsers from filling the inputs with yellow -->
                        <li><span class="icon-user mid-margin-left"></span>
                            <input type="text" name="data[User][username]" id="login" value="" class="input-unstyled" placeholder="Usuario" autocomplete="off"></li>
                        <li><span class="icon-lock mid-margin-left"></span>
                            <input type="password" name="data[User][password]" id="pass" value="" class="input-unstyled" placeholder="Password" autocomplete="off"></li>
                    </ul>

                    <p class="button-height">
                        <button type="submit" class="button glossy float-left" id="login">Ingresar</button>
                    <p>&nbsp;</p>
<!--                        <input type="checkbox" name="remind" id="remind" value="1" checked="checked" class="switch tiny mid-margin-left with-tooltip" title="Enable auto-login">
                        <label for="remind">Remind me</label>-->
                    </p>
                </form>

            </div>
        </div>

    </div>

</div>

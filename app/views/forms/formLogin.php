<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<form name="loginform" method="POST" action="<?php echo COMPLETE_WEB_PATH_ADMIN."login"?>" enctype="application/x-www-form-urlencoded">  
<input type="hidden" name="temp_random" value="{{random}}">
<div class="form-outline mb-4">
    <input type="text" id="typeEmail" name="email" autofocus class="form-control form-control-lg"  />
    <label class="form-label" for="typeEmail">Email</label>
</div>

<div class="form-outline mb-4">
    <input type="password" id="typePassword" name="pass" class="form-control form-control-lg"  />
    <label class="form-label" for="typePassword">Password</label>
</div>
<div class="row mb-4">
    <div class="col-md-6 d-flex justify-content-center">
        <!-- Checkbox -->
        <div class="form-check mb-3 mb-md-0">
        <input class="form-check-input" name="loginCheck" type="checkbox" value="checked" id="loginCheck">
        <label class="form-check-label" for="loginCheck"> Recordar contraseña </label>
        </div>
    </div>

    <div class="col-md-6 d-flex justify-content-center">
        <!-- Simple link -->
        <a class="text-white" href="#!">He olvidado mi contraseña</a>
    </div>
    </div>

<button class="btn btn-outline-light btn-lg px-5" noprefetch name="submit" type="submit" value="submit">Login</button>
</form>
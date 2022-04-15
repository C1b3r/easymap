<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-right body__text">Editar Usuario</h4>
</div>
<form name="usersform" method="POST" action="<?php echo COMPLETE_WEB_PATH_ADMIN."login"?>" enctype="application/x-www-form-urlencoded">  
<input type="hidden" name="temp_random" value="{{random}}">
<div class="row mt-2">
    <div class="col-md-6"><label class="labels body__text">Nombre</label><input type="text" name="name" class="form-control" placeholder="Name" value=""></div>
    <div class="col-md-6"><label class="labels body__text">Email</label><input type="email" name="email" class="form-control" value="" placeholder="email"></div>
</div>

<div class="row mt-3 mb-3">
    <div class="col-md-12 mb-2">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
        <label class="form-check-label body__text" for="flexCheckChecked">
            Activo
        </label>
    </div>
    <div class="col-md-12 mb-2">
       <button class="btn btn-secondary" onclick="document.getElementById('password').classList.toggle('d-none')" type="button">Cambiar contraseña</button>
    </div>

    <div id="password" class="d-none">
    <div class="col-md-12 mb-2">
     <label class="labels">Contraseña</label><input type="password"  name="pass" class="form-control" placeholder="Contraseña" value="">
     <label class="labels">Confirmar contraseña</label><input type="password"  name="cpass" class="form-control" placeholder="Confirmar contraseña" value="">
    </div>
    </div>
</div>

<button class="btn btn-outline-primary btn-lg px-5" name="submit" type="submit" value="submit">Editar</button>
</form>
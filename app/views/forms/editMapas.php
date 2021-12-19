<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-right">Editar mapa</h4>
</div>
<form name="mapasform" method="POST" action="<?php echo COMPLETE_WEB_PATH_ADMIN."login"?>" enctype="application/x-www-form-urlencoded">  
<input type="hidden" name="temp_random" value="{{random}}">
<div class="row mt-2">
    <div class="col-md-12"><label class="labels">Titulo</label><input type="text" class="form-control" placeholder="Titulo" value=""></div>
</div>

<div class="row mt-3 mb-4">
    <div class="col-md-12">
        <textarea class="form-control" rows="3" placeholder="Descripción"></textarea>
    </div>
</div>

<button class="btn btn-outline-primary btn-lg px-5" name="submit" type="submit" value="submit">Editar</button>
</form>
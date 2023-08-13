<div class="col-md-12">
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
    <div class="row mt-3 mb-4">
        <div class="col-md-12">
            <label class="labels">Latitud</label>
            <input type="text" name="latitud" placeholder="Latitud">
            <label class="labels">Longitud</label>
            <input type="text" name="longitud" placeholder="Longitud">
        </div>
    </div>
<iframe style="width:100%; height:300px;" src="https://developers-dot-devsite-v2-prod.appspot.com/maps/documentation/utils/geocoder/embed"></iframe>
    <button class="btn btn-outline-primary btn-lg px-5" name="submit" type="submit" value="submit">Editar</button>
    </form>  
</div>
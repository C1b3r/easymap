<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
   <!-- active  -->
  <?php
  foreach($this->secciones as $section => $nombreSeccion):?>
    <li class="nav-item" role="presentation">
      <a class="nav-link nav-link-tab" id="<?php echo $section; ?>-tab" href="#<?php echo $section; ?>"  type="button" role="tab" aria-controls="<?php echo $section; ?>" aria-selected="true"><?php echo $nombreSeccion; ?></a>
    </li>
   
  <?php endforeach;?>
</ul>
<section class="col-md-12">
    <div class="tab-content" id="myTabContent">
    <?php
       foreach($this->secciones as $section => $nombreSeccion):?>
        <div class="tab-pane fade p-3" id="<?php echo $section; ?>" role="tabpanel" aria-labelledby="<?php echo $section; ?>-tab"></div>
      <?php endforeach;?>  
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalDetails" tabindex="-1" aria-labelledby="modalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDetails">Edición</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" form='formEdit' class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script>//alert(window.location.hash.substring(1)); //substring para quitar el #</script>
<?php $this->putJSorStyle('js/editseccionesmapas.js','js');?>
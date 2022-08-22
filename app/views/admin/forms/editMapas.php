<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-right body__text">Editar mapa</h4>
</div>
<?php if(isset($this->secciones)): ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
   <!-- active  -->
  <?php $first = reset($this->secciones);
  foreach($this->secciones as $section => $nombreSeccion):?>
    <li class="nav-item" role="presentation">
      <a class="nav-link" onclick="cargarContenido('<?php echo $section; ?>')" <?php echo ($nombreSeccion == $first)? "primerTab ": '' ;?>id="<?php echo $section; ?>-tab" href="#<?php echo $section; ?>" type="button" role="tab" aria-controls="<?php echo $section; ?>" aria-selected="true"><?php echo $nombreSeccion; ?></a>
    </li>
   
  <?php endforeach;?>
</ul>
<section class="col-md-12">
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade" id="resultTab" role="tabpanel" aria-labelledby="b">..90090909.</div>
    </div>
</section>
<script>//alert(window.location.hash.substring(1)); //substring para quitar el #</script>
<?php $this->putJSorStyle('js/editseccionesmapas.js','js');?>
<?php endif; ?>


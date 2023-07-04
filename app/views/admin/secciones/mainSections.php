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
<script>//alert(window.location.hash.substring(1)); //substring para quitar el #</script>
<?php $this->putJSorStyle('js/editseccionesmapas.js','js');?>
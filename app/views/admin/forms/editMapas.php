<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<?php ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-right body__text">Editar mapa</h4>
    <input type="hidden" id="cuId" name="cuId" value="<?php echo $this->currentId ?>">
</div>
<?php echo $this->renderSections($this->secciones) ?: "Error"; ?>



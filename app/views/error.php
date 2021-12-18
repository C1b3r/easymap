<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
    <div class="container vh-100">
        <div class="flex-row  d-flex align-items-center justify-content-center h-100">
            <div class="col-md-12 text-center">
                <div class="error-title">
                    <h1><?php echo $this->other_title; ?></h1>
                    <h2></h2>
                    <div class="mb-4 error-details">
                    <?php echo $this->message; ?>
                    </div>
                    
                    <?php if (isset($this->error_image)): ?>
                        <div class="mb-4 error-image">  
                            <img alt="imagen error" title="imagen de error" src="<?php echo PUBLIC_WEB_PATH."images/".$this->error_image;?>">
                        </div>
                    <?php endif;?>

                    <div class="mb-4 error-actions">
                        <a href="<?php echo COMPLETE_WEB_PATH ;?>" class="btn btn-secondary btn-lg"><span class="bi bi-house-door"></span> Ir a la home</a>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
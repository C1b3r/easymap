<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<h1 class="h2 body__text">Todos los mapas</h1>

<div class="row">
    <div class="col-12 col-xl-12 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Mapas actuales  
              <a href="<?php echo COMPLETE_WEB_PATH_ADMIN; ?>crearmapa" class="btn btn-block btn-light float-end">Crear nuevo</a>
            </h5> 
           
            <div class="card-body">
              <?php  if($this->results->isNotEmpty()): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha de creación</th>   
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($this->results as $value):?>
                             <tr>
                              <th scope="row"><?php echo $value->title;?></th>
                              <th scope="row"><?php echo $value->description;?></th>
                              <td><p class="card-text text-success"><?php echo $value->date_add;?></p></td>
                              <td><a class="btn btn-secondary" href="<?php echo COMPLETE_WEB_PATH_ADMIN.strtolower($this->current_page).'/edit/'.$value->id_map;?>">Editar</a></td>
                             </tr>
                              
                        <?php endforeach; ?>
                        </tbody>
                      </table>
                </div>
                <?php else: ?>
                  <div class="text-center">
                   <p>No hay mapas actualmente ¡Crea uno!</p> 
                  </div>
                <?php endif;?>
            </div>
        </div>
    </div>

</div>

<h1 class="h2 body__text">Todos los usuarios</h1>

<div class="row">
    <div class="col-12 col-xl-12 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">
              <a href="<?php echo COMPLETE_WEB_PATH_ADMIN; ?>crearusuario" class="btn btn-block btn-light float-end">Crear nuevo</a>
            </h5> 
           
            <div class="card-body">
              <?php  if(!empty($this->results)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Email</th>
                            <th scope="col">Fecha de alta</th> 
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($this->results->data as $value):?>
                             <tr>
                              <th scope="row"><?php echo $value['email'];?></th>
                              <th scope="row"><?php echo $value['date_add'];?></th>
                             </tr>
                              
                        <?php endforeach; ?>
                        </tbody>
                      </table>
                </div>
                <?php else: ?>
                  <div class="text-center">
                   <p>No hay usuarios disponibles actualmente ¡Crea uno!</p> 
                  </div>
                <?php endif;?>
            </div>
        </div>
    </div>

</div>

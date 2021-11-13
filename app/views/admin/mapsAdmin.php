<h1 class="h2 body__text">Todos los mapas</h1>

<div class="row">
    <div class="col-12 col-xl-12 mb-4 mb-lg-0">
        <div class="card">
            <h5 class="card-header">Mapas actuales  
              <a href="<?php echo COMPLETE_WEB_PATH_ADMIN; ?>crearmapa" class="btn btn-block btn-light float-end">Crear nuevo</a>
            </h5> 
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php  
                          if(!empty($this->maps)){
                            foreach ($this->maps as $value) {
                              echo '<tr>
                              <th scope="row">'.$value['title'].'</th>
                              <td><p class="card-text text-success">'.$value['date_add'].'</p></td>
                              </tr>
                              ';
                            } 
                          }else{
                            echo '
                            <tr>
                              <td>No hay mapas actualmente </td>
                              <td>¡Crea uno!</td>
                            </tr>
                            ';
                          }
                         ?>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>

</div>

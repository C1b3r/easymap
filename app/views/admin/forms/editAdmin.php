<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<div class="row">
  <section class="col-12 col-xl-12 mb-4 mt-3 mb-lg-0">
    <!-- <div class="container py-5 h-100"> -->
      <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right body__text">Editar Usuario</h4>
      </div>
      <form name="usersform" method="POST" action="<?php echo Helper::$urlGeneration->route('edit_user_post', ['id' =>$this->results['id_user']]); ?>" enctype="application/x-www-form-urlencoded">  
       <input type="hidden" name="token" value="<?php echo $_SESSION['tokencsrf'] ?? '' ?>">
       <input type="hidden" name="id" value="<?php echo $this->results['id_user'] ?>">

        <div class="row mt-2">
            <div class="col-md-6"><label class="labels body__text">Nombre</label><input type="text" name="name" class="form-control" required placeholder="Name" value="<?php echo $this->results['name']; ?>"></div>
            <div class="col-md-6"><label class="labels body__text">Email</label><input type="email" name="email" class="form-control" required value="<?php echo $this->results['email']; ?>"" placeholder="email"></div>
        </div>

          <div class="row mt-3 mb-3">
              <div class="col-md-12 mb-2">
                  <input class="form-check-input" type="checkbox" value ="1" name="active" id="flexCheckChecked" <?php echo ($this->results['active']) ? 'checked': ''; ?> >
                  <label class="form-check-label body__text" for="flexCheckChecked">
                      Activo
                  </label>
              </div>
              <div class="col-md-12 mb-2">
                <button class="btn btn-secondary" onclick="document.getElementById('password').classList.toggle('d-none')" type="button">Cambiar contraseña</button>
              </div>

              <div id="password" class="d-none">
              <div class="col-md-12 mb-2">
              <label class="labels">Contraseña actual</label><input type="password"  name="old_pass" class="form-control" placeholder="Contraseña" value="">
              <label class="labels">Nueva contraseña</label><input type="password"  name="new_pass" class="form-control" placeholder="Contraseña" value="">
              <label class="labels">Confirmar contraseña</label><input type="password"  name="confirm_pass" class="form-control" placeholder="Confirmar contraseña" value="">
              </div>
              </div>
          </div>

        <button class="btn btn-outline-primary btn-lg px-5" name="submit" type="submit" value="submit">Editar</button>
      </form>
    <!-- </div> -->
  </section>
</div>
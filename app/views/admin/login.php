<section class="vh-100 gradient-custom">
    
    <?php if(isset($this->message) && !empty($this->message)):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $this->message; ?>
    </div>
        <?php endif;?>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card body-secondary text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase text-white">Login</h2>
              <p class="text-white mb-5">Please enter your login and password!</p>
             <?php echo $this->formLogin; ?>
            
                <div class="form-outline mb-4">
                    <input type="text" id="typeEmailX" name="email" autofocus class="form-control form-control-lg" />
                    <label class="form-label" for="typeEmailX">Email</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="password" id="typePasswordX" name="pass" class="form-control form-control-lg" />
                    <label class="form-label" for="typePasswordX">Password</label>
                </div>

                <p class="small mb-5 pb-lg-2"><a class="text-white" href="#!">He olvidado mi contraseña</a></p>

                <button class="btn btn-outline-light btn-lg px-5" name="submit" type="submit">Login</button>
              </form>
              <div class="d-flex justify-content-center text-center mt-4 pt-1">
                <a href="https://github.com/C1b3r" class="text-white"><i class="bi bi-github"></i></a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

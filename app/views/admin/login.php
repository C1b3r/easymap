<section class="vh-100 gradient-custom">
    
    <?php if(isset($this->message) || !empty($this->message))
    {
        ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $this->message; ?>
    </div>
        <?php
    } ?>
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase body__text">Login</h2>
              <p class="body__text mb-5">Please enter your login and password!</p>
            <form method="POST" action="<?php echo COMPLETE_WEB_PATH."admin/login";?>" >
            
                <div class="form-outline form-white mb-4">
                    <input type="text" id="typeEmailX" name="email" class="form-control form-control-lg" />
                    <label class="form-label" for="typeEmailX">Email</label>
                </div>

                <div class="form-outline form-white mb-4">
                    <input type="password" id="typePasswordX" name="pass" class="form-control form-control-lg" />
                    <label class="form-label" for="typePasswordX">Password</label>
                </div>

                <p class="small mb-5 pb-lg-2"><a class="text-white" href="#!">Forgot password?</a></p>

                <button class="btn btn-outline-light btn-lg px-5" name="submit" type="submit">Login</button>
              </form>
              <div class="d-flex justify-content-center text-center mt-4 pt-1">
                <a href="https://github.com/C1b3r" class="text-white"><i class="bi bi-github"></i></a>
              </div>

            </div>

            <div>
              <p class="mb-0">Don't have an account? <a href="#!" class="text-white fw-bold">Sign Up</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<?php if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])):?>
    <?php if(isset($this->pagination,$this->results) && $this->results->isNotEmpty() || $this->pagination):?>
        <div class="mt-3 d-flex justify-content-center">
      <?php //echo $this->createPaginationLink($this->results,$this->current_page); 
      echo $this->createPaginationLinkORM([
                   'limit' => $this->results->perPage(),
                  'total' => $this->results->total(),
                  'page' => $this->results->currentPage()
                  ],$this->current_page); 
      ?>      
        </div>
    
    <?php endif;?>

            <footer class="pt-5 d-flex justify-content-between">
             <span class="body__text">Creado con cariño por <a href="https://github.com/C1b3r/">C1b3r</a></span>
                <ul class="nav m-0">
                    <li class="nav-item">
                        <a class="nav-link text__link" aria-current="page" href="#">Politica de privacidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text__link" href="#">Terminos y condiciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text__link" href="#">Contacto</a>
                    </li>
                    </ul>
            </footer>
       </main>
    </div>
</div>
<?php endif;?>
<script defer src="<?php echo PUBLIC_WEB_PATH.'js/scripts-ref.js';?>"></script>
<script src="<?php echo PUBLIC_WEB_PATH.'js/nightmode.js';?>"></script>
<script defer src="<?php echo PUBLIC_WEB_PATH.'js/custom.js';?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/quicklink/2.2.0/quicklink.umd.js"></script>
<script>
window.addEventListener('load', () => {
  quicklink.listen(
    {
      origins:false,
      ignores:[(uri, elem) => elem.hasAttribute('noprefetch')] 
    }
  );
});
</script>
</body>
</html>

<?php if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user']))
    {
    ?>
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
<?php 
    } 
?>
<script defer src="<?php echo PUBLIC_WEB_PATH.'bootstrap/js/popper.min.js';?>"></script>
<script defer src="<?php echo PUBLIC_WEB_PATH.'bootstrap/js/bootstrap.min.js';?>"></script>
<script defer src="<?php echo PUBLIC_WEB_PATH.'js/custom.js';?>"></script>
</body>
</html>

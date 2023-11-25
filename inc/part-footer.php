<footer class="site-footer container p-0 text-center" id="colophon">
    <div class="card m-md-0 mx-2 p-3 rounded-0 border-light border-0 shadow">
        <div class="velocity-footer bg-gray">
            <div class="row footer-widget text-start mx-auto px-2 pt-4">
                <?php for ($x = 1; $x <= 4; $x++) {
                    if (is_active_sidebar('footer-widget-' . $x)) : ?>
                        <div class="col-md">
                            <?php dynamic_sidebar('footer-widget-' . $x); ?>
                        </div>
                    <?php endif; ?>
                <?php } ?>
            </div>
        </div>

        <div class="site-info bg-colortheme text-white p-2">
            <small>
                Copyright © <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?>. All Rights Reserved.
            </small>
            <br>
            <small class="opacity-25">
                Design by <a class="text-white" href="https://velocitydeveloper.com" target="_blank" rel="noopener noreferrer"> Velocity Developer </a>
            </small>
        </div>
    </div>
    <!-- .site-info -->
</footer>
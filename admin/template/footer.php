                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                            <p class="copyright text-center">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                            </p>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    
</body>
<!--   Core JS Files   -->
<script src="<?php echo $config['admin_assets'] ?>js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo $config['admin_assets'] ?>js/core/popper.min.js" type="text/javascript"></script>
<script src="<?php echo $config['admin_assets'] ?>js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?php echo $config['admin_assets'] ?>js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="<?php echo $config['admin_assets'] ?>js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo $config['admin_assets'] ?>js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="<?php echo $config['admin_assets'] ?>js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo $config['admin_assets'] ?>js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.showNotification();

    });
</script>

</html>
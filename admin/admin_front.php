<?php 
    session_start();
?>
<!DOCTYPE html>
<html>

    <?php
        include '../inc/html_head.php';
        include 'inc/apiurl.php';
    ?>
    
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="/img/logo.png" /></a>
            </div>
        </header>
        <div id="content_wrapper">
            <div class="container">
                <div class="row">
                    <div class="span5 suffix1">
                        <div class="front_messagebox">

                            <?php include "../inc/live_table.php" ?>

                        </div>
                    </div>
                    
                    <div class="span5 offset2">

                            <?php include "../inc/ongoing_issues.php"; ?>

                    </div>
                </div>

                <hr />

                <div id="dimmer">
                
                    <div class="row">
                        <div class="span12">

                            <?php include "../inc/uptime_table.php"; ?>

                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="span12">

                            <?php include "../inc/message_history.php"; ?>

                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
       <script type="text/javascript">
            $(document).ready(function(){

                /*$(window).bind('scroll', function() {
                    if($(window).scrollTop() > 1, function()) {
                        $("#dimmer").fadeTo("normal", 0);
                    });
                });*/

                function checkScrollPosition() {
                    var top = $(window).scrollTop();
                    if (top > 1) {
                        $("#dimmer").fadeOut("fast");
                    }
                }

                $(window).scroll(checkScrollPosition());
                checkScrollPosition();

            });
        </script>

        <?php include 'inc/admin_footer.php'; ?>
       
    </body>
</html>
<!DOCTYPE html>
<html>

<?php
include 'inc/html_head.php';
include 'admin/inc/apiurl.php';
?>

<body>

<!--HEADER-->

<header id="header">
    <div id="header-content">
        <a href="http://apto.vlab.iu.hio.no/customer_front.php"><img id="logo" src="/img/logo.png" /></a>
    </div>
</header>
<div id="content_wrapper">
    <div class="container">
        <div class="row">
            <div class="span5 suffix1">
                <div class="front_messagebox">

                    <?php include "inc/live_table.php" ?>

                </div>
            </div>

            <div class="span5 offset2">

                <?php include "inc/ongoing_issues.php"; ?>

            </div>
        </div>

        <hr />

        <div>

            <div class="row">
                <div class="span12">

                    <?php include "inc/uptime_table.php"; ?>

                </div>
            </div>

            <div class="row">
                <div class="span12">

                    <?php include "inc/message_history.php"; ?>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'inc/cust_footer.php'; ?>

</body>
</html>
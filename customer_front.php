<!DOCTYPE html>
<html>

    <?php
        include 'inc/html_head.php';
        include 'admin/inc/apiurl.php';
        include "inc/uptime.php";
        include "inc/currentIncidents.php";

        $uptimeTable = new Uptime();
        $uptime = $uptimeTable->getUptimeAsArray();

        $current = new CurrentIncidents();
        $incidentsArray = $current->getIncidentsAsArray();
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

                        <?php $current->generateIncidentList($incidentsArray) ?>

                    </div>
                </div>

                <hr />

                <div id="dimmer">
            <div class="row">
                <div class="span12">
                    <h3> Status History - last 7 days</h3>
                    <table id="history">
                        <tr>
                            <td id="uptime-title">
                                Service:
                            </td>
                                <?php $uptimeTable->generateUptimeTable($uptime) ?>
                        </tr>
                    </table>
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

        <script type="text/javascript">
            $(document).ready(function(){

                function checkScrollPosition() {
                    var top = $(window).scrollTop();
                    if (top > 1) {
                        $("#dimmer").fadeTo("normal",1);
                    }
                }
                $(window).scroll(checkScrollPosition);
                checkScrollPosition();

            });
        </script>

        <?php include 'inc/cust_footer.php'; ?>

    </body>
</html>
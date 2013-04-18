<!DOCTYPE html>
<html>

    <?php
        include '../inc/html_head.php';
        include 'inc/apiurl.php';
        include "inc/uptime.php";
        include "inc/currentIncidents.php";
        include "inc/messageHistory.php";

        $uptimeTable = new Uptime();
        $uptime = $uptimeTable->getUptimeAsArray();

        $current = new CurrentIncidents();
        $incidentsArray = $current->getIncidentsAsArray();

        $message = new MessageHistory();
        $messages = $message->getMessagesAsArray();
    ?>

                    <div class="span5 suffix1">
                        <div class="front_messagebox">

                            <?php include "../inc/live_table.php" ?>

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
                        <hr/>
                            <?php $message->generateMessageList($messages); ?>

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

        <?php include 'inc/admin_footer.php'; ?>
       
    </body>
</html>
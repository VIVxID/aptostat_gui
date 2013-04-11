<?php 
    session_start();
?>
<!DOCTYPE html>
<html>

    <?php
        include 'inc/html_head.inc';
    ?>
    
    <body>
        
        <!--HEADER-->
        
        <header id="header">
            <div id="header-content">
                <a href="http://apto.vlab.iu.hio.no/admin_front.php"><img id="logo" src="img/logo.png" /></a>
            </div>
        </header>
        
        <div class="container">
            <div class="row">
                <div class="span5 suffix1">
                    <div class="front_messagebox">

                        <?php include "inc/live_table.php" ?>
                        
                    </div>
                </div>
                
                <div class="span6 offset1">
                    <div id="current_box" class="error">
                        <table border="0" class="current_box_table">
                            <tr>
                                <td class="table-left">Ongoing issues</td>
                                <td class="table-right">[Unresolved]</td>
                            </tr>
                            <tr>
                                <td class="table-left">Services:</td>
                                <td class="table-right">
                                    DrPublish API<br/>
                                    DrPublish Backoffice
                                </td>
                            </tr>
                            <tr>
                                <td class="table-left">Status:</td>
                                <td class="table-right">Critical</td>
                            </tr>
                            <tr>
                                <td class="table-left">Date:</td>
                                <td class="table-right">07/03-2013 11:50</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    We're in a bit of a snafu here and DrPublish Backoffice is down at the moment. DrPublish API may also be unstable.<br/>
                                    We are working on a fix.
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <hr />
            
            <div class="row">
                <div class="span12">
                    <h3> Status History - last 7 days</h3>

                    <?php include "inc/uptime_table.php"; ?>

                </div>
            </div>
            
            <div class="row">
                <div class="span12">
                    <div id="current_box" class="error">
                    
                        <h3>Issue history - Last 3 days</h3>
                        <table border="0" class="current_box_table">
                            <tr>
                                <td class="table-left">Ongoing issues</td>
                                <td class="table-right">[Unresolved]</td>
                            </tr>
                            <tr>
                                <td class="table-left">Services:</td>
                                <td class="table-right">
                                    DrPublish API<br/>
                                    DrPublish Backoffice
                                </td>
                            </tr>
                            <tr>
                                <td class="table-left">Status:</td>
                                <td class="table-right">Critical</td>
                            </tr>
                            <tr>
                                <td class="table-left">Date:</td>
                                <td class="table-right">07/03-2013 11:50</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    We're in a bit of a snafu here and DrPublish Backoffice is down at the moment. DrPublish API may also be unstable.<br/>
                                    We are working on a fix.
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        
        </div>
        
        <?php include 'inc/admin_footer.inc'; ?>
       
    </body>
</html>
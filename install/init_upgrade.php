<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.37
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 *  Lizenz: http://login.streamerspanel.de/user/terms
 */
$site_title = 'S:P - Upgrade';
include_once './views/header.phtml';
include_once './install/upgrade/class_upgrade.php';
$ALL_VERSIONS_ORG = installer::$versions;
$ALL_VERSIONS = $ALL_VERSIONS_ORG;
$Last_Version = array_pop($ALL_VERSIONS_ORG);
$upgrad= new class_upgrade($app);
?>
<body>

<div id="header">

    <div class="container">

        <h1><a href="./index.php"><?= _('S:P Upgrade') ?></a></h1>

        <div id="info">

            <a href="javascript:;" id="info-trigger">
                <i class="icon-cog"></i>
            </a>

            <div id="info-menu">

                <div class="info-details">

                    <h4><?= _('S:P Upgrade') ?></h4>

                    <p>
                        <?= installer::$sp_version; ?>
                    </p>

                </div> <!-- /.info-details -->



            </div> <!-- /#info-menu -->

        </div> <!-- /#info -->

    </div> <!-- /.container -->

</div> <!-- /#header -->

<div id="content">

<div class="container">

<div class="row">

<div class="span12">

<div class="widget">

<div class="widget-header">
    <h3>
        <i class="icon-magic"></i>
        <?= _('Upgrade-Wizard') ?>
    </h3>
</div> <!-- /widget-header -->

<div class="widget-content">



<form action="#" method="POST" class="form-horizontal">

<div id="wizard" class="swMain">


<div id="step-1">

    <h3><?= _('S:P Upgrade')?></h3>


    <br />



    <form action="index.php" method="post">
        <button class="btn btn-info" name="DOUPGNOW" ><?= _('Upgrade - Start') ?></button>
    </form>
    <?php
    if(!isset($_SESSION['step_merker'])){
    $returner =$upgrad->getAllUpgradeVersionsToDo($ALL_VERSIONS, $Last_Version);
   # print_r($returner);
    $_SESSION['step_merker'] = '';
    foreach($returner['All_Steps'] as $val => $key){
        $_SESSION['step_merker'] += $key;
    }
    }

    if(isset($_POST['DOUPGNOW'])){

       $_SESSION['ograde'] = true;
       $upgrad->doUpgrade($ALL_VERSIONS, $Last_Version);
    ?>
    <!-- Progress bar holder -->
    <div id="progress" style="width:500px;border:1px solid #ccc;"></div>
    <!-- Progress information -->
    <div id="information" style="width"></div>
    <?php
        # Getall Steps


        $upgrad->doUpgrade($ALL_VERSIONS, $Last_Version);


            // Total processes
    $total = $_SESSION['step_merker'];
    // Loop through process
    for($i=1; $i<=$total; $i++){
        // Calculate the percentation
        $percent = intval($i/$total * 100)."%";
        // Javascript for updating the progress bar and information
        echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
    </script>';
// This is for the buffer achieve the minimum size in order to flush data
        echo str_repeat(' ',1024*64);
// Send output to browser immediately
        flush();

// Sleep one second so we can see the delay
        sleep(1);
    }
           // Tell user that the process is completed
    echo '<script language="javascript">document.getElementById("information").innerHTML="

    '._('Upgrade beendet! Bitte den "install" - Ordner löschen!').'




    "</script>';
        session_unset();
        session_destroy();
    }
    ?>


    <div class="row-fluid">

        <div class="span6">


        </div> <!-- /span6 -->

        <div class="span5 offset1">

            <div class="well">
               <p><?= _('Upgrade Tool zur Aktuallisierung der Datenbank') ?></p>
            </div>

        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->

</div> <!-- /step -->





</div> <!-- /wizard -->

</form>


</div> <!-- /widget-content -->

</div> <!-- /widget -->

</div> <!-- /.span12 -->



</div> <!-- /row -->




</div> <!-- /.container -->

</div> <!-- /#content -->


<?php

include_once './views/footer.phtml';
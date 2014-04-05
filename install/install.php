<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.21
 *
 *  Kundennummer:   @KDNUM@
 *  Lizenznummer:   @RECHNR@
 * Lizenz: http://login.streamerspanel.de/user/terms
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= _('S:P Installation') ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Styles -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../css/bootstrap-overrides.css" rel="stylesheet">

    <link href="../css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href="../js/plugins/smartwizard/smart_wizard.modified.css" rel="stylesheet">

    <link href="../css/slate.css" rel="stylesheet">
    <link href="../css/slate-responsive.css" rel="stylesheet">


    <!-- Javascript -->
    <script src="../js/jquery-1.7.2.min.js"></script>
    <script src="../js/jquery-ui-1.8.21.custom.min.js"></script>
    <script src="../js/jquery.ui.touch-punch.min.js"></script>
    <script src="../js/bootstrap.js"></script>

    <script src="../js/plugins/smartwizard/jquery.smartWizard-2.0.modified.js"></script>

    <script src="../js/Slate.js"></script>

    <script src="../js/demos/demo.wizard.js"></script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


</head>

<body>


<div id="header">

    <div class="container">

        <h1><a href="./"><?= _('S:P Installation') ?></a></h1>

        <div id="info">

            <a href="javascript:;" id="info-trigger">
                <i class="icon-cog"></i>
            </a>

            <div id="info-menu">

                <div class="info-details">

                    <h4><?= _('S:P Installation') ?></h4>

                </div> <!-- /.info-details -->

            </div> <!-- /#info-menu -->

        </div> <!-- /#info -->

    </div> <!-- /.container -->

</div> <!-- /#header -->


<div id="nav">

    <div class="container">


    </div> <!-- /.container -->

</div> <!-- /#nav -->


<div id="content">

<div class="container">

<div class="row">

<div class="span12">

<div class="widget">

<div class="widget-header">
    <h3>
        <i class="icon-magic"></i>
        Wizard
    </h3>
</div> <!-- /widget-header -->

<div class="widget-content">



<form action="#" method="POST" class="form-horizontal">

<div id="wizard" class="swMain">

<ul class="wizard-steps">
    <li>
        <a href="#step-1" class="">
            <div class="wizard-step-number">1</div>
            <div class="wizard-step-label"><?= _('MySql Daten') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-2" class="">
            <div class="wizard-step-number">2</div>
            <div class="wizard-step-label"><?= _('SSH Daten') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-3" class="">
            <div class="wizard-step-number">3</div>
            <div class="wizard-step-label"><?= _('Benutzer Daten') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-4" class="">
            <div class="wizard-step-number">4</div>
            <div class="wizard-step-label"><?= _('Konfiguration') ?></div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
</ul>

<div id="step-1">

    <h3><?= _('MySql Konfiguration') ?></h3>


    <br />


    <div class="row-fluid">

        <div class="span6">

            <div class="control-group">
                <label class="control-label" for="bizname"><?= _('DB Name') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="bizname" name="dbname">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bizemail"><?= _('DB User') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="bizemail" name="dbuser">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bizaddress1"><?= _('DB Pass') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="bizaddress1" name="dbpass">
                </div>
            </div>

        </div> <!-- /span6 -->

        <div class="span5 offset1">

            <div class="well">
                <p><?= _('Connection to Database') ?></p>
            </div>

        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->

</div> <!-- /step -->



<div id="step-2">

    <h3>Profile Details:</h3>

    <br />


    <div class="row-fluid">

        <div class="span6">



            <div class="control-group">
                <label class="control-label" for="userfirst"><?= _('Server IP') ?></label>
                <div class="controls">
                    <input class="input-medium" id="userfirst" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="userlast"><?= _('ssh user') ?></label>
                <div class="controls">
                    <input class="input-large" id="userlast" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="useremail"><?= _('ssh pass') ?></label>
                <div class="controls">
                    <input class="input-large" id="useremail" >
                </div>
            </div>




        </div> <!-- /span6 -->

        <div class="span5 offset1">


            <div class="well">
<p><?= _('ssh access data') ?></p>

            </div>



        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->


</div> <!-- /step -->

<div id="step-3">

    <h3><?= _('User Data') ?></h3>

    <br />

    <div class="row-fluid">

        <div class="span6">

            <br />

            <div class="control-group">
                <label class="control-label" for="contactemail"><?= _('Admin Login name') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="contactemail">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactname"><?= _('Admin vname') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="contactname">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactphone"><?= _('Admin nname') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="contactphone">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactfax"><?= _('Admin street') ?></label>
                <div class="controls">
                    <input type="text" class="input-medium" id="contactfax">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactemail"><?= _('Admin zip') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="contactemail">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactemail"><?= _('Admin Town') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="contactemail">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactemail"><?= _('Admin phone') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="contactemail">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactemail"><?= _('Admin mail') ?></label>
                <div class="controls">
                    <input type="text" class="input-large" id="contactemail">
                </div>
            </div>

        </div> <!-- /span6 -->

        <div class="span5 offset1">




            <div class="well">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

            </div>

        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->


</div> <!-- /step -->

<div id="step-4">

    <h3><?= _('Complete') ?></h3>

    <br />


    <div class="row-fluid">

        <div class="span6">
<p><?= _('Admin user') ?>: SELECTED LOGIN NAME
    <br>
    <?= _('Admin password') ?>:  eSFEE2423xyx</p>
            <br />


            <div class="alert alert-error">
                <h4 class="alert-heading"><?= _('WARNING') ?></h4>
                <p><?= _('You have to deleted the install DIR') ?></p>
            </div> <!-- ./alert -->



            <button class="btn btn-primary btn-large">Finish</button>



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


<div id="footer">
    <div class="container">

        &copy;  <a href="http://board.streamerspanel.com/">board.streamerspanel.com</a>
        <small>   &raquo; <a href="http://changelog.streamerspanel.com/" target="_blank">Changelog</a></small>

        <br />

        <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">StreamersPanel</span> von
        <a xmlns:cc="http://creativecommons.org/ns#" href="http://board.streamerspanel.de" property="cc:attributionName" rel="cc:attributionURL">
            David Schomburg</a> ist lizenziert unter einer

        <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/4.0/">
            Creative Commons Namensnennung - Nicht kommerziell - Keine Bearbeitungen 4.0 International Lizenz</a>.

    </div> <!-- /.container -->

</div> <!-- /#footer -->




</body>
</html>

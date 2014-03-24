<?php
/**
 * Created by David Schomburg (DashTec - Services)
 *      www.dashtec.de
 *
 *  S:P (StreamersPanel)
 *  Support: http://board.streamerspanel.de
 *
 *  v 0.19
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
    <title>Form Wizard | Slate Admin 2.0</title>

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

    <script src="../js/demo.wizard.js"></script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


</head>

<body>


<div id="header">

    <div class="container">

        <h1><a href="./">Slate Admin 2.0</a></h1>

        <div id="info">

            <a href="javascript:;" id="info-trigger">
                <i class="icon-cog"></i>
            </a>

            <div id="info-menu">

                <div class="info-details">

                    <h4>S:P Installation</h4>

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
            <div class="wizard-step-label">Business Details</div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-2" class="">
            <div class="wizard-step-number">2</div>
            <div class="wizard-step-label">Profile Details</div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-3" class="">
            <div class="wizard-step-number">3</div>
            <div class="wizard-step-label">Contact Details</div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
    <li>
        <a href="#step-4" class="">
            <div class="wizard-step-number">4</div>
            <div class="wizard-step-label">Finish Wizard</div>
            <div class="wizard-step-bar"></div>
        </a>
    </li>
</ul>

<div id="step-1">

    <h3>Business Details:</h3>


    <br />


    <div class="row-fluid">

        <div class="span6">

            <div class="control-group">
                <label class="control-label" for="bizname">Business Name</label>
                <div class="controls">
                    <input type="text" class="input-medium" id="bizname">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bizemail">Business Email</label>
                <div class="controls">
                    <input type="text" class="input-large" id="bizemail">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bizaddress1">Address 1</label>
                <div class="controls">
                    <input type="text" class="input-large" id="bizaddress1">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bizaddress2">Ste.</label>
                <div class="controls">
                    <input type="text" class="input-small" id="bizaddress2">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="bizindustry">Industry</label>
                <div class="controls">
                    <select multiple="multiple" id="bizindustry">
                        <option>Retail</option>
                        <option>Technology</option>
                        <option>Entertainment</option>
                        <option>Automotive</option>
                        <option>Transportation</option>
                    </select>
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



<div id="step-2">

    <h3>Profile Details:</h3>

    <br />


    <div class="row-fluid">

        <div class="span6">



            <div class="control-group">
                <label class="control-label" for="userfirst">First Name</label>
                <div class="controls">
                    <input class="input-medium" id="userfirst" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="userlast">Last Name</label>
                <div class="controls">
                    <input class="input-large" id="userlast" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="useremail">Email Address</label>
                <div class="controls">
                    <input class="input-large" id="useremail" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="userlanguage">Language</label>
                <div class="controls">
                    <select id="userlanguage" name="userlanguage">
                        <option>Select Language...</option>
                        <option value="da">Danish - Dansk</option>
                        <option value="nl">Dutch - Nederlands</option>
                        <option value="en" selected="">English</option>
                        <option value="fil">Filipino - Filipino</option>
                        <option value="fi">Finnish - Suomi</option>
                        <option value="fr">French - francais</option>
                        <option value="de">German - Deutsch</option>
                        <option value="hu">Hungarian - Magyar</option>
                        <option value="id">Indonesian - Bahasa Indonesia</option>
                        <option value="it">Italian - Italiano</option>
                        <option value="msa">Malay - Bahasa Melayu</option>
                        <option value="no">Norwegian - Norsk</option>
                        <option value="pl">Polish - Polski</option>
                        <option value="pt">Portuguese - Portugu�s</option>
                        <option value="es">Spanish - Espa�ol</option>
                        <option value="sv">Swedish - Svenska</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="userbio">Bio</label>
                <div class="controls">
                    <textarea class="input-large" id="userbio" rows="4"></textarea>
                </div>
            </div>


        </div> <!-- /span6 -->

        <div class="span5 offset1">


            <div class="well">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>


            </div>



        </div> <!-- /span6 -->


    </div> <!-- /row-fluid -->


</div> <!-- /step -->


<div id="step-3">

    <h3>Contact Details:</h3>

    <br />

    <div class="row-fluid">

        <div class="span6">

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>

            <br />

            <div class="control-group">
                <label class="control-label" for="contactname">Full Name</label>
                <div class="controls">
                    <input type="text" class="input-medium" id="contactname">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactphone">Phone #</label>
                <div class="controls">
                    <input type="text" class="input-medium" id="contactphone">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactfax">Fax #</label>
                <div class="controls">
                    <input type="text" class="input-medium" id="contactfax">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contactemail">Contact Email</label>
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

    <h3>Complete:</h3>

    <br />


    <div class="row-fluid">

        <div class="span6">

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <br />

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

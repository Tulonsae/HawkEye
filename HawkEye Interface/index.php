<?php

	session_start();
		
	//Include config and lang pack
	include("config.php");
	include("langs/" . $config["langFile"]);
	
	//If we aren't logged in, go to login page
	if (!isset($_SESSION["loggedin"]) && $config["password"] != "")
		header("Location: login.php");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui.timepicker.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
        <script type="text/javascript" src="js/jquery.uniform.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

        <script type="text/javascript" src="http://cdn.jquerytools.org/1.2.5/tiny/jquery.tools.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/styles.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-timepicker.css" />
        <link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.13.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/uniform.default.css" />
        <link rel="stylesheet" type="text/css" href="css/demo_table_jui.css" />
        <link rel="icon" type="image/png" href="images/favicon.ico" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?php echo $lang["pageTitle"]; ?></title>
    </head>

    
    <body>
    
        <div class="header">
        	<div class="innerHeader">
            	<div class="headerText"><?php echo $lang["title"]; ?><b class="logout"></div><div class="logout"><a href="login.php?page=logout"><button>Log Out</button></a></div>
            </div>
        </div>
        
        <div class="filterContainer">
            <div class="innerFilter">

                <div class="subHeader">
                    <span id="filterMin" style="border-radius: 20px;" class="ui-state-default ui-corner-all minmax" title="<?php echo $lang["tips"]["hideFilter"]; ?>"><span class="ui-icon ui-icon-carat-1-se"></span></span>
                    <p><?php echo $lang["filter"]["title"]; ?></p>
                </div>
                
                <div class="filter">
                    <form id="searchForm" action="">
                        <div class="actions" title="<?php echo $lang["tips"]["actions"]; ?>">
                            <div>
                                <div><input type="checkbox" name="action" value="0" /> <?php echo $lang["actions"][0]; ?></div><br />
                                <div><input type="checkbox" name="action" value="1" /> <?php echo $lang["actions"][1]; ?></div><br />
                                <div><input type="checkbox" name="action" value="2" /> <?php echo $lang["actions"][2]; ?></div><br />
                                <div><input type="checkbox" name="action" value="3" /> <?php echo $lang["actions"][3]; ?></div><br />
                                <div><input type="checkbox" name="action" value="4" /> <?php echo $lang["actions"][4]; ?></div><br />
                                <div><input type="checkbox" name="action" value="5" /> <?php echo $lang["actions"][5]; ?></div><br />
                                <div><input type="checkbox" name="action" value="6" /> <?php echo $lang["actions"][6]; ?></div><br />
                                <div><input type="checkbox" name="action" value="7" /> <?php echo $lang["actions"][7]; ?></div><br />
                                <div><input type="checkbox" name="action" value="8" /> <?php echo $lang["actions"][8]; ?></div><br />
                                <div><input type="checkbox" name="action" value="9" /> <?php echo $lang["actions"][9]; ?></div><br />
                                <div><input type="checkbox" name="action" value="10" /> <?php echo $lang["actions"][10]; ?></div><br />
                                <div><input type="checkbox" name="action" value="11" /> <?php echo $lang["actions"][11]; ?></div><br />
                                <div><input type="checkbox" name="action" value="12" /> <?php echo $lang["actions"][12]; ?></div><br />
                            </div>
                            <div>
                                <div><input type="checkbox" name="action" value="13" /> <?php echo $lang["actions"][13]; ?></div><br />
                                <div><input type="checkbox" name="action" value="14" /> <?php echo $lang["actions"][14]; ?></div><br />
                                <div><input type="checkbox" name="action" value="15" /> <?php echo $lang["actions"][15]; ?></div><br />
                                <div><input type="checkbox" name="action" value="16" /> <?php echo $lang["actions"][16]; ?></div><br />
                                <div><input type="checkbox" name="action" value="17" /> <?php echo $lang["actions"][17]; ?></div><br />
                                <div><input type="checkbox" name="action" value="18" /> <?php echo $lang["actions"][18]; ?></div><br />
                                <div><input type="checkbox" name="action" value="19" /> <?php echo $lang["actions"][19]; ?></div><br />
                                <div><input type="checkbox" name="action" value="20" /> <?php echo $lang["actions"][20]; ?></div><br />
                                <div><input type="checkbox" name="action" value="21" /> <?php echo $lang["actions"][21]; ?></div><br />
                        		<div><input type="checkbox" name="action" value="22" /> <?php echo $lang["actions"][22]; ?></div><br />
                        		<div><input type="checkbox" name="action" value="23" /> <?php echo $lang["actions"][23]; ?></div><br />
                        		<div><input type="checkbox" name="action" value="24" /> <?php echo $lang["actions"][24]; ?></div>
                            </div>
                        </div>
                        <div class="parameters1">
                            <input title="<?php echo $lang["tips"]["players"]; ?>" type="text" name="players" /> <?php echo $lang["filter"]["players"]; ?><br />
                            <input title="<?php echo $lang["tips"]["xyz"]; ?>" type="text" style="width: 60px" name="x" /><input title="<?php echo $lang["tips"]["xyz"]; ?>" type="text" style="width: 60px" name="y" /><input title="<?php echo $lang["tips"]["xyz"]; ?>" type="text" style="width: 60px" name="z"/> <?php echo $lang["filter"]["xyz"]; ?><br />
                            <input title="<?php echo $lang["tips"]["range"]; ?>" type="text" name="range" /> <?php echo $lang["filter"]["range"]; ?><br />
                            <input title="<?php echo $lang["tips"]["keys"]; ?>" type="text" name="keywords" /> <?php echo $lang["filter"]["keys"]; ?><br />
                            <input title="<?php echo $lang["tips"]["exclude"]; ?>" type="text" name="exclude" /> <?php echo $lang["filter"]["exclude"]; ?><br />
                        </div>
                        <div class="parameters2">
                            <input title="<?php echo $lang["tips"]["worlds"]; ?>" type="text" name="worlds" /> <?php echo $lang["filter"]["worlds"]; ?><br />
                            <span title="<?php echo $lang["tips"]["dFrom"]; ?>"><input style="width: 95px" type="text" id="dateFrom" /><input style="width: 55px" type="text" id="timeFrom" /> <?php echo $lang["filter"]["dFrom"]; ?></span><br />
                            <span title="<?php echo $lang["tips"]["dTo"]; ?>"><input style="width: 95px" type="text" id="dateTo" /><input style="width: 55px" type="text" id="timeTo" /> <?php echo $lang["filter"]["dTo"]; ?></span><br />
                            <span title="<?php echo $lang["tips"]["block"]; ?>">
                                <select id="item" name="item">
                                    <option value="0"> </option>
                                </select> <?php echo $lang["filter"]["block"]; ?>
                            </span><br /><br />
                            <div>
                           		<div><button class="searchButton"><?php echo $lang["filter"]["search"]; ?></button></div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        
        <div class="resultsContainer">
        	<div class="innerResults">
                <div class="subHeader">
                    <span id="resultsMin" style="border-radius: 20px;" class="minmax ui-state-default ui-corner-all minmax" title="<?php echo $lang["tips"]["hideResults"]; ?>"><span class="ui-icon ui-icon-carat-1-se"></span></span>
                    <?php echo $lang["results"]["title"]; ?>
                </div>

                <div class="results">
                    <div class="ui-widget">
                        <div class="ui-state-highlight ui-corner-all searchError"> 
                            <p><span class="ui-icon ui-icon-alert"></span>
                            <?php echo $lang["messages"]["clickTo"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="footer">
        	<p>&copy; Oliver Woodings 2011</p>
        </div>
    
    </body>
</html>
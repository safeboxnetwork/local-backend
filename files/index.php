<?php
    /**
     * @author DOC & Mail in Corporate
     * @copyright (C) 2011 All rights reserved
     */

    define('PATH', dirname(__FILE__) . '/');
    include(PATH . 'helper.php');


	$ip = Helper::get_IP_address();
	$key = '';
    $length = 27;
	$chars = '9180736452bcdfghjklmnprstvwxzaeiou';
    for ($p = 0; $p < $length; $p++)
    {
        $key .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
    }
	
	include(PATH . 'geoip/geoipcity.inc');
	include(PATH . 'geoip/geoipregionvars.php');

	$gi = geoip_open(PATH . 'geoip/GeoLiteCity.dat', GEOIP_STANDARD);
	
	$record = geoip_record_by_addr($gi, $ip);
	$lang = $record->country_code;
	$country = $record->country_name;
	$city = $record->city;
	geoip_close($gi);

	// if ($lang != 'HU') {$lang = 'EN';}
	if ($lang != 'EN') {$lang = 'HU';}
	include(PATH . 'lang/' . $lang . '/default.php');

	if (isset($_POST["v1"])) {
		if ($_POST["v1"] == $_POST["v2"]) { // OK 
			$msg = $wrong_login;
		}
		else {
			$msg = $wrong_pics;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="hu-hu" lang="hu-hu">
	<head>
		<meta http-equiv="X-UA-Compatible" content="chrome=1"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $title;?></title>
		<link href="images/favicon.ico" rel="icon" type="image/x-icon" />
		<script src="js/jquery-1.12.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/validator.js"></script>
		<script src="js/login.js"></script>
		<script src="js/ie10-viewport-bug-workaround.js"></script>
	  	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	  	<link rel="stylesheet" href="css/animate.min.css" type="text/css" />
	  	<link rel="stylesheet" href="css/format.css" type="text/css" />
	</head>  	
	<body>
        <div class="section"> 
        	<div class="container">
                <div id="header" class="row">
                    <div id="logo" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <img onclick="window.open('http://<?php echo $_SERVER['HTTP_HOST'];?>', '_self');" src="images/logo.png" style="cursor:pointer;" />
                    </div>
                    <div id="contact" class="col-lg-offset-4 col-lg-2 col-md-offset-4 col-md-2 col-sm-offset-2 col-sm-4 col-xs-6" onclick="jQuery('#contact-box').modal('show');" style="cursor: pointer;">
                        <div style="border-top: 1px solid #ccc;text-align: right;margin-top: 112px;">
                            <?php echo $contact_title;?> 
                        </div>
                    </div>
                </div>
        	</div>
        </div>
        <nav id="footer" class="navbar navbar-default navbar-fixed-bottom" style="background: none; border: none;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12" style="text-align: center;">
                        <span class="menuitem" onclick="showContent('legal');"><?php echo $legal;?></span>
                        <span style="font-size: 24px;">·</span>
                        <span class="menuitem" onclick="showContent('termofuse');"><?php echo $termofuse;?></span>
                        <span style="font-size: 24px;">·</span>
                        <span class="menuitem" onclick="showContent('information');"><?php echo $information;?></span>
                        <span style="font-size: 24px;">·</span>
                        <span class="menuitem" onclick="showContent('impressum');"><?php echo $impressum;?></span>
                    </div>
                </div>
            </div>
        </nav>

		<div id="checkWindow" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		     <div class="modal-content">
                <div class="modal-body">
                    <div class="progress" style="margin-bottom: 0;">
                        <div id="progress-bar" class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <div id="percent">60%</div>
                </div>
		     </div>
		  </div>
		</div> 

		<div id="contentWindow" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		     <div class="modal-content">
                <div class="modal-body">
                    <div id="content"></div>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $Close;?></button>
                </div>                
		     </div>
		  </div>
		</div> 

        <div id="loginWindow" class="section" style="position: absolute; top: 0; width: 100%; display: none;"> 
        	<div class="container">
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-1 col-sm-10 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $login_title;?></h3>
                            </div>
                            <div class="panel-body">
                                <form action="index.php" method="post" class="form-horizontal" role="form" data-toggle="validator">
                                    <div class="form-group">
                                        <label for="l" class="col-sm-2 control-label"><?php echo $login_name; ?></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="l" name="login_name_<?php echo $key;?>" value="" placeholder="<?php echo $required_name;?>" required />
                                            <div class="help-block with-errors"></div>
                                        </div>                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="l"  class="col-sm-2 control-label"><?php echo $login_passwd; ?></label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="p" name="login_passwd_<?php echo $key;?>" value="" placeholder="<?php echo $required_password;?>" required />
                                            <div class="help-block with-errors"></div>                                    
                                        </div>                                    
                                    </div>
                            		<?php
                            			$capthadir = 'images/captha';
                            			if (is_dir($capthadir)) {
                            			    if ($dh = opendir($capthadir)) {
                            			        while (($file = readdir($dh)) !== false) {
                            			        	if (($file != '.') and ($file != '..')) {$files[] = $file;}
                            			        }
                            			        closedir($dh);
                            			    }
                            			}
                            			shuffle($files);
                            			//var_dump($files);
                            			$pics  = array_rand($files, 5);
                            			foreach ($pics as $pic)
                            				$filenames[] = $files[$pic];
                            			$button = array_rand($pics, 1);
                            			$selected = $filenames[$button];
                            			$i = 0;
                        			?>
                        			<div style="width: 100%; text-align: center; margin-top:0px;">
                            			<div style="margin-top:8px;margin-bottom:5px;"><?php echo $picstext[$selected]; ?></div>
                            			<div style="float:right;height:60px;vertical-align:bottom">
                            			<?php 
                            			while ($i < count($pics)) {
                            				?>
                            				<div style="float:right;">
                            					<a href="#"><img class="img-rounded img-thumbnail image submit" name="<?php echo $files[$pics[$i]]; ?>" src="images/captha/<?php echo $files[$pics[$i]]; ?>" width="45" 
                            					alt="<?php echo $files[$pics[$i]]; ?>" /></a></div>
                            				<?php
                            				$i++;
                            			}
                                		?>	
                                        </div>
                                    </div> 
                            		<input type="hidden" name="v1" id="v1" value="<?php echo $selected?>" />
                            		<input type="hidden" name="v2" id="v2" value="" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<div id="alertWindow" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		     <div class="modal-content alert alert-danger">
                <div class="modal-body">
                    <div id="alert_msg"></div>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $Close;?></button>
                </div>                
		     </div>
		  </div>
		</div> 
        
        <div id="contact-box"  class="modal fade" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo $contactForm;?></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" data-toggle="validator">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label"><?php echo $name;?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="<?php echo $thisName;?>" required />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="company" class="col-sm-2 control-label"><?php echo $company;?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="company" name="company" placeholder="<?php echo $thisCompany;?>" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label"><?php echo $phone;?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="<?php echo $thisPhone;?>" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label"><?php echo $email;?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo $thisEmail;?>" required />
                                    <div class="help-block with-errors"></div>
                                    <small><?php echo $contactMessage;?></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-sm-2 control-label"><?php echo $message;?></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="message" name="message" placeholder="<?php echo $thisMessage;?>"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="sendData();" data-dismiss="modal" type="submit" class="btn btn-primary"><?php echo $Send;?></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $Cancel;?></button>
                    </div>                    
                </div>
            </div>
        </div> 
        
		<!-- IP: <?php echo $ip; ?> -->
		<!-- From country: <?php echo $country; ?> -->
		<!-- From city: <?php echo $city; ?> -->
		<!-- Language: <?php echo $lang; ?> -->
		<!-- Key: <?php echo $key; ?> -->
	</body>
    <script type="text/javascript">
        var lang = '<?php echo $lang;?>';
		var wrong_name = '<?php echo $wrong_name?>';
		var wrong_passwd = '<?php echo $wrong_password?>';

        jQuery(document).ready(function () {
            init();
            <?php if (isset($msg)) : ?>
            myalert('<?php echo $msg;?>'); 
            <?php endif; ?>
        });
        jQuery(window).resize(function () {
            setLoginSize();
        });
        
        function init() {
            var val = 0;
            <?php if (!isset($msg)) : ?>
            jQuery('#checkWindow').modal('show');
            (function loading() {
                setTimeout(function () {
                    val = Number(jQuery('#progress-bar').attr('aria-valuenow'));
                    if (val < 100) {
                        val = val + 1;
                        jQuery('#progress-bar').attr('aria-valuenow', val);
                        jQuery('#progress-bar').css('width', val+'%');
                        jQuery('#progress-bar').attr('aria-valuenow', val); 
                        jQuery('#percent').html(val + '%');
                        loading();
                    } else {
                        jQuery('#checkWindow').modal('hide'); 
                        setLoginSize();
                        jQuery('#loginWindow').show();                   
                        jQuery('#loginWindow').addClass('animated fadeInDown');
                    }
                }, 8)
            })();
            <?php else: ?>
                setLoginSize();
                jQuery('#loginWindow').show();                   
                jQuery('#loginWindow').addClass('animated fadeInDown');
            <?php endif; ?>
        }
        

        function sendData() {
            jQuery(function($) {
                var jsondata = {ip      : '<?php echo $ip; ?>',
                                key     : '<?php echo $key; ?>',
                                name    : jQuery('#name').val(),
                                company : jQuery('#company').val(),
                                phone   : jQuery('#phone').val(),
                                email   : jQuery('#email').val(),
                                message : jQuery('#message').val()}
                jQuery.ajax({
                    url:"js/message.php",
        			dataType: 'json',
        			data: jsondata,
                    success:function(data, result)
                    {
                        if (data.error == '') {
                            myalert('<?php echo $message_sent;?>');
                        } else {
                            myalert(data.error);
                        }
                    },
                    error: function(x) {
                        var errorText = '';
                        switch (x.status){ 
                        	case 0:
                               errorText = '<?php echo $error_0;?>';
                        	   break;
                        	case 404:
                               errorText = '<?php echo $error_404;?>';
                        	   break;
                        	case 500:
                               errorText = '<?php echo $error_500;?>';
                        	   break;
                        	default :
                                errorText = '<?php echo $error_unknow;?>';
                        }
                        myalert('<p><?php echo $message_sent_error;?>' +  '<br />' + 
                                '<span class="min">' + errorText + '</span></p>');
                    }
                });
            });
        }      

    </script>
</html>

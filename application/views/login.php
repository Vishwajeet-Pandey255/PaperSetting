<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?php echo base_url(); ?>assets/AdminLib/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/AdminLib/assets/images/favicon.png" type="image/x-icon">
    <title>viho - Premium Admin Template</title>
    <!-- Google font-->
   <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/AdminLib/assets/css/responsive.css">
    
      <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/jquery-3.5.1.min.js"></script>
     
     
     <!-----------------------dd-------------------------->
   
<link rel="stylesheet" href="<?php echo base_url()."assets/lobibox/" ?>css/fonts.css"/> 
<link rel="stylesheet" href="<?php echo base_url()."assets/lobibox/" ?>css/demo.css"/>
<link rel="stylesheet" href="<?php echo base_url()."assets/lobibox/" ?>css/Lobibox.min.css"/>
  <script src="<?php echo site_url('assets/') ?>js/jquery.min.js"></script>
  
<script src="<?php echo base_url()."assets/lobibox/" ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url()."assets/lobibox/" ?>js/Lobibox.js"></script>
<script src="<?php echo base_url()."assets/lobibox/" ?>js/demo.js"></script>
<script src="<?php echo base_url()."assets/" ?>js/global_function.js"></script>
<?php function show_notish($t,$a){ ?> 
  <script>
    Lobibox.notify('<?php echo $t?>', { msg: '<?php echo $a ?>' });

    </script>
<?php } ?> 
<script>

 var SITE_URL='<?php echo base_url()?>';
</script>
<!-----------------------dd-------------------------->
     
    
    
  </head>
  <body>
    <!-- Loader starts-->
    <!--<div class="loader-wrapper">-->
    <!--  <div class="theme-loader">    -->
    <!--    <div class="loader-p"></div>-->
    <!--  </div>-->
    <!--</div>-->
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <section>         
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">
            <div class="login-card">
          <?php 	 $abc= $this->session->flashdata('responce_message');
              if(is_array($abc) && count($abc)>0){
                    echo show_notish($abc['status'],$abc['msg']);
              }
              ?>
                  
                  <form  class="theme-form login-form" enctype="multipart/form-data" id="session_form"  method="post" action="<?php echo base_url("admin_user/admin_login") ?>">
                  
                <h4>Login</h4>
                <h6>Welcome back! Log in to your account.</h6>
                
                <div class="form-group">
                  <label>Login Type</label>
                  <div class="input-group"><?php //print_r($_SESSION)?>
                    
                    <input type="radio" value="1" Checked selected name="LoginType">&nbsp;ADMIN   &nbsp;&nbsp;&nbsp;
                    <input type="radio" value="2"  name="LoginType"> &nbsp;  FACULTY
                  </div>
                </div>
                
                <div class="form-group">
                  <label>Email Address</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                    <input class="form-control" type="text" required="" name="email" id="email"   placeholder="Test@gmail.com">
                  </div>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                    <input class="form-control" type="password" name="password" id="password" required="" placeholder="*********">
                    <div class="show-hide"><span class="show">                         </span></div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="checkbox">
                    <input id="checkbox1" type="checkbox">
                    <label for="checkbox1">Remember password</label>
                  </div><a class="link" href="forget-password.html">Forgot password?</a>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                </div>
                <!--<div class="login-social-title">                -->
                <!--  <h5>Sign in with</h5>-->
                <!--</div>-->
                <!--<div class="form-group">-->
                <!--  <ul class="login-social">-->
                <!--    <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="linkedin"></i></a></li>-->
                <!--    <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="twitter"></i></a></li>-->
                <!--    <li><a href="https://www.linkedin.com/login" target="_blank"><i data-feather="facebook"></i></a></li>-->
                <!--    <li><a href="https://www.instagram.com/login" target="_blank"><i data-feather="instagram">                  </i></a></li>-->
                <!--  </ul>-->
                <!--</div>-->
                <!--<p>Don't have account?<a class="ms-2" href="log-in.html">Create Account</a></p>-->
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- page-wrapper end-->
    <!-- latest jquery-->
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/jquery-3.5.1.min.js"></script>
    <!-- feather icon js-->
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/sidebar-menu.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/config.js"></script>
    <!-- Bootstrap js-->
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/bootstrap/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/bootstrap/bootstrap.min.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo base_url(); ?>assets/AdminLib/assets/js/script.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
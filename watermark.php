<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>TinkrBay PHP Gallery</title>

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">

        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

        <!-- Owl Carousel -->
        <link type="text/css" rel="stylesheet" href="css/owl.carousel.css" />
        <link type="text/css" rel="stylesheet" href="css/owl.theme.default.css" />

        <!-- Magnific Popup -->
        <link type="text/css" rel="stylesheet" href="css/magnific-popup.css" />

        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="css/font-awesome.min.css">

        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="css/style.css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

  <body>

        <!-- Header -->
        <header id="home">
                <!-- Background Image -->
                <div class="bg-img" style="background-image: url('./img/background1.jpg'); background-attachment:fixed">
                        <div class="overlay"></div>
                </div>
                <!-- /Background Image -->

                <!-- Nav -->
                <nav id="nav" class="navbar nav-transparent">
                        <div class="container">

                                <div class="navbar-header">
                                        <!-- Logo -->
                                        <div class="navbar-brand">
                                                <a href="index.html">
                                                        <img class="logo" src="img/logo.png" alt="logo">
                                                        <img class="logo-alt" src="img/logo-alt.png" alt="logo">
                                                </a>
                                        </div>
                                        <!-- /Logo -->

                                        <!-- Collapse nav button -->
                                        <div class="nav-collapse">
                                                <span></span>
                                        </div>
                                        <!-- /Collapse nav button -->
                                </div>

                                <!--  Main navigation  -->
                                <ul class="main-nav nav navbar-nav navbar-right">
                                        <li><a href="index.html">Home</a></li>
                                </ul>
                                <ul class="main-nav nav navbar-nav navbar-right">
                                        <li><a href="watermark.php">Upload new</a></li>
                                </ul>
                                <!-- /Main navigation -->

                        </div>
                </nav>
                <!-- /Nav -->

                <!-- home wrapper -->
                <div class="home-wrapper">
                        <div class="container">
                                                        <div class="row">
<?php

if(isset($_FILES['image_file']))
{
        $max_size = 800; //max image size in Pixels
        $destination_folder = '/var/www/html/php-watermark-gallery/images';
        $watermark_png_file = 'watermark.png'; //watermark png file

        $image_name = $_FILES['image_file']['name']; //file name
        $image_size = $_FILES['image_file']['size']; //file size
        $image_temp = $_FILES['image_file']['tmp_name']; //file temp
        $image_type = $_FILES['image_file']['type']; //file type

        switch(strtolower($image_type)){ //determine uploaded image type
                        //Create new image from file
                        case 'image/png':
                                $image_resource =  imagecreatefrompng($image_temp);
                                break;
                        case 'image/gif':
                                $image_resource =  imagecreatefromgif($image_temp);
                                break;
                        case 'image/jpeg': case 'image/pjpeg':
                                $image_resource = imagecreatefromjpeg($image_temp);
                                break;
                        default:
                                $image_resource = false;
                }

        if($image_resource){
                //Copy and resize part of an image with resampling
                list($img_width, $img_height) = getimagesize($image_temp);

            //Construct a proportional size of new image
                $image_scale        = min($max_size / $img_width, $max_size / $img_height);
                $new_image_width    = ceil($image_scale * $img_width);
                $new_image_height   = ceil($image_scale * $img_height);
                $new_canvas         = imagecreatetruecolor($new_image_width , $new_image_height);

                if(imagecopyresampled($new_canvas, $image_resource , 0, 0, 0, 0, $new_image_width, $new_image_height, $img_width, $img_height))
                {

                        if(!is_dir($destination_folder)){
                                mkdir($destination_folder);//create dir if it doesn't exist
                        }

                        //center watermark
                        $watermark_left = ($new_image_width/2)-(300/2); //watermark left
                        $watermark_bottom = ($new_image_height/2)-(100/2); //watermark bottom

                        $watermark = imagecreatefrompng($watermark_png_file); //watermark image
                        imagecopy($new_canvas, $watermark, $watermark_left, $watermark_bottom, 0, 0, 300, 100); //merge image

                        //output image direcly on the browser.
                        header('Location:gallery.php');
                        //imagejpeg($new_canvas, NULL , 90);

                        //Or Save image to the folder
                        imagejpeg($new_canvas, $destination_folder.'/'.$image_name , 90);

                }
        }
}

?>
<head>
<style type="text/css">
#upload-form {
        padding: 20px;
        background: #F7F7F7;
        border: 1px solid #CCC;
        margin-left: auto;
        margin-right: auto;
        width: 400px;
}
#upload-form input[type=file] {
        border: 1px solid #ddd;
        padding: 4px;
}
#upload-form input[type=submit] {
        height: 30px;
}
</style>
</head>
<body>

<form action="" id="upload-form" method="post" enctype="multipart/form-data">
<input type="file" name="image_file" />
<input type="submit" value="Send Image" />
</form>
<a href="gallery.php" target="_blank">Visit the Gallery</a>
</body>
                                                        </div>
                        </div>
                </div>
                <!-- /home wrapper -->

        </header>
        <!-- /Header -->

        <!-- Footer -->
        <footer id="footer" class="sm-padding bg-dark">

                <!-- Container -->
                <div class="container">

                        <!-- Row -->
                        <div class="row">

                                <div class="col-md-12">

                                        <!-- footer logo -->
                                        <div class="footer-logo">
                                                <a href="index.html"><img src="img/logo-alt.png" alt="logo"></a>
                                        </div>
                                        <!-- /footer logo -->

                                        <!-- footer follow -->
                                        <ul class="footer-follow">
                                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                                <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                        </ul>
                                        <!-- /footer follow -->

                                        <!-- footer copyright -->
                                        <div class="footer-copyright">
                                                <p>Copyright © 2017. All Rights Reserved. Lab Designed by <a href="http://tinkrbay.com" target="_blank">Tinkr
Bay</a></p>
                                        </div>
                                        <!-- /footer copyright -->

                                </div>

                        </div>
                        <!-- /Row -->

                </div>
                <!-- /Container -->

        </footer>
        <!-- /Footer -->

        <!-- Back to top -->
        <div id="back-to-top"></div>
        <!-- /Back to top -->

        <!-- Preloader -->
        <div id="preloader">
                <div class="preloader">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                </div>
        </div>
        <!-- /Preloader -->

        <!-- jQuery Plugins -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="js/jquery.magnific-popup.js"></script>
        <script type="text/javascript" src="js/main.js"></script>

  </body>
</html>


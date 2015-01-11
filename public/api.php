<?php
/**
 * Created by IntelliJ IDEA.
 * User: flo
 * Date: 10/01/15
 * Time: 16:20
 */
?>
<!doctype html>
<html>
<head>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script src="script.js"></script>
    <style>
        html{
            width: 100%;
            height: 100%;
        }
        body{
            margin: 0;
            font-family: 'Lato', sans-serif ;
            height: 100%;
            background-color: #b1b2b6;
        }
        body li{
            list-style-type: none;
            background-color: white;
            margin: 10px 0 10px 0;
            padding: 5px 0 5px 0;
            text-align: center;
        }
        body li:nth-child(1){
            margin-bottom: inherit; !important;
        }
        body li:nth-child(2){
            margin: inherit !important;
        }
        .main_container{
            margin: auto;
            width: 60%;
            background-color: #232223;
            padding: 20px 20px 0 20px;
            min-height: 100%;
        }
        .head{
            background-color: white;
            width: 75%;
            margin: auto;
            text-align: center;
            padding: 10px 0 10px 0;
        }
        .avatar{
            border: 5px solid #fd620b;
            border-radius: 20px;
        }

    </style>
</head>
<body>
    <div class="main_container">
        <div class="head">
            <a href="#" class="connect"><img src="http://connect.soundcloud.com/2/btn-connect-sc-l.png" alt="Connect with SoundCloud" title="Connect with SoundCloud" /></a>
            <p>Hello, your name is <span id="username"></span></p>
            <div id="avatar"></div>
        </div>
        <div id="results"></div>
    </div>
</body>
</html>
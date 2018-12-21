<?php
/*
 * Remote File Copy PHP Script 2.0.0
 *
 * Copyright 2012, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

$upload_dir = __DIR__."/downloads";

if (empty($_REQUEST["url"])) {
?><!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- Custom styles for this template
    <link href="style.css" rel="stylesheet"> -->

    <title>File Transfer Script by Sumonst21</title>
</head>
<body>
    <div class="container">

        <div class="starter-template">
            <h1 class="text-center">Transfer Files</h1>
            <form>
                <legend>Authorized Users Only</legend>
                <div class="form-group row">
                    <label for="User" class="col-sm-2 col-form-label">User</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="username" aria-describedby="helpId" placeholder="Enter User Name">
                        <small id="helpId" class="form-text text-muted"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" id="password" placeholder="*******">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="url" class="col-sm-2 col-form-label">File URL</label>
                    <div class="col-sm-10">
                        <input type="url" name="fileurl" id="fileurl" class="form-control" value="" required="required" title="" placeholder="http://domain.com/filename.zip">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
<ul></ul>
<progress value="0" max="100" style="display:none;"></progress>
            <div id="upload-progress" class="progress" style="display:none;">
                <div class="progress-bar"></div>
            </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- removed slim <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
function callback(message) {
    if (!message) {
        console.error('Empty event callback response.');
        return;
    }
    $.each(message, function (key, value) {
        switch (key) {
            case 'send':
                $('#upload-progress').show();
                break;
            case 'progress':
                if (value && value.total) {
                    //$('progress').val(value.loaded / value.total * 100);
                    var percent = value.loaded / value.total * 100;
                    $("#upload-progress .progress-bar").css("width", +percent + "%").attr("aria-valuenow", percent).text(percent + "% Complete");
                }
                break;
            case 'done':
                $('<li style="color:green;">').text(value && value.name).appendTo('ul');
                $('progress').hide();
                break;
            case 'fail':
                $('<li style="color:red;">').text(value && value.message).appendTo('ul');
                $('progress').hide();
                break;
        }
    });
}
$('form').on('submit', function (e) {
    e.preventDefault();
    $('<iframe src="javascript:false;" style="display:none;"></iframe>')
        .prop('src', '?url=' + encodeURIComponent($(this).find('input#fileurl').val()))
        .appendTo(document.body);
});
</script>
</body>
</html><?php
    exit;
}

$url = !empty($_REQUEST["url"]) && preg_match("|^http(s)?://.+$|", stripslashes($_REQUEST["url"])) ?
    stripslashes($_REQUEST["url"]) : null;

$callback = !empty($_REQUEST["callback"]) && preg_match("|^\w+$|", $_REQUEST["callback"]) ?
    $_REQUEST["callback"] : "callback";

$use_curl = defined("CURLOPT_PROGRESSFUNCTION");

$temp_file = tempnam(sys_get_temp_dir(), "upload-");

$fileinfo = new stdClass();
$fileinfo->name = trim(basename($url), ".\x00..\x20");

// 1KB of initial data, required by Webkit browsers:
echo "<span>".str_repeat("0", 1000)."</span>";

function event_callback ($message) {
    global $callback;
    echo "<script>parent.".$callback."(".json_encode($message).");</script>";
}

function get_file_path () {
    global $upload_dir, $fileinfo, $temp_file;
    return $upload_dir."/".basename($fileinfo->name).'.'.basename($temp_file).'.dat';
}

function stream_notification_callback ($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max) {
    global $fileinfo;
    switch($notification_code) {
        case STREAM_NOTIFY_FILE_SIZE_IS:
            $fileinfo->size = $bytes_max;
            break;
        case STREAM_NOTIFY_MIME_TYPE_IS:
            $fileinfo->type = $message;
            break;
        case STREAM_NOTIFY_PROGRESS:
            if (!$bytes_transferred) {
                event_callback(array("send" => $fileinfo));
            }
            event_callback(array("progress" => array("loaded" => $bytes_transferred, "total" => $bytes_max)));
            break;
    }
}

function curl_progress_callback ($curl_resource, $total, $loaded) {
    global $fileinfo;
    if (!$loaded) {
        if (!isset($fileinfo->size)) {
            $fileinfo->size = $total;
            event_callback(array("send" => $fileinfo));
        }
    }
    event_callback(array("progress" => array("loaded" => $loaded, "total" => $total)));
}

if (!$url) {
    $success = false;
} else if ($use_curl) {
    $fp = fopen($temp_file, "w");
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOPROGRESS, false );
    curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, "curl_progress_callback");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    $success = curl_exec($ch);
    $curl_info = curl_getinfo($ch);
    if (!$success) {
        $err = array("message" => curl_error($ch));
    }
    curl_close($ch);
    fclose($fp);
    $fileinfo->size = $curl_info["size_download"];
    $fileinfo->type = $curl_info["content_type"];
} else {
    $ctx = stream_context_create();
    stream_context_set_params($ctx, array("notification" => "stream_notification_callback"));
    $success = copy($url, $temp_file, $ctx);
    if (!$success) {
        $err = error_get_last();
    }
}

if ($success) {
    $success = rename($temp_file, get_file_path());
}

if ($success) {
    event_callback(array("done" => $fileinfo));
} else {
    unlink($temp_file);
    if (!$err) {
        $err = array("message" => "Invalid url parameter");
    }
    event_callback(array("fail" => $err));
}

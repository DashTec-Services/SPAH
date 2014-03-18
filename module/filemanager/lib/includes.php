<?php
/*
 * Small File Uploader 
 * by DenonStudio
 * http://codecanyon.net/item/small-file-uploader/220176
 * v2.0
 */

function echoResult($result)
{
    $json = json_encode($result);

    if (isXhrRequest())
    {
        header("Content-Type: application/json");
        echo $json;
    }
    else
    {
        $instanceid = $result['instanceid'];
        ?>
        <script type="text/javascript">
            parent.jQuery.fn.SmallFileUploader.Instances['<?php echo $instanceid; ?>'].onComplete(eval('(<?php echo $json; ?>)'));
        </script>
    <?php
    }
}

function getFileExtension()
{
    $name        = $_FILES["filedata"]["name"];
    $nameparts   = explode(".", $name);
    $lastElement = sizeof($nameparts) - 1;

    return (sizeof($nameparts) < 2) ? "" : strtolower($nameparts[$lastElement]);
}

function bytesToMegaBytes($bytes)
{
    if ($bytes < 1024)
    {
        return $bytes . " bytes";
    }
    else
    {
        if ($bytes < 1024 * 1024)
        {
            return floor($bytes / 1024) . " KB";
        }
        else
        {
            return floor($bytes / (1024 * 1024)) . " MB";
        }
    }
}

function isXhrRequest()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

function isRequestMethodOkay()
{
    return ($_SERVER["REQUEST_METHOD"] == "POST" or isXhrRequest());
}

function validateUpload()
{
    if (!isRequestMethodOkay())
    {
        echoResult(array(
            "success" => false,
            "message" => "this request kind isn't supported"
        ));

        return false;
    }

    if (isset($_POST["fileid"]) == false)
    {
        echoResult(array(
            "success" => false,
            "message" => "no file was identified"
        ));

        return false;
    }

    if (sizeof($_FILES) == 0)
    {
        echoResult(array(
            "success"    => false,
            "message"    => "no file can be detected",
            "instanceid" => $_POST["instanceid"],
            "id"         => $_POST["fileid"]
        ));

        return false;
    }

    $file = $_FILES["filedata"];

    global $maxFileSize;

    if ($maxFileSize != null && $maxFileSize < $file["size"])
    {
        echoResult(array(
            "success"    => false,
            "message"    => "file is larger than the " . bytesToMegaBytes($maxFileSize) . " limit" ,
            "id"         => $_POST["fileid"],
            "instanceid" => isXhrRequest() ? "" : $_POST["instanceid"],
            "file"     => array(
                "name" => $file ["name"  ],
                "mime" => $file ["type"  ],
                "size" => $file ["size"  ],
                "id"   => $_POST["fileid"]
            )
        ));

        return false;
    }

    global $allowedTypes;

    if ($allowedTypes != null && in_array(getFileExtension(), $allowedTypes) == false)
    {
        echoResult(array(
            "success"    => false,
            "message"    => "file type is not allowed",
            "id"         => $_POST["fileid"],
            "instanceid" => isXhrRequest() ? "" : $_POST["instanceid"],
            "file"     => array(
                "name" => $file ["name"  ],
                "mime" => $file ["type"  ],
                "size" => $file ["size"  ],
                "id"   => $_POST["fileid"]
            )
        ));

        return false;
    }

    return true;
}

if (validateUpload() == true)
{
    $file = $_FILES["filedata"];

    handleUpload($file);

    echoResult(array(
        "success"    => true,
        "id"         => $_POST["fileid"],
        "instanceid" => isXhrRequest() ? "" : $_POST["instanceid"],
        "file"     => array(
            "name" => $file ["name"  ],
            "mime" => $file ["type"  ],
            "size" => $file ["size"  ],
            "id"   => $_POST["fileid"]
        )
    ));
}

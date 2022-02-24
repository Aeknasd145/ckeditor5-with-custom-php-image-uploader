<?php
    $upload_type = $_FILES['upload']['type']; // get file type
    if ($upload_type=='image/jpeg' or $upload_type=='image/jpg' or $upload_type=='image/png') {
        $upload_name = $_FILES['upload']['name']; // get file name
        $new_upload_name = $upload_name;
        $counter = 1; // counter
        while ($counter) {
            $new_location = "../../assets/images/" . $new_upload_name; // file upload location
            if (!file_exists($new_location)) { // if file not exist
                if (!move_uploaded_file($_FILES["upload"]["tmp_name"], $new_location)) { // if move file to new location is false
                    echo 'Image Couldnt Upload!';
                } else {
                    echo 'Image uploaded';
                }
                $counter = 0; // for finish the while
            } else {
                // $type equal to file type
                if ($_FILES['upload']["type"] == "image/png") {
                    $type = ".png";
                } else if ($_FILES['upload']["type"] == "image/jpeg") {
                    $type = ".jpeg";
                } else if ($_FILES['upload']["type"] == "image/jpg") {
                    $type = ".jpg";
                }
                $new_upload_name = str_replace($type, "", $upload_name); // delete type from file name
                $new_upload_name .= "-" . $counter . $type; // add -counter (number) end of the name and add type
                $counter++;
            }
        }
    }
    else {
        echo "Error, wrong file type!";
    }
?>

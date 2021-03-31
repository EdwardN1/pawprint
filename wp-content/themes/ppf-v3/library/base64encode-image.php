<?php

    function base64encode_image($img){

        $img_file = $img;
        $imgData = base64_encode(file_get_contents($img_file));

        $file_info = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $file_info->buffer(file_get_contents($img_file));

        $src = 'data: '.$mime_type.';base64,'.$imgData;

        return $src;

    }

?>
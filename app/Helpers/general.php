<?php

function getFolder()
{
    return app()->getLocale()=='ar'?'css-rtl':'css';
}

function saveImage($photo , $folder)
    {
        $file_ext = $photo ->getClientOriginalExtension();
        $file_name = time().'.'.$file_ext;
        $path = $folder;
        $photo->move($path,$file_name);
        return $file_name;
    }
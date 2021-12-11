<?php

function redirect($to){
    header("location:$to");
    die();
}

/**
 * Get a public url pointing to an uploaded file
 * @param string $path Upload path
 * @return string
 */
function public_file($path){
    return PUBLIC_UPLOADS_URL.$path;
}

/**
 * Get url to a location
 * @param string $route
 * @param array $params Query Parameters
 * @return string
 */
function url($route, $params = []){
    $key_value_params = [];
    
    foreach($params as $param => $val){
        array_push($key_value_params, $param.'='.$val);
    }
    
    $query_params = '';

    if(count($key_value_params) > 0){
        if(count(explode('?', $route)) > 1){
            $query_params = '&'.implode('&', $key_value_params);
        }else{
            $query_params = '?'.implode('&', $key_value_params);
        }
    }

    return $route.$query_params;
}

/**
 * Get current url
 */
function currentUrl(){
    return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

/**
 * Get current page, e.g /discover
 */
function currentPage(){
    $url = currentUrl();
    $url = explode('?', $url)[0];

    $base_url = preg_replace('/(http:\/\/)|(https:\/\/)/', '', BASE_URL);
    $url = preg_replace('/(http:\/\/)|(https:\/\/)/', '', $url);

    $page = substr_replace($url, '', 0, strlen($base_url));

    // Add initial slash
    if(substr($page, 0, 1) != '/'){
       $page = '/' . $page;
    }

    return $page;
}

/**
 * Get url query params
 * @return array
 */
function getUrlParams(){
    $url = currentUrl();

    $query_params = explode('?', $url)[1] ?? null;

    if($query_params == null){
        return [];
    }

    $params = [];
    $query_params = explode('&', $query_params);

    foreach($query_params as $qp){
        $qp = explode('=', $qp);

        $params[$qp[0]] = $qp[1] ?? null;
    }

    return $params;
}

function getIpAddress(){
    return $_SERVER['REMOTE_ADDR'] ??
        $_SERVER['REMOTE_HOST'] ??
        'Unknown';
}

/**
 * Check if the current url is an admin url
 */
function isAdminContext(){
    $url = currentUrl();

    return preg_match("/".str_replace('/', '\/', BASE_ADMIN_URL)."/", $url);
}

/**
 * Check if data has been submitted via POST method
 * @return bool
 */
function dataPosted(){
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Get clean url $_GET parameters
 * @param string $key
 * @param \mysqli $conn
 * @param $default
 * @return string|null
 */
function get($key, $conn = null, $default = null){
    return clean($_GET[$key] ?? '', $conn, $default);
}

/**
 * Get clean $_POST data
 * @param string $key
 * @param \mysqli $conn
 * @param $default
 * @return string|null
 */
function post($key, $conn = null, $default = null){
    return clean($_POST[$key] ?? '', $conn, $default);
}

/**
 * clean a user provided input
 * @param string $key
 * @param \mysqli $conn
 * @param $default
 * @return string|null
 */
function clean($key, $conn = null, $default = null){
    $value = trim($key);

    if($key == '') return $default;

    if($conn == null){
        $conn = db();
    }

    // Escape html special characters
    $value = htmlspecialchars($value);

    // Escape special chars
    $value = mysqli_real_escape_string($conn, $value);

    return $value;
}

/**
 * Get an uploaded file
 * @param string $key
 * @return array|null
 */
function post_file($key){
    $file = $_FILES[$key] ?? null;
    
    if($file == null || !isset($file['size'], $file['name'], $file['type'], $file['tmp_name'])){
        return null;
    }

    return $file;
}

/**
 * Get uploaded files under same key
 * @param string $key
 * @return array
 */
function post_files($key){
    $files = $_FILES[$key] ?? null;

    if($files == null){
        return [];
    }
    
    $uploaded_files = [];

    $keys = ['name', 'type', 'tmp_name', 'size'];

    foreach($keys as $key){
        $i = 0;
        foreach($files[$key] as $value){
            $uploaded_files[$i][$key] = $value;
            $i++;
        }
    }

    return $uploaded_files;
}

/**
 * Save an uploaded a file
 * @param array $file
 * @param $in Directory to save file in, inside the base uploads directory, if null, the file will be saved in the base directory
 * @param $as The file name of the uploaded file 
 */
function upload_file($file, $in = null, $as = null){
    try{
        if($file == null){
            return null;
        }

        $dir = FILE_UPLOADS_DIRECTORY;

        if($in != null){
            $dir .= $in;
        }

        if(!file_exists($dir) || is_file($dir)){
            mkdir($dir, 0777, true);
        }

        $file_name = $file['name'];
        $file_name = preg_replace('/ +/', '_', $file_name); // Replace spaces with a dash
        
        // Make name unique
        $file_name = uniqid().'_'.$file_name;

        $file_path = $dir.'/'.$file_name;

        if(move_uploaded_file($file['tmp_name'], $file_path)){
            // Return file path, as in the uploads folder
            return ($in == null ? '':($in.'/')).$file_name;
        }

        return null;
    }catch(\Exception $e){
        return null;
    }
}
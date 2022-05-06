<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'&&!empty($_POST['link'])) {
    $result = filter_var($_POST['link'], FILTER_VALIDATE_URL);
    if($result){
        $ini_array = parse_ini_file("links.ini", true);
        if (!empty($ini_array)) {
            unlink("links.ini");
        }
        while (true) {
            $short = generateRandomString();
            if (!array_key_exists($short, $ini_array)) {
                $ini_array[$short] = $_POST['link'];
                break;
            }
        }
        $inisave = arr2ini($ini_array);
        $fp = fopen('links.ini', 'w+');
        fwrite($fp, $inisave . PHP_EOL);
        fclose($fp);
        echo json_encode(array('status' => 'success', 'short_link' => 'https://' . $_SERVER['SERVER_NAME'] . '/r/' . $short));
    }
    else{
        echo json_encode(array('status'=>'error'));
    }

}
else{
    echo json_encode(array('status'=>'error'));
}
function generateRandomString($length = 5)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function arr2ini(array $a, array $parent = array())
{
    $out = '';
    foreach ($a as $k => $v) {
        if (is_array($v)) {
            $sec = array_merge((array)$parent, (array)$k);
            $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
            $out .= arr2ini($v, $sec);
        } else {
            $out .= "$k=$v" . PHP_EOL;
        }
    }
    return $out;
}
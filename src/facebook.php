   $app_id = xxx;
$app_secret = "xxx";
$my_url = "http://apps.facebook.com/myapp/test.php";

$code = $_REQUEST["code"];

if(empty($code)) {
    $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
        . $app_id . "&redirect_uri=" . urlencode($my_url);

    echo("<script> top.location.href='" . $dialog_url . "'</script>");
}


$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
    . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
    . $app_secret . "&code=" . $code;

$access_token = file_get_contents($token_url);

//upload photo
$file= 'test.png';
$args = array(
   'message' => 'Photo from application',
);
$args[basename($file)] = '@' . realpath($file);

print_r($args);

$ch = curl_init();
$url = 'https://graph.facebook.com/2038278/photos?access_token='.$access_token;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
$data = curl_exec($ch);
//returns the photo id
print_r(json_decode($data,true));
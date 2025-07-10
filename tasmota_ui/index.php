<!DOCTYPE HTML>
<title>Tasmota</title>
<head>
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script>history.scrollRestoration = "manual"</script>
</head>
<html>
<body>

<script>
function curlDevice($input){
    var names = $input;
    var nameArr = names.split(',');
    var type = nameArr[0];
    var name = nameArr[1];
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST","api.php/post/" + type + "/" + name+ "/power/toggle",true);
    xmlhttp.send();
};
</script>

<?php

///GET POWER STATE
function getState($deviceName) {
    $ch = curl_init();curl_setopt($ch, CURLOPT_URL, "http://$deviceName/cm?cmnd=Power");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($json, true);$outcome = $array['POWER'];
    if ($outcome === 'ON') echo "checked";
}

///Receive/Parse JSON File
$json_url = "devices.json";
$json = file_get_contents($json_url);
$links = json_decode($json, true);

///Seperate By Types
foreach($links as $key=>$val){
    json_encode($key);
    $typeName = $key;
?>

<!-- Type Title -->
<div class="title">
    <h2><?php echo $typeName ?></h2>
</div>

<div class="two">
    <?php
    foreach($links[$typeName] as $key=>$val){
        json_encode($key);
        json_encode($val);
        $deviceName = $key;
        $deviceIp = $val;
        $friendlyName = str_replace("_"," ",$deviceName);
    ?>

    <div class="one">
        <div class="switch-holder">
            <div class="switch-label">
                </i><span><a href="http://<?php echo $deviceIp ?>" title="wallpaper" style="color:rgba(0, 0, 0, 0.5);text-decoration:none" target="_blank"><?php echo $friendlyName ?></a></span>
            </div>
            <div class="switch-toggle">
                <input type="checkbox" id="<?php echo $deviceName ?>" onchange=curlDevice("<?php echo $typeName.",".$deviceName; ?>") <?php getState($deviceIp)?> />
                <label for="<?php echo $deviceName ?>"></label>
            </div>
        </div>
    </div> 
    <?php
        }
    ?>
</div> 

<?php
    }
?>

</body>

</html>
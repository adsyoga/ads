<?php

function is_referrer_facebook() {
    return isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'facebook.com') !== false;
}

function is_mobile_device() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = ['Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi'];

    foreach ($mobile_agents as $agent) {
        if (strpos($user_agent, $agent) !== false) {
            return true;
        }
    }
    return false;
}

function get_user_country() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "http://ipinfo.io/{$ip}/json";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return $data['country'] ?? null;
}

$is_facebook = is_referrer_facebook();
$is_mobile = is_mobile_device();
$country = get_user_country();

if ($is_facebook && $is_mobile) {
    if ($country === 'ID') {
        // Show the ad that cannot be clicked for Indonesian users
        echo <<<HTML

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Overlay on Image</title>
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }
        .image-container img {
            display: block;
        }
        .ad-overlay {
            position: absolute;
            top: 75%;
            left: 75%;
            transform: translate(-50%, -50%);
            width: 300px; /* Specify width of the ad container */
            height: 250px; /* Specify height of the ad container */
            pointer-events: none; /* Ensure the overlay does not block interactions */
        }
        .ad-overlay ins {
            width: 100%;
            height: 100%;
            display: block;
            opacity: 0; /* Make the ad completely transparent */
            pointer-events: none; /* Ensure the ad is not clickable */
        }
        .hidden {
            display: none;
        }
    </style>

    <div class="image-container">
        <img src="https://abshome.my.id/ads/massagebanner.png" alt="Massage Banner">
        <div class="ad-overlay" id="adOverlay">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5756011336556977"
                crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="fluid"
                data-ad-layout-key="-g2-1s-17-79+rm"
                data-ad-client="ca-pub-5756011336556977"
                data-ad-slot="5516362930"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
         </div>
    </div>
      
HTML;
    } else {
        // Show the clickable ad for non-Indonesian users
        echo <<<HTML

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Overlay on Image</title>
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }
        .image-container img {
            display: block;
        }
        .ad-overlay {
            position: absolute;
            top: 75%;
            left: 75%;
            transform: translate(-50%, -50%);
            width: 300px; /* Specify width of the ad container */
            height: 250px; /* Specify height of the ad container */
            pointer-events: none; /* Ensure the overlay does not block interactions */
        }
        .ad-overlay ins {
            width: 100%;
            height: 100%;
            display: block;
            opacity: 0; /* Make the ad completely transparent */
            pointer-events: all; /* Allow the ad to be clickable */
        }
        .hidden {
            display: none;
        }
    </style>

    <div class="image-container">
        <img src="https://abshome.my.id/ads/massagebanner.png" alt="Massage Banner">
        <div class="ad-overlay" id="adOverlay">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5756011336556977"
                crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="fluid"
                data-ad-layout-key="-g2-1s-17-79+rm"
                data-ad-client="ca-pub-5756011336556977"
                data-ad-slot="5516362930"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>

HTML;
    }
} else {
    // If referrer is not from facebook.com or not a mobile device, show the second script
    echo <<<HTML

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5756011336556977"
         crossorigin="anonymous"></script>
    <!-- dog insurance -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:250px"
         data-ad-client="ca-pub-5756011336556977"
         data-ad-slot="3683237631"></ins>
    <script>
         (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

HTML;
}
?>

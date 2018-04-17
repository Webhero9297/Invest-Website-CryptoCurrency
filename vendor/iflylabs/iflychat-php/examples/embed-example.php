<?php
/**
 * Ensure that path to autoload.php is correct
 *
**/

require __DIR__ . '/vendor/autoload.php'; // include the autoload.php present in your vendor folder.

use Iflylabs\iFlyChat;

/**
 * require iflychat.php if you are not using composer.
 */
// require_once('../lib/iflychat.php'); // to be used in case you are not using composer.


/**
 * Get your APP ID and API Key from https://iflychat.com
**/

const APP_ID = 'YOUR_APP_ID';
const API_KEY =  'YOUR_API_KEY';


$iflychat = new iFlyChat(APP_ID, API_KEY);

$iflychat_code = $iflychat->getHtmlCode();

?>

<html>
<head>
</head>
<body>
<h1>How to include iFlyChat in your PHP website?</h1>


<!-- iFlyChat Engine Code Begins -->
<?php print $iflychat_code; ?>
<!-- iFlyChat Engine Code Ends -->

<!-- iFlyChat Embed Code Begin -->
<div class="iflychat-embed" data-room-id="0" data-height="600px" data-width="500px"></div>
<!-- iFlyChat Embed Code Ends -->


</body>
</html>

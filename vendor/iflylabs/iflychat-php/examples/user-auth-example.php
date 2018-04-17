<?php
/**
 *
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

/**
  * You may get user_id, user_name and other user details
  * either from your active PHP session ($_SESSION)
  * or by querying your database
  */

$iflychat->setUser(
  array(
    'user_id' => '2', //string (required)
    'user_name' => 'testUser', // string(required)
    'is_admin' => FALSE, // boolean (optional)
    'user_avatar_url' => 'user-avatar-link', // string (optional)
    'user_profile_url' => 'user-profile-link', // string (optional)
    'is_mod' => FALSE  // boolean (optional)
  )
);

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


</body>
</html>

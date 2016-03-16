<?php
namespace app\controllers;

use Yii;

class PmaController extends \yii\web\Controller
{
    public function actionIndex($db = null)
    {
        $pmaSession = Yii::$app->params['pmaSessionName'];
        $pmaUrl = Yii::$app->params['pmaURL'];
        $dbPassword = null;
        $dbUsername = null;
        $prefix = Yii::$app->params['databasePrefix'];
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $username = $user->name;
            $prefix = $prefix . $username . '_';
            $dbPassword = $user->db_password;
            $dbUsername = Yii::$app->params['databasePrefix'] . $username;
        } else {
             $db = null;
        }
        session_write_close();
        // make the cookie reachable :
        session_set_cookie_params(0, '/', '', 0);
        // same as in config.inc.php :
        session_name($pmaSession);
        session_start();
        $_SESSION['PMA_single_signon_user'] = $dbUsername;
        $_SESSION['PMA_single_signon_password'] = $dbPassword;
        $_SESSION['PMA_single_signon_host'] = Yii::$app->params['pmaHost'];
        // save changes :
        session_write_close();
        if (strpos($pmaUrl, '?') === false) {
            $pmaUrl = $pmaUrl . '?from=visualizer';
        }
        if ($db) {
            $pmaUrl = $pmaUrl . '&' . http_build_query(['db' => $prefix . $db]);
        }
        return $this->redirect($pmaUrl);
    }
}
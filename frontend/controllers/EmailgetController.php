<?php
namespace frontend\controllers;


use frontend\models\Setting;
use frontend\modules\banks\api\Banks;
use frontend\modules\novabanks\api\Novabanks;
use frontend\modules\novabanks\models\NovabanksTranslation;
use frontend\modules\novanews\api\Novanews;
use frontend\modules\novaoffers\api\Novaoffers;
use frontend\modules\page\api\Page;
use frontend\modules\slidemain\api\Slidemain;
use frontend\modules\slidesmall\api\Slidesmall;
use frontend\modules\tickers\api\Tickers;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\modules\offers\api\Offers;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class EmailgetController extends Controller
{

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $_REQUEST = $request->get();

        if (isset($_REQUEST['submitFlag'])) {

            define("MAX_EMAIL_COUNT", $_REQUEST['maxcount']);

            // imap_timeout(IMAP_OPENTIMEOUT, 300);

            // Open pop mailbox
            if (!$mbox = imap_open($_REQUEST['mailbox'], $_REQUEST['login'], $_REQUEST['password'])) {
                ex_print('adsdsadsasda');
                die('Cannot connect/check pop mail! Exiting:'. serialize(imap_errors()));
            }

            if ($hdr = imap_check($mbox)) {
                $msgCount = $hdr->Nmsgs;
            } else {
                echo "Failed to get mail";
                exit;
            }

            echo "<pre>";
            echo 'emails count=' . $msgCount . "\n\n\n";
            echo "record number,from emails list,from names list,to emails list, to names list,extracted from body\n";

            /* might improve performance according to
               http://www.php.net/manual/en/function.imap-headerinfo.php#98809
               imap_headers($mbox);
            */

            for ($X = 1; $X <= min($msgCount, MAX_EMAIL_COUNT); $X++) {
                $this->processMessage($mbox, $X);
            }
            echo "</pre>";

            imap_close($mbox);
        }


        Yii::$app->response->content = '
<form action="/emailget/index" method="GET">
    <p>Please, enter22 IMAP mailbox address, login and password (prefilled for an example)</p>
    <h2>Examples of some IMAP servers (must enable IMAP in settings)</h2>
    <ul>
    <li>Google: {imap.gmail.com:993/imap/ssl}</li>
    <li>Yandex: {imap.yandex.com:993/imap/ssl}</li>
    </ul>
    <b>Script does NOT save any provided information</b>
    <table>
    <tr><td>
    <input type="text" name="mailbox" value="'.(isset($_REQUEST['mailbox']) ? $_REQUEST['mailbox'] : '{147.135.223.202:143}INBOX').'" placeholder="mailbox" ></input>
    </td></tr>
    <tr><td>
    <input type="text" name="login" value="'.(isset($_REQUEST['login']) ? $_REQUEST['login'] : 's@iq-offshore.com').'" placeholder="login" />
    </td></tr>
    <tr><td>
    <input type="password" name="password" value="'.(isset($_REQUEST['password']) ? $_REQUEST['password'] : 'Do7shyTIBT23').'" placeholder="password" />
    </tr></td>
    <tr><td>
    <tr><td>
    <input type="text" name="maxcount" value="'.(isset($_REQUEST['maxcount']) ? $_REQUEST['maxcount'] : '10').'" placeholder="maxcount" />
    </tr></td>
    <input type="submit" value="Get emails!" />
    </td></tr>
    </table>
    <div>    <input name="submitFlag" type="hidden" value="1" /></div>
    </form>
';
    }



    /* took from https://gist.github.com/agarzon/3123118 */
    function extractEmail($content) {
        $regexp = '/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i';
        preg_match_all($regexp, $content, $m);
        return isset($m[0]) ? $m[0] : array ();
    }

    function getAddressText(&$emailList, &$nameList, $addressObject) {
        $emailList = '';
        $nameList = '';
        foreach ($addressObject as $object) {
            $emailList .= ';';
            if (isset($object->personal)) {
                 $emailList .= $object->personal;
            }
            $nameList .= ';';
            if (isset($object->mailbox) && isset($object->host)) {
                $nameList .= $object->mailbox . "@" . $object->host;
            }
        }
        $emailList = ltrim($emailList, ';');
        $nameList = ltrim($nameList, ';');
    }

    function processMessage($mbox, $messageNumber) {
        echo $messageNumber;
        // get imap_fetch header and put single lines into array
        $header = imap_rfc822_parse_headers(imap_fetchheader($mbox, $messageNumber));
        $fromEmailList = '';
        $fromNameList = '';
        if (isset($header->from)) {
            $this->getAddressText($fromEmailList, $fromNameList, $header->from);
        }
        $toEmailList = '';
        $toNameList = '';
        if (isset($header->to)) {
            $this->getAddressText($toEmailList, $toNameList, $header->to);
        }
        $body = imap_fetchbody($mbox, $messageNumber, 1);
        $bodyEmailList = implode(';', $this->extractEmail($body));
        print_r(
           ',' . $fromEmailList . ',' . $fromNameList
            . ',' . $toEmailList . ',' . $toNameList
            . ',' . $bodyEmailList . "\n"
        );
    }
}

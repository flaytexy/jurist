<form method="POST">
    <p>Please, enter IMAP mailbox address, login and password (prefilled for an example)</p>
    <h2>Examples of some IMAP servers (must enable IMAP in settings)</h2>
    <ul>
        <li>Google: {imap.gmail.com:993/imap/ssl}</li>
        <li>Yandex: {imap.yandex.com:993/imap/ssl}</li>
    </ul>
    <b>Script does NOT save any provided information</b>
    <table>
        <tr><td>
                <input type="text" name="mailbox" value="<?=(isset($_REQUEST['mailbox']) ? $_REQUEST['mailbox'] : '{147.135.223.202:143}')?>"></input>
            </td></tr>
        <tr><td>
                <input type="text" name="login" value="<?=(isset($_REQUEST['login']) ? $_REQUEST['login'] : 's@iq-offshore.com')?>"></input>
            </td></tr>
        <tr><td>
                <input type="password" name="password" value="<?=(isset($_REQUEST['password']) ? $_REQUEST['password'] : 'Do7shyTIBT23')?>"></input>
        </tr></td>
        <tr><td>
        <tr><td>
                <input type="text" name="maxcount" value="<?=(isset($_REQUEST['maxcount']) ? $_REQUEST['maxcount'] : '10')?>"></input>
        </tr></td>
        <input type="submit" value="Get emails!"></input>
        </td></tr>
    </table>
    <input name="submitFlag" type="hidden" value="1"></input>
</form>

<?php
if (isset($_REQUEST['submitFlag'])) {

    define("MAX_EMAIL_COUNT", $_REQUEST['maxcount']);

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
            getAddressText($fromEmailList, $fromNameList, $header->from);
        }
        $toEmailList = '';
        $toNameList = '';
        if (isset($header->to)) {
            getAddressText($toEmailList, $toNameList, $header->to);
        }
        $body = imap_fetchbody($mbox, $messageNumber, 1);
        $bodyEmailList = implode(';', extractEmail($body));
        print_r(
            ',' . $fromEmailList . ',' . $fromNameList
            . ',' . $toEmailList . ',' . $toNameList
            . ',' . $bodyEmailList . "\n"
        );
    }

    // imap_timeout(IMAP_OPENTIMEOUT, 300);

    // Open pop mailbox
    if (!$mbox = imap_open($_REQUEST['mailbox'], $_REQUEST['login'], $_REQUEST['password'])) {
        die('Cannot connect/check pop mail! Exiting');
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
        processMessage($mbox, $X);
    }
    echo "</pre>";

    imap_close($mbox);
}
?>
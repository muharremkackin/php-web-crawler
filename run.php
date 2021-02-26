<?php

require_once "vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_POST['firm'] && $_POST['where']) {
    $url = 'https://www.bulurum.com/search/'. $_POST['firm'] .'/'. $_POST['where'] .'/';
    $page = $_POST['page'] ? $_POST['page'] : 0;
    if ($page > 0) {
        $url .= '?page='.$_POST['page'];
    }
    $urls = [];
    $values = [];
    function valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }


    $html = file_get_contents($url); //get the html returned from the following url

    $document = new DOMDocument();

    libxml_use_internal_errors(TRUE); //disable libxml errors

    if(!empty($html)){ //if any html is actually returned

        $document->loadHTML($html);
        libxml_clear_errors(); //remove errors for yucky html

        $xpath = new DOMXPath($document);

        $count = 20;
        $counter = 1;

        $low_counter = 200;
        while ($count > 0) {
            $url_data = $xpath->query('/html/body/div[6]/div[2]/div[1]/div[4]/div/div[' . $counter . ']/div[2]/div/div[1]/div[1]/div/h2/a/@href');
            $url_value = $xpath->query('/html/body/div[6]/div[2]/div[1]/div[4]/div/div[' . $counter . ']/div[2]/div/div[1]/div[1]/div/h2/a');

            if ($url_data->length > 0) {
                foreach ($url_data as $row) {
                    $urls[]["url"] = $row->nodeValue;
//                echo $row->nodeValue . '</br>';
                }
                foreach ($url_value as $row) {
                    $values[]["name"] = $row->nodeValue;
                }
                $count--;
            }
            $counter++;
            $low_counter--;
            if ($low_counter <= 0) {
                break;
            }
        }

        foreach ($urls as $key => $link ) {
            $url = $link["url"];
            $html = file_get_contents($url); //get the html returned from the following url

            $document = new DOMDocument();

            libxml_use_internal_errors(TRUE); //disable libxml errors
            if (!empty($html)) {

                $document->loadHTML($html);
                libxml_clear_errors(); //remove errors for yucky html
                $xpath = new DOMXPath($document);

                $address = $xpath->query('//*[@id="AddressLbl"]');
                if ($address->length > 0) {
                    foreach ($address as $row) {
                        $values[$key]["address"] = explode('\r\n', trim($row->nodeValue))[0];
                    }
                }
                $office_phone = $xpath->query('//*[@id="phones"]/label');
                if ($office_phone->length > 0) {
                    foreach ($office_phone as $row) {
                        $values[$key]["office_phone"] = trim($row->nodeValue);
                    }
                }
                $cell_phone = $xpath->query('//*[@id="MobileContLbl"]/span');
                if ($cell_phone->length > 0) {
                    foreach ($cell_phone as $row) {
                        $values[$key]["cell_phone"] = $row->nodeValue;
                    }
                }
                $website = $xpath->query('//*[@id="WebsiteContLbl"]/a/@href');
                if ($website->length > 0) {
                    foreach ($website as $row) {
                        $values[$key]["website"] = $row->nodeValue;
                    }
                }
                $email = $xpath->query('//*[@id="EmailContLbl"]/a/@href');
                if ($email->length > 0) {
                    foreach ($email as $row) {
                        $email_data = ltrim($row->nodeValue, 'mailTo:');
                        if (valid_email($email_data)) {
                            $values[$key]["email"] = ltrim($row->nodeValue, 'mailTo:');
                        }
                    }
                }
            }
            sleep(rand(0, 10));
        }

    }
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export_<?= $_POST['firm'] . "_" . $_POST['where'] . "_" . $_POST["page"] ?></title>
</head>
<body>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Office Phone</th>
            <th>Cell Phone</th>
            <th>Website</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($values as $key => $value): ?>
        <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $value["name"] ?></td>
            <td><?= key_exists("address", $value) ? $value["address"] : "ADRES YOK" ?></td>
            <td><?= key_exists("office_phone",$value) ? $value["office_phone"] : "ŞİRKET TELEFONU YOK" ?></td>
            <td><?= key_exists("cell_phone", $value) ? $value["cell_phone"] : "MOBİL TEL. YOK" ?></td>
            <td><?= key_exists("website", $value) ? $value["website"] : "WEBSITE YOK" ?></td>
            <td><?= key_exists("email", $value) ? $value["email"] : "EMAIL YOK" ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php }
?>
<?php

require_once __DIR__ . '/vendor/autoload.php';

if($_GET['tytul']){
    $t = $_GET['tytul'];
}

$mpdf = new \Mpdf\Mpdf();

$data = '<h1>'.$t.'-fragment</h1>';
$tekst = implode('', file('../fragmentyksiazek/'.$t.'-tekst.txt'));
$data .= '<p>'.$tekst.'</p>';

$mpdf->WriteHTML($data);

$mpdf->Output(''.$t.'-fragment.pdf','D');

?>
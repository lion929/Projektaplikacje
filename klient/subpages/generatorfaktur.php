<?php

require_once __DIR__ . '/vendor/autoload.php';

if($_GET['numer']){
    $numer = $_GET['numer'];
    $data1 = $_GET['data'];
}

$mpdf = new \Mpdf\Mpdf();

$data = '';

$data .= '<table><tr><td style="border-style:solid; border:1px; background-color:gray; color:white;">FAKTURA NR</td><td style="border-style:solid; border:1px;">'.$numer.'</td></tr></table>';

$data .= '<table style="margin-left:70%;">
<tr><td style="border-style:solid; border:1px;">Rzeszów, '.$data1.'</td></tr>
<tr><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Miejscowość, data wystawienia</td></tr>
</table>';

$data .= '<table style="margin-top:10%;">
<tr><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Nr zamówienia</td></tr>
<tr><td style="border-style:solid; border:1px;">'.$_GET['id'].'</td></tr>
</table>
<table style="margin-top:3%; ">
<tr><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Forma płatności</td></tr>
<tr><td style="border-style:solid; border:1px;">Przelew elektroniczny</td></tr>
</table>';
$idzam = $_GET['id'];
require_once "connect.php";
$conn1 = new mysqli($host, $db_user, $db_pass, $db_name);
$res = $conn1->query("SELECT klienci.Imię, klienci.Nazwisko, klienci.ID_klienta FROM klienci INNER JOIN zamówienia ON zamówienia.ID_klienta = klienci.ID_klienta WHERE zamówienia.ID_zamowienia = $idzam");
$row2 = $res->fetch_assoc();
$idklienta = $row2['ID_klienta'];
$res1 = $conn1->query("SELECT Adres_zamieszkania FROM klienci WHERE ID_klienta = $idklienta");
$row3 = $res1->fetch_assoc();
$conn1->close();

$data .= '<table style="margin-top:10%;">
<tr><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Sprzedawca</td></tr>
<tr><td style="border-style:solid; border:1px;">Księgarnia Internetowa</td></tr>
</table>
<table style="margin-top:3%;">
<tr><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Nabywca</td><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Adres</td></tr>
<tr><td style="border-style:solid; border:1px;">'.$row2['Imię'].' '.$row2['Nazwisko'].'</td><td style="border-style:solid; border:1px;">'.$row3['Adres_zamieszkania'].'</td></tr>
</table>';

$data .= '<table width="100%" style="margin-top:3%;"><tr><td width="20%" style="border-style:solid; border:1px; background-color:gray; color:white;">BANK NR Konta</td>
<td style="border-style:solid; border:1px;">00000000000000000000000000</td></tr></table>';

    mysqli_report(MYSQLI_REPORT_STRICT);
    try {

        require_once "connect.php";

        $conn = new mysqli($host, $db_user, $db_pass, $db_name);

        if ($conn->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }

        else
        {
            $idz = $_GET['id'];
            $query = "SELECT książki.ID_ksiązki, książki.Tytuł, szczegóły_zamowienia.Ilość, szczegóły_zamowienia.Cena FROM szczegóły_zamowienia INNER JOIN książki ON książki.ID_ksiązki = szczegóły_zamowienia.ID_książki WHERE szczegóły_zamowienia.ID_zamówienia = $idz";
            $result = $conn->query($query);

            if (!$result)
            {
                echo throw new Exception($conn->error);
            }

            else
            {
                $suma=0;
                $i=0;
                $data .= '<table width="100%" style="margin-top:3%;"><tr><td width="5%" style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">L.p</td>
                <td width="35%" style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Nazwa towaru</td><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Ilość</td>
                <td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Cena</td><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Cena za 1 szt.</td><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">VAT</td></tr>';
                while ($row = $result->fetch_assoc())
                {
                    $i++;
                    $idk = $row['ID_ksiązki'];
                    $zap1 = $conn->query("SELECT autorzy.Imie, autorzy.Nazwisko FROM książki_autorzy INNER JOIN autorzy ON książki_autorzy.ID_autora = autorzy.ID_autora WHERE książki_autorzy.ID_książki = $idk");
                    $autorzy = "";
                    while($row1 = mysqli_fetch_row($zap1))
                    {
                        $autorzy .= ", ".$row1[0];	
                        $autorzy .= " ".$row1[1];
                    }
                    $zap2 = $conn->query("SELECT wydawnictwa.Nazwa FROM książki INNER JOIN wydawnictwa ON książki.ID_wydawnictwa=wydawnictwa.ID_wydawnictwa WHERE książki.ID_ksiązki=$idk");
                    $wydawnictwo ="";
                    while($row2 = mysqli_fetch_row($zap2))
                    {
                        $wydawnictwo .= ", wyd.: ".$row2[0];	
                    }

                    $data .='<tr><td width="5%" style="border-style:solid; border:1px;">'.$i.'</td><td style="border-style:solid; border:1px;">'.$row['Tytuł'].''.$autorzy.''.$wydawnictwo.'</td><td width="35%" style="border-style:solid; border:1px;">'.$row['Ilość'].
                    '</td><td style="border-style:solid; border:1px;">'.$row['Cena']*$row['Ilość'].'</td><td style="border-style:solid; border:1px;">'.$row['Cena'].'</td><td style="border-style:solid; border:1px;">23%</td></tr>';
                    $suma += $row['Ilość'] * $row['Cena'];
                }

                $data .='</table>';

                $query1 = "SELECT Rabat FROM zamówienia WHERE ID_zamowienia = $idz";
                $res = $conn->query($query1);

                $row1 = $res->fetch_assoc();

                $data .= "<div>Rabat: ".$row1['Rabat']." %</div>";

                $suma = $suma - ($suma * $row1['Rabat']/100);

                $data .= "<div>Suma z rabatem: ".$suma." zł</div>";

                $result->close();
                $conn->close();
            }
        }

    }

    catch(Exception $error) 
    {
        echo "Problemy z odczytem danych";
    }

$data .= 
'<table style="margin-top:10%;">
<tr><td style="background-color:#7E7F80; color:white; border-style:solid; border:1px;">Fakture wystawił</td></tr>
<tr><td style="border-style:solid; border:1px;">Księgarnia internetowa</td></tr>
</table>';

$mpdf->WriteHTML($data);

$mpdf->Output('Faktura-'.$numer.'.pdf','D');

?>
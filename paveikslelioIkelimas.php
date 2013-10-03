<?php

function paveikslelioIkelimas(){
    $kelias = null;
    $arTinkamas = null;

    $leidziamiFormatai = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 262144000)
        && in_array($extension, $leidziamiFormatai))
    {
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Klaidos kodas: " . $_FILES["file"]["error"] . "<br>";
        }
        else
        {
            $dydis = $_FILES["file"]["size"] / 1024 / 1024;

            if (file_exists("upload/" . $_FILES["file"]["name"]))
            {
                echo $_FILES["file"]["name"] . " jau egzistuoja. ";
            }
            else
            {
                $rezPaveikslelisNr = mysql_query("SELECT * FROM test.sistema_paveiksleliai WHERE id = '1'");
                $rowPaveikslelisNr = mysql_fetch_array($rezPaveikslelisNr);
                $pavNr = $rowPaveikslelisNr['numeris'];
                $pavNr++;
                $tipas = substr($_FILES["file"]["type"]." ",6, -1);
                $kelias = "icons/".$pavNr.".".$tipas;
                move_uploaded_file($_FILES["file"]["tmp_name"], $kelias);
                mysql_query( "UPDATE test.sistema_paveiksleliai SET numeris = '$pavNr' WHERE id = '1'" );
            }
        }
    }
    else
    {
        //echo "Netinkamas failas";
        $arTinkamas = "ne";
    }
    $mas[0] = $kelias;
    $mas[1] = $arTinkamas;
    $mas[2] = $dydis;
    return $mas;
}
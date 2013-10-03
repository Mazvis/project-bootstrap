<?php
error_reporting(0);
$_SESSION['vartotojas'] = null;
session_start();

if(isset($_SESSION['vartotojas'])) {
    $vartotojas = $_SESSION['vartotojas'];
}

require_once "paveikslelioIkelimas.php";

$prisijungesVardas = null;
$alert_msg = null;

function imtiKategorijas(){
    $rez = mysql_query("SELECT * FROM test.sistema_kategorijos");
    $i = 0;
    while($row = mysql_fetch_array($rez))
    {
        $mas[$i] = $row['pavadinimas'];
        $i++;
    }
    return $mas;
}

function imtiPirmaKategorija(){
    $rezKategorija = mysql_query("SELECT * FROM test.sistema_kategorijos ORDER BY pavadinimas ASC");
    $rowKat = mysql_fetch_array($rezKategorija);
    $kategorija = $rowKat['pavadinimas'];

    return $kategorija;
}

function imtiIrasus($kategorija){
    $rez = mysql_query("SELECT * FROM test.sistema_irasai");
    //$rez = 'SELECT * FROM test.sistema_irasai';
    if($kategorija != "*")
        $rez = mysql_query("SELECT * FROM test.sistema_irasai WHERE kategorija = '$kategorija'");
        //$rez = 'SELECT * FROM test.sistema_irasai WHERE kategorija = $kategorija';
    $i = 0;
    while($row = mysql_fetch_array($rez))
    {
        $mas[$i][0] = $row['pavadinimas'];
        $mas[$i][1] = $row['data'];
        $mas[$i][2] = $row['kategorija'];
        $mas[$i][3] = $row['autorius'];
        $mas[$i][4] = $row['paveikslelis'];
        $mas[$i][5] = $row['id'];
        $mas[$i][6] = $row['post'];
        $mas[$i][7] = $row['paveikslelio_dydis'];
        $i++;
    }
    return $mas;
}
function NaujausiasVartotojas(){
    $rezVartotojas = mysql_query("SELECT * FROM test.sistema_vartotojai ORDER BY registracijos_data DESC");
    $rowVar = mysql_fetch_array($rezVartotojas);
    $naujVartotojas = $rowVar['vardas'];
    $regData = $rowVar['registracijos_data'];

    $mas[0] = $naujVartotojas;
    $mas[1] = $regData;
    return $mas;
}
function NaujausiasBuvesVartotojas(){
    $rezVartotojas2 = mysql_query("SELECT * FROM test.sistema_vartotojai ORDER BY prisijungimo_data DESC");
    $rowVar2 = mysql_fetch_array($rezVartotojas2);
    $naujBuvesVartotojas = $rowVar2['vardas'];
    $prisData = $rowVar2['prisijungimo_data'];

    $mas[0] = $naujBuvesVartotojas;
    $mas[1] = $prisData;
    return $mas;
}

if(isset($_POST['prisijungti'])){
    $vardas = $_POST['vardas'];
    $psw = $_POST['psw'];

    ///$rez = mysql_query("SELECT * from test.sistema_vartotojai WHERE vardas = '$vardas'");
    $row = mysql_fetch_array("SELECT * from test.sistema_vartotojai WHERE vardas = '$vardas'");
    $v = $row['vardas'];
    $p = $row['slaptazodis'];
    if ($p == $psw){
        $_SESSION['vartotojas']=$vardas;
        $dabartinisLaikas = date("Y-m-d H:i:s");
        mysql_query( "UPDATE test.sistema_vartotojai SET prisijungimo_data = '$dabartinisLaikas' WHERE vardas = '$vardas'" );
    }
    else{
        if ($v != $vardas){
            mysql_query("insert IGNORE into test.sistema_vartotojai (vardas, slaptazodis) values ('$vardas', '$psw')");
            $_SESSION['vartotojas']=$vardas;
            $dabartinisLaikas = date("Y-m-d H:i:s");
            mysql_query( "UPDATE test.sistema_vartotojai SET prisijungimo_data = '$dabartinisLaikas' WHERE vardas = '$vardas'" );
        }
    }
}

if(isset($_POST['atsijungti'])){
    //echo "<p style='color:red'>Sėkmingai atsijungėte<p><br/>";
    if(isset($_SESSION['vartotojas']))
        $_SESSION['vartotojas'] = null;
    //session_destroy();
    $_SESSION['vartotojas'] = null;
}

if(isset($_POST['rasyti'])){
    if($_SESSION['vartotojas'] != null)
        $prisijungesVardas = $_SESSION['vartotojas'];
    $iraso_pavadinimas = stripslashes($_POST['iraso_pavadinimas']);
    $iraso_kategorija = stripslashes($_POST['iraso_kategorija']);
    $postas = stripslashes($_POST['zinute']);

    //paveikslelio ikelimas
    $mas = paveikslelioIkelimas();
    if($mas[1] != "ne"){
        $kelias = $mas[0];
        $dydis = $mas[2];
        mysql_query("INSERT into test.sistema_irasai (pavadinimas, kategorija, autorius, post, paveikslelis, paveikslelio_dydis) values ('$iraso_pavadinimas', '$iraso_kategorija', '$prisijungesVardas', '$postas', '$kelias', '$dydis')");
        $alert_msg = "irasas sukurtas";
    }
    else
        $alert_msg = "Netinkamas paveikslelis, bandykite dar karta.";
}
//mysql_query("ALTER TABLE sistema_irasai ADD paveikslelio_dydis FLOAT(20)");
//mysql_query("ALTER TABLE sistema_irasai DROP COLUMN paveikslelio_dydis");
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <style type="text/css">
        input{border: 0px; width: 90px;}
        div{}
        .div_pagrindinis{width:1140px; border:0px solid green; margin:50px auto 0 auto; padding:20px;  background-color: #48AA5F;}
        .div_prisijungimas{width:1058px; height:100px; border:0px solid blue; padding:20px; margin:20px; background-color: lightgray;}
        .div_iraso_talpinimas{width:1058px; height:180px; border:0px solid blue; padding:20px; margin:20px; background-color: lightgray;}
        .div_irasu_rodymas{width:1058px; border:0px solid blue; padding:20px; margin:20px; background-color: lightgray;}
        .div_apatinis_blokas{width:1058px; height:210px; border:0px solid blue; padding:20px; margin-right:20px; margin-left:20px; background-color: lightgray;}
        .div_ab1{width:400px; height:200px; border:0px solid red; float:left; margin-right:20px; background-color: #E5E4E2;}
        .div_ab2{width:400px; height:200px; border:0px solid red; float:left; margin-right:20px; background-color: #E5E4E2;}
        .div_ab3{width:200px; height:200px; border:0px solid red; float:left; margin-left:10px; background-color: #E5E4E2;}

        .div_irasai_1{width:450px; height:370px; float:left; padding:10px; margin-bottom:20px;}
        .div_irasai_2{width:450px; height:370px; float:right; padding:10px; margin-bottom:20px;}
        .div_iraso_blokas{width:425px; height:90px; border:0px solid red; float:bottom; padding:10px; margin-bottom:20px; background-color: #E5E4E2;}
        .div_ib1{width:70px; height:70px; float:left; padding:10px; background-color: green;}
        .div_ib2{width:210px; height:70px; float:left; padding:10px; margin-left:10px; background-color: #85BB65;}
        .div_ib3{width:70px; height:70px; float:left; padding:10px; background-color: green; color:darkblue; font-weight:bold;}
        .verticalLine{border-left: 1px solid black;}
        span{color: green; font-size:20px; font-weight:bold;}
        a{color: darkred;}
        img{}.img_pagrindinis{ width:70; height:70;}
        table{border:0;}
    </style>
</head>
<body>
<!------------------------------------------------------------------>
<div class="div_pagrindinis">

    <div class="div_prisijungimas">
        <?php if($_SESSION['vartotojas'] == null){ ?>
            <!-- prisijungti -->
            <span>Prisijungti</span><br/>
            <form action="" method="post">
                <label>Vardas:</label><input type="text" name="vardas"/><br/>
                <label>Slaptažodis:</label><input type="password" name="psw"/><br/>
                <input type="submit" value="Prsijungti" name="prisijungti" />
            </form>
        <?php } else { ?>
            <!-- prisijungta -->
            <span>Labas <?php echo $_SESSION['vartotojas'];?></span>
            <form action="" method="post">
                <input type="submit" value="Atsijungti" name="atsijungti" />
            </form>
        <?php } ?>
    </div>

    <!------------------------------------------------------------------>
    <?php if($_SESSION['vartotojas'] != null){ ?>
        <div class="div_iraso_talpinimas">
            <span>Talpinti paveikslėlį</span><br/>
            <form action="" method="post" enctype="multipart/form-data">
                <label>Paveikslėlio pavadinimas:</label><input type="post" name="iraso_pavadinimas"/><br/>
                <label>Paveikslėlio kategorija:</label>
                <select name="iraso_kategorija">
                    <?php
                    $masKategoriju = imtiKategorijas();
                    for($i = 0; $i < sizeof($masKategoriju); $i++)
                        echo "<option value='".$masKategoriju[$i]."'>".$masKategoriju[$i]."</option>";
                    ?>
                </select><br/>
                <label>Komentaras:</label><input type="post" name="zinute"/><br/>
                <label for="file">Paveikslas:</label><input type="file" name="file" id="file"/><br/>
                <input type="submit" value="Patvirtinti" name="rasyti" />
                <?php echo "<br/><p>".$alert_msg."</p>" ?>
            </form>
        </div>
    <?php } ?>

    <!------------------------------------------------------------------>
    <div class="div_irasu_rodymas">
        <span>Paveikslėliai</span><br/>
        <div class="div_irasai_1">
            <?php
            //$masPi[$i][5] - id
            $masPi = imtiIrasus("*");
            $kiekRodyt = 3;
            for($i = sizeof($masPi)-1, $j = 0; $i >= 0; $i--, $j++)
                if($j < $kiekRodyt){
                    /*Data: ".$masPi[$i][1]."</br>*/
                    $irasoBlokas =  "<div class='div_iraso_blokas'>
						<div class='div_ib1'>
							<img src='".$masPi[$i][4]."' alt='nera' class='img_pagrindinis'/></br>
						</div>
						<div class='div_ib2'>
							Pavadinimas: <a href='paveikslas.php?id=".$masPi[$i][5]."'>".$masPi[$i][0]."</a></br>
							Kategorija: ".$masPi[$i][2]."</br>
							Autorius: ".$masPi[$i][3]."</br>
						</div>
						<div class='div_ib3'>
							#".$masPi[$i][5]."<br/><br/></font>
						</div>
					</div>";
                    //#".$masPi[$i][5]."<br/><br/><font size='2'>".$masPi[$i][7]."MG</font>
                    echo $irasoBlokas;
                }else
                    break;
            ?>
        </div>
        <div class="div_irasai_2">
            <?php
            $masPi = imtiIrasus("*");
            $kiekRodyt = 3;
            for($i = sizeof($masPi)-4, $j = 0; $i >= 0; $i--, $j++)
                if($j < $kiekRodyt){
                    //Data: ".$masPi[$i][1]."</br>
                    $irasoBlokas =  "<div class='div_iraso_blokas'>
						<div class='div_ib1'>
							<img src='".$masPi[$i][4]."' alt='nera' class='img_pagrindinis'/></br>
						</div>
						<div class='div_ib2'>
							Pavadinimas: <a href='paveikslas.php?id=".$masPi[$i][5]."'>".$masPi[$i][0]."</a></br>
							Kategorija: ".$masPi[$i][2]."</br>
							Autorius: ".$masPi[$i][3]."</br>
						</div>
						<div class='div_ib3'>
							#".$masPi[$i][5]."<br/><br/></font>
						</div>
					</div>";
                    echo $irasoBlokas;
                }else
                    break;
            ?>
        </div>
        <div><p style="color:red">paveikslėlius_talpinti_galima_tik_prisijungus</p></div>
        <div style="float:clear"></div>

    </div>

    <!------------------------------------------------------------------>
    <div class="div_apatinis_blokas">

        <div class="div_ab1">
            <span>Naujausi paveikslėliai</span><br/>
            <?php
            //postai
            $masNi = imtiIrasus("*");
            //<tr><th>Pavadinimas</th><th>Kategorija</th><th>Autorius</th><th>Data</th></tr>";
            echo "<table>
				<tr><th>Pavadinimas</th><th>Kategorija</th><th>Autorius</th></tr>";
            $kiekRodyt = 4;
            for($i = sizeof($masNi)-1, $j = 0; $i >= 0; $i--, $j++)
                if($j < $kiekRodyt)
                    //<td><i>".$masNi[$i][1]."</i></td></tr>"
                    echo "<tr><td><i>".$masNi[$i][0]."</i></td>
						<td><i>".$masNi[$i][2]."</i></td>
						<td><i>".$masNi[$i][3]."</i></td>";
                else
                    break;
            echo "</table>";
            ?>
        </div>
        <!-- - - - - - - - - - - - - - - - -->
        <div class="div_ab2">
            <span>Pirmos kategorijos paveikslėliai</span><br/>
            <?php
            //pirma kategorija
            $kategorija = imtiPirmaKategorija();

            $masIrPagalKat = imtiIrasus($kategorija);
            echo "<b>Kategorija: </b>".$kategorija."</br>";
            echo "<table>
				<tr><th>Pavadinimas</th><th>Autorius</th><th>Data</th></tr>";
            $kiekRodyt = 5;
            for($i = sizeof($masIrPagalKat)-1, $j = 0; $i >= 0; $i--, $j++)
                if($j < $kiekRodyt)
                    echo "<tr><td><i>".$masIrPagalKat[$i][0]."</i></td>
						<td><i>".$masIrPagalKat[$i][2]."</i></td>
						<td><i>".$masIrPagalKat[$i][3]."</i></td></tr>";
                else
                    break;
            echo "</table>";
            ?>
        </div>
        <!-- - - - - - - - - - - - - - - - -->
        <div class="div_ab3">
            <span>Vardai</span><br/>
            <?php
            $masNv = NaujausiasVartotojas();
            /*echo "<b>Naujausiai užsiregistravęs vartotojas:</b></br>".
                $masNv[0].". Užsiregistravo: ".$masNv[1]."</br></br>";
            */
            $masNbv = NaujausiasBuvesVartotojas();
            echo "<b>Naujausiai buvęs prisijungęs narys:</b></br>".
                $masNbv[0].". Prisijungė: ".$masNbv[1]."</br>";
            ?>
        </div>
    </div>
</div>
</body>
</html>
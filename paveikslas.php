<?php error_reporting(0) ?>
<html>
<head>
    <meta charset="UTF-8"/>
    <style type="text/css">
        div{}
        .div_iraso_pagrindinis{width:665px; float:bottom; padding:20px; margin:50px auto 0 auto; background-color: #E5E4E2;}
        .div_prisijungimas{width:625px; height:100px; padding:20px; margin-bottom:20px; background-color: #F5F5F5;}

        .div_iraso_blokas{width:625px; height:320px; float:top; margin:0 auto; padding:20px; background-color: #F5F5F5;}
        .div_ib1{width:300px; height:300px; float:left; padding:10px; background-color: green;}
        .div_ib_tarpinis{width:290px; height:300px; float:left; margin-left:15px;}
        .div_ib2{width:270px; height:70px; float:left; padding:10px;}
        .div_ib3{width:270px; height:180px; float:left; padding:10px; margin-top:30px; font-weight:bold; background-color: #85BB65;}

        .div_komentaru_blokas{width:625px; float:top; margin:0 auto; padding:20px; background-color: #F5F5F5;}

        .div_komentaro_blokas{width:605px; float:top; margin:0 auto 5px auto; padding:5px; background-color: #C1D8F6;}
        .div_komentaro_pav{width:50px; height:50px; float:left; margin:0 5px auto 0; background-color: gray;}
        .div_komentaras_irasas{width:550px; float:left; margin:0 0 5px 0;}
        .div_kom_data{width:550px; clear: both; padding-left: 55px;  font-size:10px; font-style:italic; color:gray;}

        .div_kom_submit{width:605px; height: 30px; clear: both; font-size:10px; font-style:italic; color:darkred;}
        .div_kom_submitL{width:350px; height: 30px; float:left;}
        .div_kom_submitR{width:255px; height: 30px; float:left;}
        .div_kom_submitC{clear: both; height: 5px;}

        input{border: 0px; width: 90px;}
        .komentuoti_mygtukas{
            border: 0px;
            width: 100%;
            height: 100%;
            margin:0;
            background-color: #3E5996;
            border:1px solid darkblue;
            color: white;
            font-weight:bold;
            font-size:12px;
            font-family: Verdana, Arial;
        }
        .komentaras{border: 0px; margin:0; width:100%; height: 60px; text-align:left; direction:RTL;nonkeyup=rtl(this);}
        img{}.img_vienas{ width:300; height:300;}
        span{color: green; font-size:20px; font-weight:bold;}
        b{color: green;}
        #user{color: darkblue};
    </style>
</head>
<body>
<?php
session_start();
$vartotojas = null;
if(isset($_SESSION['vartotojas'])) {
    $vartotojas = $_SESSION['vartotojas'];
}

$id = $_GET['id'];

function imtiKomentarus($iraso_id){
    $mas = null;
    $rez = mysql_query("SELECT * FROM test.sistema_komentarai WHfacERE iraso_id = '$iraso_id'");
    $i = 0;

    while($row = mysql_fetch_array($rez))
    {
        $mas[$i][0] = $row['komentaras'];
        $mas[$i][1] = $row['data'];
        $mas[$i][2] = $row['iraso_id'];
        $mas[$i][3] = $row['autorius'];
        $i++;
    }
    return $mas;
}

$rez = mysql_query("SELECT * FROM test.sistema_irasai WHERE id = '$id'");
$row = mysql_fetch_array($rez);

$pavadinimas = $row['pavadinimas'];
$data = $row['data'];
$kategorija = $row['kategorija'];
$autorius = $row['autorius'];
$pav = $row['paveikslelis'];
$zinute = $row['post'];
$dydis = $row['paveikslelio_dydis'];

if(isset($_POST['prisijungti'])){
    $vardas = $_POST['vardas'];
    $psw = $_POST['psw'];

    $rez = mysql_query("SELECT * from test.sistema_vartotojai WHERE vardas = '$vardas'");
    $row = mysql_fetch_array($rez);
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
    if(isset($_SESSION['vartotojas']))
        $_SESSION['vartotojas'] = null;
    $_SESSION['vartotojas'] = null;
}

if(isset($_POST['komentuoti'])){
    $komentaras = stripslashes($_POST['komentaras']);
    $iraso_id = $id; //gloalus id
    $autorius = $vartotojas; //globalus id;
    mysql_query("INSERT INTO test.sistema_komentarai (komentaras, iraso_id, autorius) values ('$komentaras', '$iraso_id', '$autorius')");
}
?>
<div class='div_iraso_pagrindinis'>
    <a href="index.php">Grįžti į pagrindinį</a>
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

    <div class='div_iraso_blokas'>
        <div class='div_ib1'>
            <img src='<?php echo $pav ?>' alt='nera' class='img_vienas'/></br>
        </div>
        <div class='div_ib_tarpinis'>
            <div class='div_ib2'>
                <b>Pavadinimas: </b><?php echo $pavadinimas ?><br/>
                <?php /*<b>Data: </b><i><?php echo $data ?></i></br> */?>
                <b>Kategorija: </b><?php echo $kategorija ?></br>
                <b>Autorius: </b><?php echo $autorius ?></br>
                <?php /*<b>Paveikslo dydis(MB): </b><?php echo $dydis ?></br>*/ ?>
            </div>
            <div class='div_ib3'>
                <b>Komentaras:</b><br/>
                <?php echo $zinute ?>
            </div>
        </div>
    </div>
<?php /*
    <span>Komentarai:</span>
    <div class='div_komentaru_blokas'>

        <?php //mysql_query("INSERT INTO sistema_komentarai (komentaras, data, iraso_id, autorius) values ('lasdsadasdas', '2013-12-12 14:15:54', '43', 'xMx')");?>

        <?php
        $mas = imtiKomentarus($id);
        for ($i = 0; $i<sizeof($mas); $i++){  ?>
            <div class='div_komentaro_blokas'>
                <div class='div_komentaro_pav'>
                    <?php $ii = $i+1; echo "#".$ii; ?>
                </div>
                <div class='div_komentaras_irasas'>
                    <b id='user'><?php echo $mas[$i][3]; ?>: </b><?php echo $mas[$i][0]; ?>
                </div>
                <div class='div_kom_data'>
                    <?php echo $mas[$i][1]; ?>
                </div>
            </div>
        <?php }?>

        <?php if($vartotojas != null){ ?>
            <div class="div_komentaro_blokas">
                <div class="div_komentaro_pav">
                    *
                </div>
                <form action="" method="post">
                    <div class="div_komentaras_irasas">
                        <input type="text" name="komentaras" class="komentaras"/>
                    </div>
                    <div class="div_kom_submit">
                        <div class="div_kom_submitL">
                        </div>
                        <div class="div_kom_submitR">
                            <input type="submit" value="Komentuoti" name="komentuoti" class="komentuoti_mygtukas" />
                        </div>
                        <div class="div_kom_submitC">
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>

    </div>
*/ ?>
</div>
</body>
</html>
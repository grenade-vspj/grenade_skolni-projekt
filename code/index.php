<?php
require "conn.php";
require "opravneni.php";
require "functions.php";

$uri = $_SERVER['REQUEST_URI'];
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (strpos($url, 'index.php')) {
    $url = str_replace('index.php', '', $url);
}
if (substr($url, -1) !== '/') {
    $url = $url.'/';
}

 // nucéné příhlášeni
 if( $_SESSION['username']=="") {
     header("Location: prihlas.php");
     die();
 }

 // pro změnu hesla po přihlášení
 if( isset($_SESSION['zmena']) && $_SESSION['zmena']=="ANO") {
     header("Location: zmena.php");
     die();
 }

 // redirect pro redaktora
 if($_SESSION['prava']=="redaktor" && $_SESSION['cerstve_prihlaseni']==1) {
     header("Location: redaktor.php");
     die();
 }

 // redirect pro recenzenta
  if($_SESSION['prava']=="recenzent" && $_SESSION['cerstve_prihlaseni']==1) {
     header("Location: recenzent.php");
     die();
  }

?>

<!doctype html>
<html lang="en">
  <?php include "head.php" ?>
  <body>
    <?php include "top.php" ?>

<main role="main" class="container">

  <div class="starter-template">
    <h1>LOGOS POLYTECHNIKOS</h1>
    
  </div>
    <h2 class="mt-4">Vydané články</h2>
  
  <div class="row mb-3">
      <p><strong>LOGOS POLYTECHNIKOS je vysokoškolský odborný recenzovaný časopis</strong>, který slouží pro publikační aktivity akademických pracovníků Vysoké školy polytechnické Jihlava i jiných vysokých škol, univerzit a výzkumných organizací. Je veden na seznamu recenzovaných odborných a vědeckých časopisů <strong>ERIH PLUS - </strong>European Reference Index for the Humanities and the Social Sciences (https://dbh.nsd.uib.no/publiseringskanaler/erihplus/periodical/info?id=488187).</p>
      <p>Od roku 2010 do roku 2018 byl časopis vydáván čtyřikrát ročně v elektronické a tištěné podobě. Od roku 2019 vychází třikrát ročně v elektronické verzi. Redakční rada časopisu sestává z&nbsp;interních i externích odborníků. Funkci šéfredaktora zastává prorektor pro tvůrčí a projektovou činnost Vysoké školy polytechnické Jihlava. Funkce odpovědných redaktorů jednotlivých čísel přísluší vedoucím kateder Vysoké školy polytechnické Jihlava. Veškeré vydávané příspěvky prochází recenzním řízením a jsou pečlivě redigovány.&nbsp;</p>
      <p><strong>Tematické a obsahové zaměření časopisu</strong> reflektuje potřeby oborových kateder Vysoké školy polytechnické Jihlava. Na základě souhlasu odpovědného redaktora mohou katedry poskytnout publikační prostor i&nbsp;odborníkům bez zaměstnanecké vazby k Vysoké škole polytechnické Jihlava.</p>
      <p><strong>V časopise je možné publikovat</strong> odborné články, statě, přehledové studie, recenze a další typy odborných příspěvků v&nbsp;českém, slovenském a anglickém jazyce. Do recenzního řízení jsou přijímány příspěvky tematicky odpovídající zaměření časopisu a formálně upravené dle redakční šablony (viz níže).<br /><br /></p>
      <h4>Pro autory (přispěvatele)</h4>
      <p><a href="http://www.vspj.cz/soubory/download/id/7344">Pokyny pro přispěvatele<br /></a><a href="https://www.vspj.cz/soubory/download/id/4186" title="&#x160;ablona">Šablona<br /></a><a href="http://www.vspj.cz/soubory/download/id/7345">Recenzní řízení</a></p>
      <h5></h5>
      <h5>Jazyky, ve kterých lze publikovat:</h5>
      <p>angličtina, čeština a slovenština</p>
      <h5></h5>
      <h5>Termíny uzávěrek pro sběr příspěvků:<br /><br /></h5>
      <ul>
          <li>1/2020 - ošetřovatelství, porodní asistence a další zdravotnické obory (31. 12. 2019)</li>
          <li>2/2020 - ošetřovatelství, porodní asistence a další zdravotnické obory, sociologie, sport, psychologie, sociální práce (30. 4. 2020)</li>
          <li>3/2020 - ekonomika, management, marketing, statistika, operační výzkum, finanční matematika, pojišťovniství, cestovní ruch, regionální rozvoj, veřejná správa (31. 8. 2020)</li>
      </ul>
      <p>Pokud rozsah doručených příspěvků překročí kapacitu příslušného vydání, bude přijímání příspěvků ukončeno před uvedeným termínem.</p>
      <p>Adresa pro odesílání příspěvků:&nbsp;<em>logos&#x40;vspj.cz <br /></em>Kontaktní osoba: Bc. Zuzana Mafková: <a href="mai&#x6C;&#x74;&#x6F;&#x3A;zuzana.mafkova&#x40;vspj.cz">zuzana.mafkova&#x40;vspj.cz</a></p>
      <p>Adresa nakladatele: Vysoká škola polytechnická Jihlava, redakce LOGOS POLYTECHNIKOS, Tolstého 1556/16, 586 01 Jihlava<br /><br /><br /><strong>ISSN 2464-7551 (Online)</strong><br /><br /><em>Registrace MK ČR E 19390 – pro čísla z let 2010 až 2018 (vydávání tištěné verze časopisu bylo ukončeno). </em><br /><em>ISSN 1804-3682 (Print)&nbsp;– pro čísla z let 2010 až 2018 (vydávání tištěné verze časopisu bylo ukončeno).</em></p>
      <b>Šéfredaktor</b>
      doc. Ing. Zdeněk Horák, Ph.D. (Vysoká škola polytechnická Jihlava)<br><br>
      <b>Redakční rada</b><br />
      prof. PhDr. RNDr. Martin Boltižiar, PhD. (Univerzita Konštantína Filozofa v&nbsp;Nitre)<br />prof. RNDr. Helena Brožová, CSc. (Česká zemědělská univerzita v&nbsp;Praze)<br />doc. PhDr. Lada Cetlová, PhD. (Vysoká škola polytechnická Jihlava)<br />prof. Mgr. Ing. Martin Dlouhý, Dr. MSc. (Vysoká škola ekonomická v&nbsp;Praze)<br />prof. Ing. Tomáš Dostál, DrSc. (Vysoká škola polytechnická Jihlava)<br />doc. Ing. Jiří Dušek, Ph.D. (Vysoká škola evropských a regionálních studií)<br />doc. RNDr. Petr Gurka, CSc. (Vysoká škola polytechnická Jihlava)<br />Ing. Veronika Hedija, Ph.D. (Vysoká škola polytechnická Jihlava)<br />doc. Ing. Zdeněk Horák, Ph.D. (Vysoká škola polytechnická Jihlava)<br />Ing. Ivica Linderová, PhD. (Vysoká škola polytechnická Jihlava)<br />prof. MUDr. Aleš Roztočil, CSc. (Vysoká škola polytechnická Jihlava)<br />doc. PhDr. David Urban, Ph.D. (Vysoká škola polytechnická Jihlava)<br />doc. Dr. Ing. Jan Voráček, CSc. (Vysoká škola polytechnická Jihlava)<br />RNDr. PaedDr. Ján Veselovský, PhD. (Univerzita Konštantína Filozofa v&nbsp;Nitre)<br />doc. Ing. Libor Žídek, Ph.D. (Masarykova univerzita Brno)</p>
      <br/>
      
          
  </div>

</main>

    <?php include "footer.php" ?>
  </body>
</html>

<?php $conn -> close(); ?>
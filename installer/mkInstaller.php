<?php //##

$mver="2010040609";		// version, remove or comment to avoid upgrades
$dfinst='_mkInstaller.php';	// name of default config file to create installer
$lst="_mkI_last_inst_";		// prefix for last install file
$pwfn="_mkI_web_pass_";		// prefix for password when used from web server

$repo="http://mkInstaller.nisu.org/dwnl/";
	
error_reporting(E_ALL ^ E_NOTICE);

$milic= //{{{
'
Copyright (c) 2006-2009 Manuel Mollar
mm AT nisu.org http://mkInstaller.nisu.org/
This software is released under a MIT License.
http://www.opensource.org/licenses/mit-license.php
'; //}}}

$miids=mmIniStr('es');
mmSetLang($miids,'en');

// esto es la clave de la sustitución en los archivos parseados
$uniq=uniqid("mkI");

if (!$argv[0]) { // {{{ parte web
  header('Content-type: text/html; charset=ISO-8859-1');
  $ok=false;
  $dd=opendir(".");
  while ($f=readdir($dd))
    if (preg_match('/^'.preg_quote($pwfn).'.*\.php$/',$f)) {
      $ipwfn=$f;
      break;
    }
  if ($ipwfn)
    $pwpass=file_get_contents($ipwfn);
  if (substr($pwpass,0,10) == "<?php //!!") {
    eval("?>$pwpass<?php ");
    if ($wpass)
      $ok=($_REQUEST['pass'] == $wpass);
  }
  $html1='<h3>'.sprintf(__('Interface web de %s'),'<a href="http://mkinstaller.nisu.org/">mkInstaller</a>').'</h3>';
  if (!$ok) {
    $html2="<form method=post action=\"{$_SERVER['SCRIPT_NAME']}\">%s: <input type=password name=pass> <input type=submit value=\"".__('Proceder').'"></form></div>';
    if ($pwpass)
      if ($wpass)
        die($html1.sprintf($html2,__('Contraseña')));
      else
        die(sprintf(__('Error en %s'),$ipwfn));
    else
      if ($wpass=$_REQUEST['pass']) {
        fwrite($f=fopen("$pwfn$uniq.php",'w'),"<?php //!!\n\$wpass=".var_export($wpass,true).'; ?>'); fclose($f); chmod("$pwfn$uniq.php",0600);
	$ok=true;
      }
      else
        die($html.sprintf($html2,__('Nueva contraseña')));
  }
  if ($ok) {
    if (!($fout=$_REQUEST['fout'] or $xcml=$_REQUEST['xcml'])) {
      echo $html1.
        "<form target=ifr action\"={$_SERVER['SCRIPT_NAME']}\" method=post>".
        __('Línea de comandos:').' <input name=cml size=80><input type=submit name=xcml value="'.__('Proceder').
	'"><input type=hidden name=pass value="'.htmlspecialchars($wpass).'"><br>'.
        '<iframe name=ifr style="width: 98%; height: 400;"></iframe><br>';
      echo '<h4>'.__('Ficheros disponibles').'</h4>'.implode(' ',recDir(''));
      die('</div>');
    }
    $argv=array($_SERVER['SCRIPT_FILENAME']);
    $cml=preg_split('/ +/',$_REQUEST['cml']);
    if ($cml[0])
      $argv=array_merge($argv,$cml);
    $argc=count($argv);
    if ($fout)
      header("Content-type: application/octet-stream");
    else {
      header("Content-type: text/plain");
      $stderr=false;
    }
  }
} // }}}
else
  $stderr=fopen('php://stderr', 'w');

//{{{ funciones
$iact=0;
function logea($m='') {
  $sact='|/-\\';
  global $stderr, $xcml, $iact;
  if (!$m) {
    if ($xcml)
      return;
    $m=$sact[$iact]."\010";
    $iact++; $iact%=4;
    $br='';
  }
  else
    $br="\n";
  if ($stderr)
    fwrite($stderr,$m.$br);
  else if (isset($stderr)) {
    echo $m.$br;
    flush();
  }
}

foreach(array("gzdeflate"=>"zlib", uniqid=>"misc",
	"base64_encode"=>"URL",
	"preg_match"=>"Perl regex",
	"mysql_connect"=>"mysql",
	"pg_connect"=>"PostgreSQL") as $f => $p)
  if (!function_exists($f))
    logea(sprintf(__("La función %s no está disponible, revisa el modulo php %s\nEs posible que mkInstaller no funcione correctamente"),$f,$p));

$outd='';
function error($m='',$exi=true) {
  global $big, $outd;
  logea("\n\n".preg_replace('/^/m','	',$m)."\n");
  if ($big and $outd)
    @unlink($outd);
  $exi and exit(($m) ? 1 : 0);
}

function reInMk() {
  global $argv, $mver;
  $cert='-----BEGIN CERTIFICATE-----
	MIIFDzCCA/egAwIBAgIJAIWcWIpHeKlBMA0GCSqGSIb3DQEBBQUAMIG1MQswCQYD
	VQQGEwJFUzEdMBsGA1UECBMUQ29tdW5pdGF0IFZhbGVuY2lhbmExETAPBgNVBAcT
	CENhc3RlbGxvMRQwEgYDVQQKEwtOaXN1IGF0IFVKSTEdMBsGA1UECxMUU29mdHdh
	cmUgZGV2ZWxvcG1lbnQxGjAYBgNVBAMTEU5pc3UgY29kZSBzaWduaW5nMSMwIQYJ
	KoZIhvcNAQkBFhRtbS5jb2Rlc2lnbkBuaXN1Lm9yZzAeFw0wNzExMjcxNjQ0Mzha
	Fw0yNzExMjcxNjQ0MzhaMIG1MQswCQYDVQQGEwJFUzEdMBsGA1UECBMUQ29tdW5p
	dGF0IFZhbGVuY2lhbmExETAPBgNVBAcTCENhc3RlbGxvMRQwEgYDVQQKEwtOaXN1
	IGF0IFVKSTEdMBsGA1UECxMUU29mdHdhcmUgZGV2ZWxvcG1lbnQxGjAYBgNVBAMT
	EU5pc3UgY29kZSBzaWduaW5nMSMwIQYJKoZIhvcNAQkBFhRtbS5jb2Rlc2lnbkBu
	aXN1Lm9yZzCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBALqt9HT16BKx
	MKkhw2ZVS1cRYqZ9tRpCBh/2lSsmzIIqM/GyEpTAn+/UzPpYf/9JagaSwVrxOR6Q
	4WHPgPB+AFo31m5TpiwN1huQiiaOEya5ksCrkzLQ5ETOxtjVKLnCFGIIW76+aOVg
	oR+4IHphhvJAwSEpbrlY7OMUG7Qxk2+XWqSgNF2f9zmkL5wJhqXDjEgxRSDv7xWf
	SUgPTeKGeXQQrH+lMt/1UHO2fqA9QVEEilBYB7E1O7zfH/8XqnvyhcR7wEBoPC2q
	IDFsS3LmYnNqf+tRAY0VnxXbJ49U62PoTm0dy/0x+BmznLpXS1gzoWDwdovlYb4A
	PzZItJSDu9cCAwEAAaOCAR4wggEaMB0GA1UdDgQWBBSM7HEuv9nEqlviaRLn74M1
	/Czc9zCB6gYDVR0jBIHiMIHfgBSM7HEuv9nEqlviaRLn74M1/Czc96GBu6SBuDCB
	tTELMAkGA1UEBhMCRVMxHTAbBgNVBAgTFENvbXVuaXRhdCBWYWxlbmNpYW5hMREw
	DwYDVQQHEwhDYXN0ZWxsbzEUMBIGA1UEChMLTmlzdSBhdCBVSkkxHTAbBgNVBAsT
	FFNvZnR3YXJlIGRldmVsb3BtZW50MRowGAYDVQQDExFOaXN1IGNvZGUgc2lnbmlu
	ZzEjMCEGCSqGSIb3DQEJARYUbW0uY29kZXNpZ25AbmlzdS5vcmeCCQCFnFiKR3ip
	QTAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBBQUAA4IBAQCZoT3EqbUbgXdw9R9E
	lIXdjTh/4pSrlhYHOOmjNAhAmnEwZWEXnmiDxf3SXhJIbISfcm0tSWW3w6ybaLpH
	pSbwtCMDW3j+AJ1SjvufMg/DAzHLmpVVMVdUHyUM1pP0su8bPQSg5j+I02p9VyFJ
	DwCkQGPWw2/F+zQ5oM5C1BrSZHaPd+vHXDhcw3giYTVOzMPYitqsAFvvJ+0LMQvF
	XBdKTnO0M7imH1xtjZRPj/rEqm3Gx6KlLkhJWh2bBbr7J6sZM/0CYk34Gm3eYgOE
	G0zDXR4pBPG31iD2OAsU0dvt+pfvGfLbUWhu1qKeSYcsEcW6tEr5YviOQdUyNtXO
	Evtp
-----END CERTIFICATE-----';
  $f=fopen($argv[0],"rb");
  $b=fread($f,10);
  fclose($f);
  if ($b != '<?php //##')
    return;
  if ($ch=@file_get_contents("http://mkinstaller.nisu.org/index.php.en")) {
    preg_match_all('+<li><tt>([0-9]{8})</tt>(:.*)+',$ch,$ma);
    $ch='';
    foreach($ma[1] as $i => $v)
      if ($v.'23' > $mver)
        $ch.="$v{$ma[2][$i]}\n";
  }
  $ch and $ch=__('Cambios').":\n$ch";
  logea($ch.__('¿Desea actualizarla ahora?'));
  if (strcasecmp(fread(fopen('php://stdin', 'r'),1),__('s')))
    return;
  logea(__('Descargando ...'));
  if ($url=@file_get_contents("http://expire.nisu.org/?prg=mkInstaller.php&url=yes") and
      $nw=@file_get_contents($url) and substr($nw,0,10) == '<?php //##' and
      $sig=@file_get_contents("$url.sig")) {
    if (function_exists("openssl_error_string")) {
      if (!openssl_public_decrypt(base64_decode($sig),$hash,openssl_pkey_get_public($cert)))
        error(__('Fallo en firma ').openssl_error_string());
      if (sha1($nw) != $hash)
        error(__('Fallo en contenido'));
    }
    else
      logea(__('*** No puedo comprobar la firma, no hay soporte OpenSSL'));
    logea(sprintf(__('Actualizando %s'),$argv[0]));
    fwrite(fopen($argv[0],"wb"),$nw);
    die(__('Instalada')."\n");
  }
  else
    error(__('Fallo en la descarga'));
}

function recDir($dir) {
  $d=opendir("./$dir");
  $fs=array();
  logea();
  while ($f=readdir($d)) {
    if ($f == '.' or $f == '..')
      continue;
    if (is_dir("$dir$f"))
      $fs=array_merge($fs,recDir("$dir$f/"));
    else
      $fs[]="$dir$f";
  }
  return $fs;
}

function mkdirR($dir, $mode = 0755) {
  if (is_dir($dir) || (@mkdir($dir) && @chmod($dir,$mode))) return true;
  if (!mkdirR(dirname($dir),$mode)) return false;
  return (@mkdir($dir) && @chmod($dir,$mode));
}

/*
function creadir($f) {
  **** en windows el touch de un "directorio/." crea un fichero vacio en lugar de fallar
  if (!@touch($f) // por el safe mode que no me deja comprobar directorios
  *** realmente el safe mode peta por tos los laos si el script no es propiedad del user apache
    and !mkdirR($d=dirname($f)))
    error(sprintf(__('No puedo crear el directorio %s'),$d));
}
*/

function creadir($f) {
  if (!mkdirR($d=dirname($f)))
    error(sprintf(__('No puedo crear el directorio %s'),$d));
}

function cojebuf($nfil) {
  global $ncte;
  $f=@file_get_contents($nfil);
  if ($f === false)
    error(sprintf(__('No puedo cargar el fichero %s'),$nfil),$ncte);
  else
    logea(sprintf(__("Leo el fichero %s"),$nfil));
  return $f;
}

function filtra($cfil,$nfil,$bf) {
  global $uniq,$ntce;
  if (!$bf)
    return false;
  if (!$cfil)
    return $bf;
  $bcfil=cojebuf($cfil);
  ob_start();
  if (!@eval('return true; function '.($fcfil=$uniq.rand().rand()).'($inbuff,&$outbuff) {?>'.$bcfil.'<?php }') and
      !@eval('return true; function '.($fcfil=$uniq.rand().rand()).'($inbuff,&$outbuff) {?>'.$bcfil.'}'))
    error(sprintf(__("*** La carga de %s ha producido un error sintáctico"),$cfil).ob_get_clean(),$ncte);
  if ($fcfil($bf,$nbf)) {
    logea(sprintf(__("Parseado %s con %s"),$nfil,$cfil));
    return $nbf;
  }
  else {
    logea(sprintf(__("*** La ejecución de %s ha producido un error, %s no filtrado, sin cambios"),$cfil,$nfil));
    return $bf;
  }
}

function cojeper($nfil) {
  $pe=@stat($nfil);
  return array($pe['mode'],$pe['mtime']);
}

function qtab($b) {
  return preg_replace('/^	/m','',$b);
}

function intW($st) {
  global $tmpI, $cmpr;
  if ($cmpr)
    $st=base64_encode(gzdeflate($st));
  $po=ftell($tmpI);
  fwrite($tmpI,sprintf("%12d",strlen($st)));
  fwrite($tmpI,$st);
  return($po);
}

function doutW($st) {
  global $cmpr, $tby, $twr, $dout, $big;
  $tby+=strlen($st)+12;
  $twr++;
  if ($cmpr) {
    $st=gzdeflate($st);
    if (!$big)
      $st=base64_encode($st);
  }
  fwrite($dout,sprintf("%12d",strlen($st)));
  fwrite($dout,$st);
}

function myexp($v) {
  return preg_replace("/[\n ]+/","",var_export($v,true));
}

function recorre($f,$n) {
  $fs=array($f);
  if (!$n)
    return $fs;
  $h=opendir($f);
  logea();
  while ($ff=readdir($h))
    if ($ff != '.' and $ff != '..') {
      $ff="$f/$ff";
      if (is_dir($ff))
        $fs=array_merge($fs,recorre($ff,$n-1));
      else
	$fs[]=$ff;
  }
  return $fs;
}

function parseopt($opt,$opts) {
  $cu=0;
  foreach($opts as $iopt)
    if (substr($iopt,0,strlen($opt)) == $opt) {
      $opt1=$iopt;
      $cu++;
    }
  if ($cu == 0)
    error(__('Las opciones válidas son: ').implode(' ',$opts).'. '.
	  sprintf(__("Opción desconocida '%s'"),$opt));
  if ($cu > 1)
    error(__('Opción ambigua').$opt);
  return $opt1;
}

//}}}
// {{{ inicial
//!
$peaso=1000000;
//!
$peasoq=100000;
//!
$mxrw=1000;

$cmpr=true;
$tby=$twr=0;
$sample=false;
$curopt=array();
$nops=array();
$buf=array();
$quit=array();
$expenquit=false;
$cdefbdd=array();
$reembuf=false;
$big=false;
$dtod='';
$vUrl=''; $ver='';
$reco=false; $full=false;
$opts=array('big', 'chr', 'cip', 'css', 'cte', 'drp', 'ext', 'err', 'fsm', 'idb', 'ili', 'inf', 'key', 'lic', 'nam', 'ngz', 'nld', 'nru', 'nsv', 'out', 'ses', 'pwd', 'sim', 'ski', 'smo', 'tpl', 'ver');
$mods=array('copy', 'exclude', 'filter', 'jump', 'load', 'norun', 'parse', 'run', 'tree');
$skipv=false;
// }}}
// {{{ Argumentos
$ia=1;
$cont=true;
while ($cont) {
  $para=substr($argv[$ia],0,2);
  $ia++;
  switch ($para) {
    case '-h':
      readfile('http://mkinstaller.nisu.org/help.txt');
      die();
    case '-c':
      if ($inst)
	error(__('Sólo un fichero de instalación'));
      $inst=$argv[$ia];
      $ia++;
      break;
    case '-D':
      reInMk();
      break;
    case '-s':
      $sample=true;
      break;
    case '-v':
      $skipv=true;
      logea(sprintf(__('Versión aceptada: %s'),$mver));
      break;
    case '-r':
      $reco=true;
      $ndi=$argv[$ia];
      $ia++;
      if (!$ndi or !@mkdirR($ndi))
	error(sprintf(__("No puedo crear el directorio %s"),$ndi));
    case '-J':
      $dbnwl=true;
    case '-I':
      $full=true;
    case '-i':
      $info=true;
      $nf=$argv[$ia];
      break;
    case '-f':
      $opt=$argv[$ia];
      $opt1=parseopt($opt,$mods);
      $opt1=substr($opt1,0,1);
      $ia++;
      $nfil=$argv[$ia];
      $ia++;
      if ($opt1 == 'e') {
        list($rege,$dum)=explode('==',$nfil);
	if ($nfil != $rege and !$dum) {
	  $expenquit=true; // expensive
	  $quit[$rege]='p';
	}
	else
	  $quit[$nfil]='f';
	break;
      }
      if ($opt1 == 't') {
        $recu=$nfil; $ndir=$argv[$ia]; $ia++;
	if (!is_dir($ndir)) {
          list($ndir,$rege)=explode("%%", $ndir);
	  if ($rege)
	    list($regv,$rege)=explode('/',$rege);
	}
	if (!is_dir($ndir))
          list($ndir,$relo)=explode("==", $ndir);
	if (!is_dir($ndir))
	  list($ndir,$cfil)=explode("++", $ndir);
        if (!is_dir($ndir))
	  error(sprintf(__("Para usar con '%s', '%s' debe ser un directorio"),$opt,$ndir));
	if ($recu == 0)
	  $recu=100000;
	foreach(recorre($ndir,$recu) as $nfil) {
	  if ($buf[$nfil]) // ignora repeticiones
	    continue;
	  if (is_dir($nfil))
	    $buf[$nfil]=array('d'=>true);
	  else if (is_link($nfil))
	    $buf[$nfil]=array('l'=>readlink($nfil));
	  else
	    $buf[$nfil]=array();
	  if ($cfil)
	    $buf[$nfil]['f']=$cfil;
          if ($relo)
	    $buf[$nfil]['t']=$relo.substr($nfil,strlen($ndir));
	  if ($rege)
	    $buf[$nfil]['c']=array('v'=>$regv,'e'=>$rege);
	}
      }
      else {
        if (!file_exists($nfil))
          list($nfil,$rege)=explode("%%", $nfil);
        if (!file_exists($nfil))
          list($nfil,$relo)=explode("==", $nfil);
        if (!file_exists($nfil))
          list($nfil,$cfil)=explode("++", $nfil);
	if ($buf[$nfil])
	  break;
        if ($opt1 != 'c')
	  if (is_link($nfil) or is_dir($nfil))
	    error(sprintf(__("Para usar con '%s', '%s' debe ser un fichero ordinario"),$opt,$nfil));
        if (is_dir($nfil))
	  $buf[$nfil]=array('d'=>true);
        else {
	  if (is_link($nfil))
	    $buf[$nfil]=array('l'=>readlink($nfil));
	  else
	    $buf[$nfil]=array();
	  if ($opt1 == 'j') {
	    $buf[$nfil]['j']=$argv[$ia];
	    $buf[$nfil]['x']='j';
	    $ia++;
	  }
	  else {
	    $p=(($opt1 == 'p') or ($opt1 == 'f') or ($opt1 == 'r') or ($opt1 == 'n'));
	    $x=((($opt1 == 'r') or ($opt1 == 'f') or ($opt1 == 'l') or ($opt1 == 'n')) ? $opt1 : false); // duda: == 'n' ?????
	    $x and $buf[$nfil]['x']=$x;
	    $p and $buf[$nfil]['p']=$p;
	  }
	  if ($cfil)
	    $buf[$nfil]['f']=$cfil;
        }
        if ($relo)
	  $buf[$nfil]['t']=$relo;
	if ($rege) {
	  list($regv,$rege)=explode('/',$rege);
	  $buf[$nfil]['c']=array('v'=>$regv,'e'=>$rege);
	}
      }
      break;
    case '-g':
      $fil=$argv[$ia];
      if ($fil) {
	if ($ff=@file_get_contents("$repo/$fil")) {
	  if (file_exists($fil))
	    error(sprintf(__('%s ya existe'),$fil));
	  fwrite($h=fopen($fil,'w'),$ff); fclose($h);
	  printf(__("Descargado %s\n"),$fil);
	}
	else
	  error(sprintf(__('Fallo en la descarga de %s')),$fil);
      }
      else {
	echo @file_get_contents($repo);
      }
      die();
    case '-o':
    case '-n':
      $opt=$argv[$ia];
      $opt1=parseopt($opt,$opts);
      $ia++;
      if ($para == '-n') {
        $nops[$opt1]=true;
        break;
      }
      switch ($opt1) {
	case 'big':
        case 'out':
          $curopt['big']=($opt1 == 'big');
          $curopt['out']=$argv[$ia];
	  $ia++;
	  break;
	case 'ext':
	  list($curopt['ext'],$curopt['oud'])=explode('==',$argv[$ia]);
	  $ia++;
	  break;
	case 'err':
	  $curopt['err']=$argv[$ia];
          $ia++;
          break;
	case 'tpl':
	  if ($plan)
	    error(__('Sólo un nombre de plantilla, deben existir: en-fichero , es-fichero ...'));
	case 'chr': case 'css': case 'del': case 'fsm': case 'ili': case 'key': case 'lic': case 'nam': case 'pwd': case 'sim': case 'smo': case 'tpl': case 'ver':
          $curopt[$opt1]=$argv[$ia];
	  $ia++;
	  break;
	default:
	  $curopt[$opt1]=true;
	  break;
      }
      break;
    case '-u':
      $usim=true;
    case '-U':
      $dtod=$argv[$ia];
      $ia++;
      break;
    case '-d':
      $cdefbdd1=$argv[$ia];
      if ($cdefbdd1 == 'help')
        error(__("-d host==user==passw==database[==type[:port][==[+]file]]\nCada campo: host, port, database, usuario y pass es, o bien :valor, o bien variable\nSi se especifica tipo y fichero, tipo debe ser mysql o pgsql"));
      $cdefbdd[]=$cdefbdd1;
      $ia++;
      break;
    case '-X':
      $istx=true;
    default:
      $cont=false;
  }
}
// }}}

// {{{ -r -i -I -J
if ($info) {
  if (!$nf) {
    eval('?>'.preg_replace('/header\(.*/','',cojebuf(($inst) ? $inst : $dfinst)).'<?php ');
    if (!($nf=$myopt['out']))
      $nf="php://stdin";
  }
  else if ($nf == '-')
    $nf="php://stdin";
  else if (!file_exists($nf))
    error(sprintf(__("El fichero %s no existe"),$nf));
  $argv[0]=$nf;
  $cml=true;
  eval('?>'.preg_replace('/header\(.*/','',@fread(@fopen($nf,'r'),25000)).'?>');
  // ---MARK RUNTIME -I---
  function muestra($li,$n,$bu,$lo) {
    printf("%${li}s => %s ... %d bytes\n",
      substr($n,-$l),
      substr(preg_replace('/[^\x20-\x3C\x3E-\x7E\x09]/e', 'sprintf( "=%02x", ord ( "$0" ) ) ;',
        substr($bu,0,50)),0,50),$lo);
  }
  function nobin($s) {
    return preg_replace('/[^\x20-\x7E\x09\x0A\x0D]/e', 'sprintf( "=%02x", ord ( "$0" ) ) ;',$s);
  }
  if ($datafile)
    if (file_exists(dirname($nf)."/".$datafile))
      dataOpen(dirname($nf)."/".$datafile);
    else
      dataOpen($datafile);
  else
    if (function_exists(dataOpen))
      dataOpen($nf);
    else
      error(sprintf(__('El fichero %s no existe o no es un instalador'),$nf));
  if ($flic=$dopt['lic']) {
    echo "-----".__('Inicio de ').__('licencia')."-----\n";
    if ($reco) {
      preg_match("+(^|.*/)..(-[^/]*)$+",$dopt['lic'],$ma);
      $dpnom=$ma[1]; $pnom=$ma[2];
    }
    foreach($lics as $lg => $po) {
      $f=tkInBuff($po); $ln=strlen($f);
      if ($reco) {
	creadir("$ndi/$dpnom$lg$pnom");
	fwrite(fopen("$ndi/$dpnom$lg$pnom","w"),$f);
      }
      else if ($full)
	echo " -----$lg ($ln bytes) -----\n".nobin($f);
      else
	muestra(2,$lg,$f,$ln);
    }
    echo "\n-----".__('Fin de ').__('licencia')."-----\n";
  }
  echo "-----".__('Inicio de ').__('ficheros')."-----\n";
  $l=0; $nms=array();
  foreach($files as $if => $b) {
    $n=$b['n'];
    if (!$n) {// antiguas versiones
      $n=$if;
      $files[$if]['n']=$n;
    }
    $l=min(50,max($l,strlen($n)));
    $nn=$n;
    if ($nms[$n]) {
      $idx=0;
      while ($nms[$nn]) {
        $nn="$n-$idx";
	$idx++;
      }
      $files[$if]['n']=$nn;
      $files[$if]['t']=$n;
    }
    $nms[$nn]=true;
  }
  foreach(array('l','f','r','j') as $ty)
    $ejec[$ty]=array();
  foreach($files as $if => $b) {
    $n=$b['n'];
    if ($l=$b['l']) {
      if ($reco)
	symlink($l,"$ndi/$n");
    }
    else if ($b['d']) {
      if ($reco)
	creadir("$ndi/$n/.");
    }
    else {
      if ($reco)
	creadir("$ndi/$n");
      if ($b['p']) {
	if ($b['x']) {
	  if ($b['x'] == 'r' or $b['x'] == 'f') {
	    if ($b['x'] == 'r')
	      $f=tkBuff();
	    else
	      $f=tkInBuff($b['po']);
	    foreach($dvars as $va)
	      $f=str_replace("$uniq.$".$va["va"].".$uniq","''",$f);
	    $ejec[$b['x']][]=array('n'=>$n,'f'=>$f);
	  }
	  $f=false;
	}
	else {
	  $f=tkBuff();
	  foreach($dvars as $va)
	    $f=str_replace("$uniq.$".$va["va"].".$uniq","''",$f);
	  if ($reco) {
	    fwrite(fopen($nf="$ndi/$n","w"),$f);
	    @chmod($nf,$b["a"][0]);
            @touch($nf,$b["a"][1]);
	  }
	}
	$ln=strlen($f);
      }
      else if ($b['x'])
	$f=false;
      else {
	$f='';
	$ta=$b['ta'];
	$ln=$ta;
	if ($reco)
	  $h=fopen($nf="$ndi/$n","w");
	while (true) {
	  $bu=tkBuff();
	  if ($reco)
	    fwrite($h,$bu);
	  else
	    $f.=$bu;
	  $ta-=strlen($bu);
	  if (!$ta)
	    break;
	}
	if ($reco) {
	  @chmod($nf,$b["a"][0]);
          @touch($nf,$b["a"][1]);
	}
      }
      if (!$reco and ($f !== false))
	if ($full) {
	  $nb=nobin($f);
	  if (strlen($f)*1.5 < strlen($nb))
	    $nb=__(' *** Binario ***');
	  echo " -----".__('Inicio de ').$n." ($ln bytes)-----\n".
	    "$nb\n -----".__('Fin de ').$n."-----\n";
	}
	else
	  muestra($l,$n,$f,$ln);
    }
  }
  echo "-----".__('Fin de ').__('ficheros')."-----\n";
  echo "-----".__('Inicio de ').__('auto-ejecutables')."-----\n";
  foreach($files as $if => $b)
    if ($b['x'] == 'l' or $b['j'])
      $ejec[$b['x']][]=array('n'=>$b['n'],'f'=>tkInBuff($b['po']));
  foreach(array('l'=>__('carga'),'f'=>__('filtros'),'r'=>__('finales'),'j'=>'jmp') as $ty => $la) {
    echo " -----".__('Inicio de ')."$la-----\n";
    foreach($ejec[$ty] as $f)
      if ($reco)
	fwrite(fopen("$ndi/".$f['n'],"w"),$f['f']);
      else if ($full) 
	echo "  -----".__('Inicio de ')."?-----\n".nobin($f['f'])."\n  -----".__('Fin de ')."?-----\n";
      else
	muestra(0,'?',$f['f'],strlen($f['f']));
    echo " -----".__('Fin de ')."$la-----\n";
  }
  echo "-----".__('Fin de ').__('auto-ejecutables')."-----\n";
  echo "-----".__('Inicio de ').__('plantillas y CSS')."-----\n";
  if ($reco)
    if ($dopt['tpl']) {
      preg_match("+(^|.*/)..(-[^/]*)$+",$dopt['tpl'],$ma);
      $dpnom=$ma[1]; $pnom=$ma[2];
    }
    else {
      $pnom="-tpl-$uniq.html";
      $dpnom="";
    }
  foreach($plans as $lg => $po) {
    $f=tkInBuff($po); $ln=strlen($f);
    if ($reco) {
      creadir("$ndi/$dpnom$lg$pnom");
      $f=preg_replace('/(<img[^>]*src=")\?img=([0-9a-f]*")/','\1img-\2',$f); // inst viejo
      $f=preg_replace('/(<img[^>]*src=")\?img=([0-9a-f]*")/e','"\1img-\2.".$imgs[\2]["t"]',$f); // inst nuevo
      fwrite(fopen("$ndi/$dpnom$lg$pnom","w"),$f);
    }
    else if ($full)
      echo " -----$lg ($ln bytes) -----\n".nobin($f);
    else
      muestra(2,$lg,$f,$ln);
  }
  $f=tkInBuff($css); $ln=strlen($f);
  if ($reco) {
    if (!$cnom=$dopt['css'])
      $cnom="CSS-$uniq.css";
    creadir("$ndi/$cnom");
    fwrite(fopen("$ndi/$cnom","w"),$f);
    if ($imgs) {
      foreach($imgs as $im =>$img) {
	creadir("$ndi/{$dpnom}img-$im");
	if (is_array($img)) // inst nuevo
	  fwrite(fopen("$ndi/{$dpnom}img-$im.{$img['t']}","w"),tkInBuff($img['i']));
	else
	  fwrite(fopen("$ndi/{$dpnom}img-$im","w"),tkInBuff($img));
      }
    }
  }
  else if ($full)
    echo " -----CSS ($ln)-----\n".nobin($f);
  else
    muestra(0,'css',$f,$ln);
  echo "-----".__('Fin de ').__('plantillas y CSS')."-----\n";
  echo "-----".__('Inicio de ').__('bases de datos')."-----\n";
  foreach($dsdb as $idbs => $dbs)
    foreach($dbs as $idb => $db)
      if (is_array($db)) {
	echo "-----".__('Base de datos ').(($db['vdb']) ? __('var ').$db['vdb'] : $db['db'])."-----\n";
	if ($reco) {
	  $dsdb[$idbs][$idb]['dm']=true;
	  if (!$fnom=$db['fi'])
	    $dsdb[$idbs][$idb]['fi']=($fnom="dump-$uniq.sql");
	  creadir("$ndi/$fnom");
	  $h=fopen("$ndi/$fnom","w");
	  for ($i=0; $i<$db['no']; $i++) {
	    $bu=tkBuff();
	    if (!preg_match('/;[\s\n]*$/',$bu))
	      $bu.=';';
	    fwrite($h,"\n$bu\n");
	  }
	  fclose($h);
	}
	else if ($full)
	  for ($i=0; $i<$db['no']; $i++) {
	    $bu=tkBuff();
	    printf("%8d bytes => ",strlen($bu));
	    if ($dbnwl)
	      echo "\n".str_replace(",",",\n",$bu)."\n";
	    else
	      echo "\n$bu\n";
	  }
	else {
	  $pdbs=array();
	  for ($i=0; $i<$db['no']; $i++) {
	    $bu=tkBuff();
	    $pdbs[preg_replace('/\(.*/s','',$bu)]+=strlen($bu);
	  }
	  foreach($pdbs as $mg => $ln)
	    printf("%s ... %d bytes\n",$mg,$ln);
	}
	unset($dsdb[$idbs][$idb]['no']);
      }
  echo "-----".__('Fin de ').__('bases de datos')."-----\n";
  echo "-----".__('Inicio de ').__('variables')."-----\n";
  if ($reco) { // meto todas las vars en un fichero 'n'
    $h=fopen("$ndi/vars-$uniq.php","w");
    fwrite($h,"<?php\n");
    foreach($dvars as $v)
      fwrite($h,"//!\n\$$v[va]='';\n");
    fwrite($h,"?>\n");
    fclose($h);
    $files[]=array('n'=>"vars-$uniq.php",'p'=>true,'x'=>'n');
  }
  $vars="<?php //!!\n".
    '$defvars='.var_export($dvars,true).";\n".
    '$svbufs='.var_export($files,true).";\n".
    '$defbdds='.var_export($dsdb,true).";\n";
  echo "-----".__('Fin de ').__('variables')."-----\n";
  if ($reco) {
    fwrite(fopen("$ndi/_mkInstaller.php","w"),$vars.'$myopt='.var_export($dopt,true).";\n?>");
  }
  else
    echo $vars;
  // ---MARK RUNTIME -I---
  die();
}
// }}}

// {{{ Nueva version de mkInstaller?
if (!$dtod and !$skipv and !$cml and $mver)
  switch (@file_get_contents("http://expire.nisu.org/?prg=mkInstaller.php&ver=$mver")) {
    case 'UP': logea(__('Esta versión de mkInstaller tiene problemas graves, debe ser actualizada')); reInMk(); die();
    case 'NW': logea(__('Disponible una nueva versión de mkInstaller')); reInMk(); break;
    case 'RE': logea(__('Disponible una nueva versión de mkInstaller, puede usar -D para instalarla')); break;
  }
// }}}

if (!$inst)
  $inst=$dfinst;

// {{{ resto de argumentos: nombres -- nombres
$parse=true;
$reembuf=($argc >= $ia);
for($i=$ia-1; $i<$argc; $i++) {
  if ($argv[$i] == '--')
    $parse=false;
  else {
    $nfil=$argv[$i];
    if ($buf[$nfil])
      continue;
    if (is_link($nfil))
      $buf[$nfil]=array('l'=>readlink($nfil));
    else if (is_dir($nfil))
      $buf[$nfil]=array('d'=>true);
    else
      $buf[$nfil]=array('p'=>$parse);
  }
}
//}}}

// {{{ carga del fichero de instalación
$defvars=array();
$myopt=array();
$svbufs=array();
$defbdds=array();
if (file_exists($inst)) {
  // debe ser código válido php y con la marca
  $cinst=file_get_contents($inst);
  if (substr($cinst,0,10) != "<?php //!!")
    error(sprintf(__("El fichero '%s' no es válido"),$inst));
  eval("?>$cinst<?php ");
  if (!($defvars or $defbdds or $svbufs))
    error(sprintf(__("Problemas en el código fuente de %s, edítalo a mano"),$inst));
  if ($usim) {
    $defbdds=array();
    $svbufs=array();
  }
}
else
  $sample=true;
// }}}

// {{{ nuevos archivos ? + eliminados
if (!$reembuf) {
  foreach($svbufs as $nfil => $b)
    if (!$buf[$nfil]) // preferencia -f copy y -f parse
      $buf[$nfil]=$b;
}

foreach($buf as $nfil => $b) {
  if ($quit[$nfil] == 'f') {
    unset ($buf[$nfil]);
    continue;
  }
  if ($expenquit) {
    $match=false;
    foreach($quit as $rege => $m)
      if ($m == 'p' and preg_match($rege,$nfil)) {
	$match=true;
	break;
      }
    if ($match)
      unset ($buf[$nfil]);
  }
}
// }}}

/* porque hacia esto??????
// reescribo $svbufs
foreach($buf as $nfil => $b) {
  $svbufs[$nfil]=$b;
}
en lugar de esto: */
$svbufs=$buf;

// {{{ mezclo opciones
foreach($curopt as $opt => $val)
  $myopt[$opt]=$val;
foreach($nops as $opt => $dum)
  unset($myopt[$opt]);
// }}}

// {{{ ops muy usadas
// $big la uso mucho
if ($dtod) {
  $big=false;
}
else
  $big=$myopt['big'];

// 'ngz' idem
$cmpr=!$myopt['ngz'];
$ncte=!$myopt['cte'];
//}}}

// {{{ version actual instalador
if ($vUrl=$myopt['ver']) {
  $ver=trim(file_get_contents($vUrl));
  if (!$ver)
    error(sprintf(__('No puedo obtener la versión actual a partir de %s'),$vUrl),$ncte);
  else
    logea(sprintf(__('Versión actual obtenida: %s'),$ver));
}
// }}}

// {{{ código de lectura de bufers
// el lio del trim es para prevenir errores internos mios
$deftk=
	'function tkInBuff($po) {
	  global $fin, $simu, $pidi;
	  if (@fseek($fin,$po+$pidi) !== 0)
	    salir(st("Eali"));
	  if ((strlen($l=@fread($fin,12)) != 12) or
	      (trim($l) !== strval(intval($l))))
	    salir(st("Eali"));
	  if (strlen($b=@fread($fin,$l)) != $l)
	    salir(st("Eali"));'.(($cmpr) ? '
	  $b=@gzinflate(base64_decode($b));' : '').'
	  if ($b === false)
	    salir(st("Eali"));
	  if ($simu)
	    usleep($simu);
	  return $b;
	}
';
// }}}

// fichero temporal para lo interno
$tmpI=tmpfile();

$outf=$myopt['out'];

// {{{ big: preparo el fichero, si no: temporal; preparo codigo lectura
if ($big) {
  if (!($outd=$myopt['oud']))
    $outd=$outf."_dat";
  creadir($outd);
  if (!$dout=@fopen($outd,"wb"))
    error(sprintf(__("No puedo crear el fichero %s"),$outd));
  $dataf=
'
	$datafile=$_REQUEST["data"] or $datafile='.var_export((($myopt['ext']) ? $myopt['ext'] : basename($outd)),true).';
';
  $deftk.=
'	function lee($t) {
	  global $fdd;
	  $f=""; $cf=0;
	  while ($t > 0) {
	    $ff=fread($fdd,$t);
	    $l=strlen($ff);
	    if (!$l) {
	      $cf++;
	      if ($cf == 100)
	        salir(st("Eale"));
	    }
	    else
	      $cf=0;
	    $f.=$ff;
	    $t-=$l;
	  }
	  return $f;
	}
	function tkBuff() {
	  global $tby, $twr, $simu;
	  $f='.(($cmpr) ? '@gzinflate(' : '').'lee(lee(12))'.(($cmpr) ? ')' :'').';
	  if ($f === false)
	    salir(st("Eale"));
	  $tby+=12+strlen($f);
	  $twr++;
	  if ($simu)
	    usleep($simu);
	  return $f;
	}
	function dataOpen($f) {
	  global $fdd;
	  $fdd=@fopen($f,"rb") or salir(sprintf(st("Npae"),$f));
	  return true;
	}
	 
';
}
else {
  $dout=tmpfile();
  $dataf='';
  $deftk.=
'	function tkBuff() {
	  global $fdd, $tby, $twr, $simu;
	  if ((strlen($l=fread($fdd,12)) != 12) or
	      (trim($l) !== strval(intval($l))))
	    salir(st("Eale"));
	  if (strlen($b=fread($fdd,$l)) != $l)
	    salir(st("Eale"));'.(($cmpr) ? '
	  $b=@gzinflate(base64_decode($b));' : '').'
	  if ($b === false)
	    salir(st("Eale"));
	  $tby+=12+strlen($b);
	  $twr++;
	  if ($simu)
	    usleep($simu);
	  return $b;
	}
	function dataOpen($f) {
	  global $fdd, $pidd;
	  $fdd=@fopen($f,"rb") or salir(sprintf(st("Npae"),$f));
	  fseek($fdd,$pidd);
	  return true;
	}

';
}
// }}}

// {{{ parsing de ficheros
// cojo variables en ficheros y escribo en $dout
$vars=array();
// tambien averigua los idiomas mmGetText de los fuentes si los hay
// todos los fuentes deben tener el mismo idioma por defecto
$ftids=array();
// guardo mis traducciones
$mylang=$lang_lang;
// amos palla
$bu2=array(); $ib2=-1; $tlcem=0; $tcem=0; $tsfm=false;
foreach($buf as $nf =>$b) {
  if ($b['t']) {
    if ($b['l'] and is_file($b['l'])) {
      unset($b['l']);
    }
    $nbu2=$b['t'];
    unset($b['t']);
  }
  else {
    $nbu2=$nf;
  }
  if ($b['j'])
    $nbu2="jmp";
  else if ($b['x'])
    $nbu2="autorun";
  if (strpos($nbu2,'/') !== false)
    $tsfm=true;
  $b['n']=$nbu2;
  $ib2++;
  $bu2[$ib2]=$b;
  if (!$b['l'])
    $bu2[$ib2]['a']=cojeper($nf);
  if ($b['p']) { // {{{ es parseable
    if ($b['d'] or $b['l']) {
      error(sprintf(__("Este tipo de fichero no es parseable: %s"),$nf),$ncte);
      continue;
    }
    if (!$bf=cojebuf($nf))
      continue;
    if ($nf == $nbu2 and !$b['x'] and (realpath($nf) != getcwd()."/$nf"))
      logea(sprintf(__("** La inclusión de nombres de fichero no-relativos puede ser peligrosa: %s"),$nf));
    if (!$bf=filtra($b['f'],$nf,$bf))
      continue;
    // limpio zonas de código oculto
    $bf=preg_replace('+(\s*)//\*(.*?)//\*.*?$+mes',
    	'" // ".(($lcem=count(explode("\n",\'\1\2\'))-1 and $tlcem+=$lcem or $tcem++) ?
	sprintf(__("%d líneas de código de depuración eliminadas por mkInstaller"),$lcem) :
	__("Un comentario eliminado por mkInstaller"))',$bf);
    ob_start();
    if (!@eval("return true; function $uniq".rand().rand()."() {?> $bf <?php }") and
	!@eval("return true; function $uniq".rand().rand()."() {?> $bf }") and !$istx)
      error(sprintf(__("*** La carga de %s ha producido un error sintáctico"),$nf).ob_get_clean(),$ncte);
    ob_end_clean();
    // busco las asignaciones
    preg_match_all('+^\s*//!\s*\n(?:\s*// *%..%: *[^\n]*\n)*\s*\$(.*?)(\s*)=(\s*)(.*?)\s*;\s*$+sm',$bf,$ivar);
    foreach($ivar[1] as $ix => $var) {
      if (!array_key_exists($var,$vars)) {
	$val=$ivar[4][$ix];
	logea(sprintf(__('Detecto variable %s de valor %s'),$var,$val));
        $vars[$var]=$val;
      }
      preg_match_all('+\s*// *%(..)%: *([^\n]*)+',$ivar[0][$ix],$ietqs);
      if (!$etqs[$var])
        $etqs[$var]=array();
      foreach($ietqs[1] as $ixx => $ilng)
        if (!array_key_exists($ilng,$etqs[$var])) {
	  $etlng=$ietqs[2][$ixx];
	  logea(sprintf(__('Detecto etiqueta \'%s\' para %s, idioma %s'),$etlng,$var,$ilng));
	  $etqs[$var][$ilng]=$etlng;
	}
    }
    // limpia el código original
    // esto es necesario para usar str_replace después con trankilidad
    $bf=preg_replace('+^(\s*//!\s*\n(?:\s*// *%..%: *[^\n]*\n)*\s*)(\$.*?)(\s*)=(\s*).*?(\s*)(;\s*?)$+sm',"\\1\\2\\3=\\4$uniq.\\2.$uniq\\5\\6",$bf);
    ob_start();
    if (!@eval("return true; function $uniq".rand().rand()."() {?> $bf <?php }") and
	!@eval("return true; function $uniq".rand().rand()."() {?> $bf }") and !$istx)
      error(sprintf(__("*** El procesamiento de %s ha producido un error sintáctico"),$nf).ob_get_clean(),$ncte);
    ob_end_clean();
    if ($b['x'] == 'n')
      unset($bu2[$ib2]);
    else if ($b['x'] == 'f')
      $bu2[$ib2]['po']=intW($bf);
    else
      doutW($bf);
    // los idiomas
    preg_match('+(mmIniStr\(.*?\)).*\n */\* mmGetText'.' start \*/ *\n(.*)\n */\* mmGetText'.' end \*/ *\n+s',$bf,$m);
    $llam=$m[1];
    $fus=$m[2];
    if ($fus) {
      unset($ids);
      // vamos a definir mogollon de funciones
      $load=uniqid('f');
      $fu=preg_replace('/.*(function) (mmIniStr.*?}).*/s',
	"\\1 $load\\2 \$ids=$load$llam;",$fus);
      @eval($fu);
      // recupero lo mio ya por si debo dar algun error
      $lang_lang=$mylang;
      if ($ids)
	$ftids=array_merge($ftids,$ids);
      // else algo pasa pero pa que decir na!
    }
  } // }}}
  // {{{ no parseable
  else if (!$b['d'] and !$b['l']) {
    if ($b['x'] or $b['j']) {
      if (!$bf=filtra($b['f'],$nf,cojebuf($nf)))
        continue;
      ob_start();
      if (!@eval("return true; function $uniq".dechex(crc32($nf))."() {?> $bf <?php }") and
	  !@eval("return true; function $uniq".dechex(crc32($nf))."() {?> $bf }"))
        error(sprintf(__("*** La carga de %s ha producido un error sintáctico"),$nf).ob_get_clean(),$ncte);
      ob_end_clean();
      $bu2[$ib2]['po']=intW($bf);
    }
    else {
      logea(sprintf(__("Copio el fichero %s"),$nf));
      if ($b['f']) {
        if (!$bf=filtra($b['f'],$nf,cojebuf($nf)))
	  continue;
        $ta=strlen($bf);
	doutW($bf);
      }
      else {
	if (!$fin=@fopen($nf,'rb')) {
	  error(sprintf(__('No puedo cargar el fichero %s'),$nf),$ncte);
	  continue;
	}
	$ta=0;
	while (true) {
	  $st=fread($fin,$peaso);
	  $l=strlen($st);
	  $ta+=$l;
	  doutW($st);
	  if ($l < $peaso)
	    break;
        }
        fclose($fin);
      }
    }
    $bu2[$ib2]['ta']=$ta;
  } // }}}
}
if ($tlcem)
  logea(sprintf(__("%d líneas de código de depuración eliminadas por mkInstaller"),$tlcem));
if ($tcem)
  logea(sprintf(__("%d comentarios eliminadas por mkInstaller"),$tcem));

$buf=$bu2;
unset($bu2);

// }}}

// {{{ gestion de variables en _mkIn...
foreach($vars as $var => $kk) {
  // añade las vars no definidas en el fich $inst y presentes en los fuentes
  if (!$defvars[$crc=dechex(crc32($var))]) {
    logea(sprintf(__("Añado variable %s al fichero de definiciones"),$var));
    $defvars[$crc]=array('va'=>$var,'df'=>'""','ty' => 'text', 'st' => true, 'sz' => 20, 'lg'=>array());
  }
  // procesa etiquetas de las variables
  foreach($etqs[$var] as $ilg => $ietq)
    $defvars[$crc]['lg'][$ilg]=$ietq;
}

// mira los de defvars que ya no están en las fuentes y da warning
// y sobreescribe el 'df' de las variables con 'cp'
foreach($defvars as $idx => $def)
  if (!array_key_exists($def['va'],$vars)) {
    if (!$usim)
      logea(sprintf(__("** La variable %s ya no está en las fuentes"),$def['va']));
  }
  else if ($def['cp']) {
    $defvars[$idx]['df']=$vars[$def['va']];
    logea(sprintf(__("** Valor por defecto para %s : %s"),$def['va'],$vars[$def['va']]));
  }
// }}}

// {{{ idiomas
// averigua los idiomas del fich de instalación
// el fichero $inst puede tener idiomas que no están en los fuentes
$tids=array();
foreach($defvars as $def)
  foreach($def['lg'] as $id => $kk)
    $tids[$id]=true;

// añade los idiomas de los fuentes a los definidos a mano
$tids=array_merge($tids,$ftids);

// ya puede determinar el idioma principal
if ($tids) {
  reset($tids);
  $idpr=key($tids);
  if (!$miids[$idpr])
    logea(sprintf(__("** Idioma %s no totalmente soportado"),$idpr));
}
else {
  $idpr=$whichLang;
  $tids[$idpr]=1;
}
logea(sprintf(__("Idioma principal: %s"),$idpr));

// completa en $defvars los idiomas que no están
foreach($defvars as $var => $def)
  foreach($tids as $id => $kk)
    if (!$def['lg'][$id])
      if ($def['lg'][$idpr])
        $defvars[$var]['lg'][$id]=$def['lg'][$idpr];
      else
        $defvars[$var]['lg'][$id]=sprintf(__('Introduzca el valor de la variable <i>%s</i>',$id),$def['va']);
// }}}

// {{{ mezclo base de datos con lo que se pasa en linea de comandos con -d
foreach($cdefbdd as $icdefbdds) {
  $cdefbdd1=explode('==',$icdefbdds);
  $icdefbdd=array();
  if (count($cdefbdd1) < 4) {
    error(sprintf('Formato incorrecto "%s", debe ser "%s"',$icdefbdds,'host==user==passw==database[==type[:port][==[+]file]]'),$ncte);
    continue;
  }
  list($ho,$pt)=explode('+',$cdefbdd1[0]);
  array_splice($cdefbdd1,0,1,array($ho,$pt));
  $i1=0;
  // conexion
  foreach(array('ho','pt','us','pw') as $que) {
    if (substr($cdi1=$cdefbdd1[$i1],0,1) == ':')
      $icdefbdd[$que]=substr($cdi1,1);
    else
      $icdefbdd["v$que"]=$cdi1;
    $i1++;
  }
  // bdd
  $bdtb=explode('+',$cdefbdd1[$i1]);
  $cdi1=$bdtb[0]; unset($bdtb[0]);
  if (substr($cdi1,0,1) == ':')
    $icdefbdd['mydb']['db']=substr($cdi1,1);
  else
    $icdefbdd['mydb']['vdb']=$cdi1;
  if (empty($bdtb))
    $bdtb=array('+.*+'=>array());
  else if ($bdtb[1] === '') // no quiero ninguna tabla
    $bdtb=false;
  else
    foreach($bdtb as $i=>$itb) {
      $bdtb[$itb]= array();
      unset($bdtb[$i]);
    }
  $i1++;
  // resto
  $sitp=true;
  if ($tyd=$cdefbdd1[$i1]) {
    $icdefbdd['ty']=$tyd;
    if ($fid=$cdefbdd1[$i1+1])
      if ($fid[0] == '+') {
        // lee todo del fichero
        $icdefbdd['mydb']['fi']=substr($fid,1);
	$sitp=false;
      }
      else
        // solo los creates
        $icdefbdd['mydb']['fc']=$fid;
    else
      // dm = debe usar dump
      $icdefbdd['mydb']['dm']=true;
  }
  else {
    $icdefbdd['ty']='mysql';
    $icdefbdd['mydb']['tc']=array('+.*+');
  }
  if ($sitp)
    $icdefbdd['mydb']['tp']=$bdtb;
  $ok=true; $excx=false;
  foreach($defbdds as $idb => $bd) {
    $ok=false;
    foreach($icdefbdd as $idb1 => $bd1)
      if (!is_array($bd1))
        if ($bd[$idb1] != $bd1) {
          $ok=true;
          break;
        }
    if ($ok)
      $excx=false;
    else { // he encontrado una conexion bastente igual
      $excx=$idb;
      $ok=true;
      foreach($bd as $idb1 => $bd1)
        if (is_array($bd1))
	  foreach($icdefbdd as $idb2 => $bd2)
	    if (is_array($bd2)) {
	      $ok=false;
	      foreach($bd2 as $idb3 => $bd3)
	        if (!is_array($bd3))
        	  if ($bd1[$idb3] != $bd3) {
		    $ok=true;
		    break;
		  }
	      if (!$ok)
	        break 2;
	    }
    }
  }
  if ($ok)
    if ($excx !== false)
      $defbdds[$excx][]=$icdefbdd['mydb'];
    else
      $defbdds[]=$icdefbdd;
  else
    logea(sprintf(__('** Definición de base de datos %s ignorada, ya existe una igual'),$icdefbdds));
} // }}}

// {{{ mensajes internos del instalador
$iipgmg=array(
  'Lfne' => array(
      'es' => "La función %s no está disponible, revisa el modulo php %s",
      'ca' => "La funcio %s no esta disponible, revisa el módul php %s",
      'en' => "The %s function is not available, please review the php module %s", ),
  );
$ipgmg=array(
  'Eali' => array(
      'es' => 'Error al leer los datos internos',
      'ca' => 'Error al llegir les dades internes',
      'en' => 'Error reading internal data', ),
  );
$pgmg=array(
  'Aeuv' => array(
      'es' => 'Atención: Existe una versión actualizada de este instalador.',
      'ca' => 'Atenció: Existeix una versió actualitzada de aquest instal.lador.',
      'en' => 'Warning: An updated version of this installer is available', ),
  'Alli' => array(
      'es' => 'Acepto la licencia y las condiciones',
      'ca' => 'Accepte la llicencia i les condicions',
      'en' => 'Accept the license and the conditions', ),
  'Anpc' => array(
      'es' => '<b>Atenci&oacute;n</b>: No puedo crear ficheros o establecer su fecha en %s.<br>Revisa sus permisos y recarga esta p&aacute;gina.<br>',
      'ca' => '<b>Atenci&oacute;</b>: No puc crar fitxers o establir la seva data en en %s.<br>Revisa els seus permisos i recarrega esta p&agrave;gina.<br>',
      'en' => '<b>Warning</b>: Cannot create files or set its time in %s.<br>Review its permissions and reload this page.<br>', ),
  'Atli' => array(
      'es' => 'Lea también la licencia del instalador:',
      'ca' => 'Legiu també la llicencia del instal.lador:',
      'en' => 'Read also the installer license:', ),
  'Bdnp' => array(
      'es' => 'Bases de datos no procesadas',
      'ca' => 'Bases de dades no procesades',
      'en' => 'Data bases not processed', ),
  'Cefs' => array(
      'es' => 'Creando el fichero %s',
      'ca' => 'Creant el arxiu %s',
      'en' => 'Creating file %s', ),
  'Clbd' => array(
      'es' => 'Creada la base de datos %s',
      'ca' => 'Creada la base de dades %s',
      'en' => 'Created the database %s', ),
  'Cont' => array(
      'es' => 'Continuar',
      'ca' => 'Continuar',
      'en' => 'Continue', ),
  'Ddal' => array(
      'es' => 'Debe de aceptar la licencia',
      'ca' => 'Deu de aceptar la llicencia',
      'en' => 'License must be accepted', ),
  'Dppa' => array(
      'es' => 'Deben pasarse parámetros',
      'ca' => 'Deuen de pasarse parametres',
      'en' => 'Some parameters must be passed', ),
  'Didl' => array(
      'es' => 'Debe instalarse desde la misma IP que se instaló la última vez',
      'ca' => 'Deu d\'instal.larse desde la matrixa IP que es va instal.lar l\'ultima vegada',
      'en' => 'Must be installed from the same IP than the last install', ),
  'Dyul' => array(
      'es' => 'Descargar y usar la nueva versión',
      'ca' => 'Descarregar i emprar la nova versió',
      'en' => 'Download and use the new version', ),
  'Eale' => array(
      'es' => 'Error al leer el archivo de datos',
      'ca' => 'Error al llegir el arxiu de dades',
      'en' => 'Error reading data file', ),
  'Eefs' => array(
      'es' => 'Ejecutando el fichero %s',
      'ca' => 'Ejecutant el arxiu %s',
      'en' => 'Running file %s', ),
  'Einp' => array(
      'es' => 'Este instalador no debería ejecutarse en \'safe_mode\' pues necesita crear subdirecotrios con archivos.',
      'ca' => 'Aquest instal.lador no deurie de ejecutarse en \'safe_mode\' perque necessita crear subdirectoris amb arxius.',
      'en' => 'This installer ishould not run in safe mode as it needs to create subdirectories with files.', ),
  'Epds' => array(
      'es' => 'El procesamiento de %s ha producido un error sint&aacute;ctico',
      'ca' => 'El processament de %s ha produit una errada sint&agrave;ctica',
      'en' => 'The processing of %s has produced a syntax error', ),
  'Esae' => array(
      'es' => 'Error %s',
      'ca' => 'Error %s',
      'en' => 'Error %s', ),
  'Escr' => array(
      'es' => 'Escribiendo %s ...',
      'ca' => 'Escribint %s ...',
      'en' => 'Writting %s ...', ),
  'Eval' => array(
      'es' => 'Evaluar la entrada',
      'ca' => 'Evaluar l\'entrada',
      'en' => 'Evaluate input', ),
  'ExIn' => array(
      'es' => 'Expresión incorrecta',
      'ca' => 'Expressió incorrecta',
      'en' => 'Invalid expression', ),
  'Igdb' => array(
      'es' => 'No procesar bases de datos',
      'ca' => 'No processar bases de dades',
      'en' => 'Do no process databases', ),
  'Inco' => array(
      'es' => 'Instalación de ficheros y bdd completa',
      'ca' => 'Instalació de arxius i bdd completa',
      'en' => 'Installation of files and db completed', ),
  'Inst' => array(
      'es' => ' Instalar ',
      'ca' => ' Instal.lar ',
      'en' => ' Install ', ),
  'Lvsu' => array(
      'es' => 'La variable %s usada en la def de bdd %s no está definida o no tiene valor actual',
      'ca' => 'La variable %s usada en la def de la bdd %s no está definida o no te valor actual',
      'en' => 'The variable %s used in the def of db of %s is not defined or has not actual value', ),
  'Nesc' => array(
      'es' => 'No ejecutar scripts',
      'ca' => 'No ejecutar scripts',
      'en' => 'Do not run scripts', ),
  'Npae' => array(
      'es' => 'No puedo abrir el archivo de datos %s',
      'ca' => 'No puc obrir l\'arxiu de dades %s',
      'en' => 'Cannot open data file %s', ),
  'Npce' => array(
      'es' => 'No puedo crear el directorio %s',
      'ca' => 'No puc crear el directori %s',
      'en' => 'Cannot create directory %s', ),
  'Npcf' => array(
      'es' => 'No puedo crear el fichero %s',
      'ca' => 'No puc crear el arxiu %s',
      'en' => 'Cannot create file %s', ),
  'Npef' => array(
      'es' => 'No puedo escribir en el fichero %s',
      'ca' => 'No puc escriure en el arxiu %s',
      'en' => 'Cannot write in file %s', ),
  'Npcb' => array(
      'es' => 'No puedo crear la base de datos, error: ',
      'ca' => 'No puc crear la base de dades, error: ',
      'en' => 'Cannot create database, error: ', ),
  'Npcs' => array(
      'es' => 'No puedo conectar con el servidor de base de datos, error: %s',
      'ca' => 'No puc conectar amb el servidor de base de dades, error: %s',
      'en' => 'Cannot connect with the database server, error: %s', ),
  'Npev' => array(
      'es' => 'No puedo escribir el fichero %s de volcado de la base de datos',
      'ca' => 'No puc escriure el arxiu %s de volcat de la base de dades',
      'en' => 'Cannot write data base dump file %s', ),
  'Npsb' => array(
      'es' => 'No puedo seleccionar la base de datos %s, error ',
      'ca' => 'No puc seleccionar la base de dades, error: ',
      'en' => 'Cannot select database, error: ', ),
  'Nspu' => array(
      'es' => 'No se pudo usar la nueva versión',
      'ca' => 'No se ha pogut emprar la nova versió',
      'en' => 'The new version has not been able to use', ),
  'Oper' => array(
      'es' => 'Operando %s ...',
      'ca' => 'Operant %s ...',
      'en' => 'Operating %s ...', ),
  'Papc' => array(
      'es' => 'Pulse <a href="?wk=1&uniq='.$uniq.'">aqu&iacute;</a> para comenzar.',
      'ca' => 'Polse <a href="?wk=1&uniq='.$uniq.'">ac&iacute;</a> par comen&ccedil;ar.',
      'en' => 'Click <a href="?wk=1&uniq='.$uniq.'">here</a> to start.', ),
  'Pefs' => array(
      'es' => 'Parseando el fichero %s',
      'ca' => 'Parsejant el arxiu %s',
      'en' => 'Parsing file %s', ),
  'Pyce' => array(
      'es' => 'Parseando y creando el fichero %s',
      'ca' => 'Parsejant i creant el arxiu %s',
      'en' => 'Parsing & creating file %s', ),
  'Slbd' => array(
      'es' => 'Seleccionada la base de datos %s',
      'ca' => 'Seleccionada la base de dades %s',
      'en' => 'Selected the database %s', ),
  'Sosi' => array(
      'es' => 'Sólo simulación',
      'ca' => 'Sols simulació',
      'en' => 'Simulation only', ),
  'Tito' => array(
      'es' => 'Tiempo total: %s segundos',
      'ca' => 'Temps total: %s segons',
      'en' => 'Total time: %s seconds', ),
  );
$ppgmg=intW(serialize($pgmg));
// }}}

// {{{ creo inputs en el instalador
$phpg=
'	    echo "<table id=tab>\n";
	    foreach($dvars as $id => $def) {
	      $mg=&$def["lg"][$lg];
	      if (!$mg)
	        $mg=&$def["lg"]["'.$idpr.'"];
	      $ty=strtolower($def["ty"]);
	      if ($sp=&$def["sp"][$lg])
	        echo "  <tr><td id=sp$id class=sep colspan=2>$sp";
	     if ($ty != "hidden")
	        echo "  <tr><td id=td$id class=lab>$mg: ";
	      $sz=$def["sz"]; $vs=$def["vs"]; $d=$def["df"];
	      if ($def["ml"] and is_array($d))
	        if($dlg=$d[$lg])
	          $d=$dlg;
	        else
	          $d=current($d);
	      if (is_array($d)) {
		if ($def["mp"])
	          echo "<td id=ti$id class=tse><select id=in$id size=\"$sz\" multiple name=\"v[$id][]\" class=sel>";
		else
	          echo "<td id=ti$id class=tse><select id=in$id size=\"$sz\" name=\"v[$id]\" class=sel>";
	        $vse=$def["vl"] or $se=$def["se"]; $c=1;
	        foreach($d as $v=>$t) {
		  $ok=false;
		  eval(\'$val=\'.$v.\';$ok=true;\');
		  if (!$ok)
	            echo "<xmp>$v</xmp>";
		  if (!$t)
		    $t=$val;
		  $val=htmlspecialchars($val,ENT_COMPAT);
		  $sel=(($vse == $val or $se == $c) ? " selected" : "");
		  $c++;
	          echo "<option$sel value=\"$val\">$t";
	        }
	        echo "</select>\n";
	      }
	      else {
	        if ($ty != "hidden")
	          if ($vs)
		    echo "<td id=ti$id class=ttx>";
		  else
	            echo "<td id=ti$id class=tin>";
	        switch ($ty) {
		  case "text":
		  case "checkbox":
		  case "password":
		  case "hidden": $ty=" type=$ty"; break;
		  case "readonly": $ty=" type=text readonly"; break;
		}
		$ok=false;
		if (isset($def["vl"]))
		  $val=$def["vl"]; 
		else {
		  eval(\'$val=\'.$d.\';$ok=true;\');
		  if (!$ok)
		    echo "<xmp>$d</xmp>";
		}
		$val=htmlspecialchars($val,ENT_COMPAT);
		if ($vs)
		  echo "<textarea id=in$id rows=$vs cols=$sz class=txt name=\"v[$id]\">$val</textarea>\n";
		else {
		  if ($sz)
		    $sz=" size=$sz";
		  echo "<input id=in$id class=inp name=\"v[$id]\" value=\"$val\"$ty$sz>\n";
		}
	      }
	    }
';

// las opciones
if ($defbdds and $myopt['ski'])
  $phpg.=
'	    echo "  <tr><td id=tdskdb class=lab>".htmlentities(st("Igdb"))." <td id=tiskdb class=tin><input id=inskdb name=\"skdb\" type=checkbox class=che>\n";
';
if ($myopt['nru'])
  $phpg.=
'	    echo "  <tr><td id=tdnrun class=lab>".htmlentities(st("Nesc"))." <td id=tinrun class=tin><input id=innrun name=\"nrun\" type=checkbox class=che>\n";
';
if ($fsimu=$myopt['fsm']) {
  unset($myopt['sim']);
  $fsimu='='.$fsimu;
}
else
  $fsimu='';
if ($simu=$myopt['sim']) {
  $phpg.=
'	    if (!$simu) echo "  <tr><td id=tdsimu class=lab>".st("Sosi")." <td id=tisimu class=tin><input id=insimu name=\"simu\" type=checkbox class=che value='.$simu.'>\n";
';
}

$phpg.=
'	    echo "  <tr><td id=tidoit colspan=2 class=tsu><input id=indoit class=sub type=submit name=doit value=\"".htmlentities(st("Inst"))."\">\n";
';

if (!$nam=$myopt['nam']) {
  $nam=$uniq;
  $myopt['nam']=$nam;
  logea(__("** Ponga un nombre a su aplicación"));
}
// }}}

// {{{ licencias
// licencia instalador
if ($ili=$myopt['ili'])
  $ili=cojebuf($ili);
else {
  $ili=$milic;
  logea(__("** Licencia del instalador por defecto, debería usar -o ili"));
}
$lian=array_reduce(array_map(strlen,explode("\n",$ili)),max,0);

//licencia
$lics=array();
if ($lic=$myopt['lic']) {
  if (!file_exists($lic))
    error(sprintf(__("El fichero %s no existe"),$lic),$ncte);
  $hay=false;
  // determina el idioma de licencia más apropiado
  foreach($tids as $id => $kk)
    if (preg_match("+(^|/)$id-[^/]*$+",$lic,$ma)) {
      $hay=true;
      $lid=$id;
      break;
    }
  if (!$hay)
    error(sprintf(__("El fichero %s %s no corresponde con ningún idioma definido"),__('licencia'),$lic),$ncte);
  foreach($tids as $id => $kk) {
    if (file_exists($nf=preg_replace("+(^|.*/)$lid(-[^/]*)$+","\${1}$id\\2",$lic))) {
      $p=@file_get_contents($nf);
      $lian=max($lian,array_reduce(array_map(strlen,explode("\n",$p)),max,0));
      $lics[$id]=intW($p);
    }
    else
      logea(sprintf(__("** No existe el fichero %s para %s, cojo el de %s"),__('licencia'),$id,$lid));
  }
}
else
  logea(__("** Debería especificar una licencia con -o lic"));

$phpp='';
if ($myopt['lic']) {
  $phpg.=
'	    if (!$li=$lics[$lg])
	      $li=$lics["'.$lid.'"];
	    echo "  <tr><td colspan=2 id=tdacli>\n  <input id=inacli name=\"acli\" type=checkbox class=che>".htmlentities(st("Alli"))."<br>\n";
	    echo "  <textarea cols='.$lian.' rows=5 id=inlic>".htmlentities(trim(tkInBuff($li)."\n\n".st("Atli")."\n\n$ilic"))."</textarea>\n</tbody>\n</table>\n";
';
  $acli=
'	  if (!$o["acli"])
	    salir(st("Ddal"));
';
}
else
  $acli='';
$phpg.=
'	    echo "</table>";
';
// }}}

// {{{ plantillas
$plans=array();
$logo=base64_decode('R0lGODlhnwAZAKEBAP8AAP///////////yH5BAEKAAEALAAAAACfABkAAAL+jI+pC70Po1QNzIuz3rkyx4WHJ1JkcJZqmBqVNYIr1KpvXM/6c+My+tshcqIekChMGl8wnI1pYjaLJ+jOmDy6sBfpdGsdeqNI8JRb8n5n6rVETa7BxWFeCyn9tPPmMr1Op8fnRIN2NFb4ZdiWsDcHh+iDF3Ro1mhYKUhopyi390fpKPoTGUW22eempQkWweUJUjcYRyIKSona6nMJuGral9gZdEeKKXlmtVT6x8tMK5OjXEY8XGyNy3vdJD27G/j9nGt5OLlGPQc88ZrSc9PrqysOKt/eDe6dimbsjJ+52nvu3q1tuOpZKHfqWDRsCfv5qrLumkBGkp4dJLIQGUNteZx+bWKHJeKtfBZhQMJYUOKbjc1afqwGU+NIcsG4Qcuoh1+iDqFgiguZLKYqV2EGAUwpbJkfgfAe9gRZi6WQiOaQZuu2lKM6pBqlZln5VAPFrxhQCiOLNq3anKzWun2r1uxQuHTrfs1qNy+HAgA7');
if ($plan=$myopt['tpl']) {
  if (!file_exists($plan))
    error(sprintf(__("El fichero %s no existe"),$plan),$ncte);
  $hay=false;
  // determina el idioma de plantilla más apropiado
  foreach($tids as $id => $kk)
    if (preg_match("+(^|/)$id-[^/]*$+",$plan,$ma)) {
      $hay=true;
      $pid=$id;
      break;
    }
  if (!$hay)
    error(sprintf(__("El fichero %s %s no corresponde con ningún idioma definido"),__('plantilla'),$plan),$ncte);
  if ($pid != $idpr)
    logea(sprintf(__("** La plantilla por defecto (%s) no coincide con el idioma por defecto (%s)"),$pid,$idpr));
  $imgs=array();
  foreach($tids as $id => $kk) {
    if (file_exists($nf=preg_replace("+(^|.*/)$pid(-[^/]*)$+","\${1}$id\\2",$plan))) {
      $p=file_get_contents($nf);
      preg_match_all('/<img[^>]*src="?([^ >"]*)/',$p,$ma);
      foreach($ma[1] as $f) {
	// antes cargaba sólo imágenes locales, es mejor cargar todas para evitar que dejen de existir
        if (is_file($fff=dirname($nf).'/'.$f))
	  $ff=$fff;
	else
	  $ff=$f;
	$ity='auto';
	if ($ff == '{LOGO}') {
	  $im=$logo;
	  $ity='gif';
	}
	else if (!$im=@file_get_contents($ff)) {
	  error(sprintf(__("No puedo cargar la imagen %s"),$ff),$ncte);
	  continue;
	}
	$iimg=dechex(crc32($im));
        if (!$imgs[$iimg]) {
	  if ($ity=='auto') {
	    if (function_exists(mime_content_type)) {
	      $mity=@mime_content_type($ff);
	      if (preg_match("+^image/(.*)+",$mity,$mity))
	        $ity=$mity[1];
	    }
	    else if (function_exists(getimagesize)) {
	      $mity=@getimagesize($ff);
	      if (preg_match("+^image/(.*)+",$mity['mime'],$mity))
                $ity=$mity[1];
	    }
	  }
	  $imgs[$iimg]['i']=intW($im);
	  logea(sprintf(__("Tomo imagen %s de tipo %s, id %s"),$f,$ity,$iimg));
	  $imgs[$iimg]['t']=$ity;
	}
	$p=preg_replace('/(<img[^>]*src=)"?'.preg_quote($f,'/').'"?/',"\\1\"?img=$iimg\"",$p,1);
      }
      $p=str_replace(array('{NAM}','{IVER}'),
		array($nam,$mver),$p);
      if ($ver)
	$p=str_replace('{VER}',trim(file_get_contents("$vUrl?lang=$id")),$p);
      $plans[$id]=intW($p);
    }
    else
      logea(sprintf(__("** No existe el fichero %s para %s, cojo el de %s"),__('plantilla'),$id,$pid));
  }
}
else {
  $pid=$idpr;
  // {{{ plantilla por defecto
  $imgs[$iimg=dechex(crc32($logo))]['t']='gif';
  $plat=
'	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<title>'.sprintf(__('Instalador para %s - Construido con mkInstaller',$idpr),$nam).'</title>
	<style type="text/css">
	  td.eIz, td.eDe {
	    width: 10%;
	    text-align: center;
	    overflow: hidden;
	  }
	  #eIz1, #eIz2, #eIz3 {
	    overflow: hidden;
	    visibility: hidden;
	  }
	  table {
	    border-collapse: collapse;
	  }
	  td {
	    border: 0px;
	  }
	  td.env {
	    border: 2px solid orange;
	    text-align: center;
	    height: 98%;
	    width: 80%;
	    overflow: visible;
	  }
	  td.bIz {
	    background-color: blue;
	    height: 1%;
	    width: 1%;
	  }
	  td.fbg {
	    height: 95%;
	    overflow:hidden;
	    width: 99%;
	  }
	  table.tbg {
	    width: 100%;
	    height: 100%;
	  }
	  table.tex {
	    width: 100%;
	    height: 85%;
	  }
	  .ifr {
	    width: 100%;
	    height: 100%;
	    border: none;
	    background-color: transparent;
	  }
	  body,html {
	    margin:0;
	    padding:0;
	    height:100%;
	    border:none;
	    background-color: transparent;
	  }
	  a:link, a:visited, a:active {
	    text-decoration: none; color: blue;
	  }
	</style>
	</head>
	<body>
	<script>
	  function mkProgress(po,tb,to) {
	    document.getElementById("mkInsGrow").style.width=(po+1)+"%";
	  }
	  function chStep(s) {
	    for(i=1 ; i<4 ; i++)
	      with (document.getElementById(\'eIz\'+i).style) {
	        visibility=\'hidden\'; width=\'1px\'; height=\'1px\';
	      }
	    with (document.getElementById(\'eIz\'+s).style) {
	      visibility=\'visible\'; width=\'auto\'; height=\'auto\';
	    }
	  }
	</script>
	<h2 style="text-align: center">'.sprintf(__('Instalador para %s',$idpr),$nam).
		(($ver) ? ' - '.sprintf(__('ver %s',$idpr),trim(file_get_contents("$vUrl?lang=$idpr"))) : '').'</h2>
	<table class=tex>
	<tr><td class="eIz"><div id="eIz1">'.__('Paso 1',$idpr).'</div><div id="eIz2">'.__('Paso 2',$idpr).'</div><div id="eIz3">'.__('Fin',$idpr).'</div></td>
	<td class="env">
	  <table class=tbg>
	  <tbody>
	  <tr>
	   <td class="bIz" id="mkInsGrow"><br></td>
	   <td class="bDe"><br></td>
	  </tr>
	  <tr>
	   <td class="fbg" colspan=2>{CONT}</td>
	  </tr>
	  </tbody>
	  </table>
	</td>
	<td class="eDe"></td>
	</table>
	<!-- Please, use <img src={LOGO}> to refer mkInstaller logo -->
	<p align=right><font size=-1>'.__('Construido con',$idpr).'</font> <a href="http://mkInstaller.nisu.org/"><img align=absmiddle border=0 src="?img='.$iimg.'" alt="mkInstaller"></a> <font size=-1>'.sprintf(__('ver %s'),$mver).'</font></p>
	</body>
	</html>
'; // }}}
  $plans[$pid]=intW(qtab($plat));
  $imgs[$iimg]['i']=intW($logo);
}
// }}}

// {{{ css
if ($cssi=$myopt['css'])
  $cssi=cojebuf($cssi);
else {
  $cssi=
'	  body,html {
	    margin:0;
	    padding:0;
	    height:100%;
	    border:none;
	    background-color: transparent;
	  }
	  a:link, a:visited, a:active {
	    text-decoration: none; color: blue;
	  }
	  table {
	    border-collapse: collapse;
	  }
	  td {
	    border: 0px;
	  }
	  td.lab {
	    text-align: right;
	    width: 50%;
	  }
	  td.tin , td.tse, td.ttx {
	    text-align: left;
	  }
	  input.sub {
	    background-color: yellow;
	  }
	  #gta {
	    height: 98%;
	    width: 100%;
	  }
	  #gtd {
	    vertical-align: middle;
	    width: 100%;
	    height: 98%;
	  }
	  #tab {
	    width: 100%;
	    text-align: center;
	    vertical-align: middle;
	  }
	  #tdacli {
	    text-align: center;
	  }
	  #wvr {
	    font-weight: bold;
	  }
';
  $cssi=qtab($cssi);
}

$cssi=intW($cssi);
// }}}

// {{{ imagenes
if ($imgs) {
  $imgsai=intW(serialize($imgs));
  $imgsa=
'
	if ($i=$_GET["img"]) {
	  $imgs=unserialize(tkInBuff('.$imgsai.'));
	  header("Content-type: image/".$imgs[$i]["t"]);
	  exit(tkInBuff($imgs[$i]["i"]));
	}
';
  $imgsai=
  	'$imgs=unserialize(tkInBuff('.$imgsai.'));
  ';
}
else {
  $imgsa='';
  $imgsai='';
}
// }}}

// {{{ codigo del instalador en post para el tema ficheros
if ($big)
  $phpp.=
'	  dataOpen($datafile);
';
else
  $phpp.=
'	  dataOpen($sfn);
';

$phpp.=
'	  $prt=true; $run=array();
	  foreach($files as $if => $fic) {
	    $nf=$fic["n"];
	    if ($cnd=$fic["c"]) {
	      $vv=dechex(crc32($cnd["v"]));
	      $vv=$v[$vv];
	      if (function_exists("preg_match"))
	        $ndc=!preg_match("/".$cnd["e"]."/",$vv);
	      else
	        $ndc=true;
	    }
	    else
	      $ndc=false;
	    $ndo=($ndc or $simu);
	    if ($l=$fic["l"]) {
	      if (!$ndo) {
	        @unlink($nf);
	        symlink($l,$nf);
	      }
	    }
	    else if ($fic["d"])
	      $ndo or crd("$nf/.",$fic["a"][0]);
	    else {
	      if ($fic["p"]) {
		$f=tkBuff();
		if ($fic["x"])
		  $ndc or loge(sprintf(st("Pefs"),$nf));
	        else
		  $ndc or loge(sprintf(st("Pyce"),$nf));
		parsea($f);'.
		/* al instalar elimina los comentarios en los idiomas que no proceda */'
		if (function_exists("preg_replace"))
		  $f=preg_replace(array("#^([ \t]*//[ \t]+)%$lg%:[ \t]+#m","#^[ \t]*//[ \t]+%..%:[ \t].*\n#m"),array("\\\1",""),$f);
	        $prt=false; ob_start();
	        if (!@eval("return true; function $uniq$if() {?> $f <?php }") and
	            !@eval("return true; function $uniq$if() {?> $f }"))
	          salir(sprintf(st("Epds"),$nf)."<xmp>$f</xmp>".ob_get_clean(),true);
		ob_end_clean();
		if ($fic["x"])
		  $run[$nf]=$f;
		else if (!$ndo) {
	          crd($nf);
		  $h=@fopen($nf,"wb") or salir(sprintf(st("Npcf"),$nf).$brk.$php_errormsg,true);
		  (@fwrite($h,$f) !== false) or salir(sprintf(st("Npef"),$nf).$brk.$php_errormsg,true);
	          fclose($h);
		  @chmod($nf,$fic["a"][0]);
		  @touch($nf,$fic["a"][1]);
	        }
	      }
	      else if (!$fic["x"]) {
	        $ndo or crd($nf);
	        $ndo or $h=@fopen($nf,"wb") or salir(sprintf(st("Npcf"),$nf).$brk.$php_errormsg,true);
	        $ta=$fic["ta"];
	        $ndc or loge(sprintf(st("Cefs"),$nf));
	        while (true) {
	          $bf=tkBuff();
	          $ndo or (@fwrite($h,$bf) !== false) or salir(sprintf(st("Npef"),$nf).$brk.$php_errormsg,true);
	          $ta-=strlen($bf);
		  if (!$ta)
		    break;
	        }
	        if (!$ndo) {
		  fclose($h);
		  @chmod($nf,$fic["a"][0]);
		  @touch($nf,$fic["a"][1]);
		}
	      }
	    }
	  }
';
// }}}

// {{{ bases de datos
if ($defbdds) {
  $drop=$myopt['drp'];
  if ($drop)
    if ($dtod and !$usim) {
      logea(__("La opción 'drp' ha quedado desactivada"));
      $drop=false;
    }
    else
      logea(__("** Usando la opción peligrosa 'drp' => drop tables"));
  $igno=$myopt['idb'];
  foreach($defbdds as $idb => $bd) {
    if ((($ty=$bd['ty']) != 'mysql') and ($ty != 'pgsql')) {
      error(sprintf(__("Tipo de base de datos '%s' desconocido"),$ty),$ncte);
      continue;
    }
    if ($alt=$bd['alt']) {
      if (!$defvars[$crc=dechex(crc32($alt))]) {
	logea(sprintf(__('** Revise la definicin de la varible autodefinida %s'),$alt));
        $defvars[$crc]=array('va'=>$alt,'df'=>array("\"$idb\"" => $idb),'ty' => 'text', 'st' => false, 'lg'=>array());
      }
      else if (!$defvars[$crc]['df']["\"$idb\""])
	$defvars[$crc]['df']["\"$idb\""]=$idb;
    }
    // {{{ obtiene conexion actual y conecta
    $con=array();
    foreach(array('ho','pt','us','pw') as $n) {
      if ($bd[$n] and $bd["v$n"]) {
	error(sprintf(__("La definición de bdd %s contiene %s y v%s ambos definidos"),$idb,$n,$n),$ncte);
	continue;
      }
      if ($nv=$bd["v$n"]) {
        // cojo datos para la conexión actual
	if ($vv=$vars[$nv])
          eval('$con[$n]='.$vv.';'); // nombre actual
	else {
          error(sprintf(__("La variable %s usada en la def de bdd %s no está definida o no tiene valor actual"),$nv,$idb),$ncte);
	  continue;
	}
      }
      else if ($bd[$n]) {
	$con[$n]=$bd[$n];
      }
    }
    if ($con) {
      if ($con['pt']) {
        if ($ty == 'mysql')
	  $con['ho'].=':'.$con['pt'];
      }
      else
        if ($ty == 'pgsql')
          $con['pt']=$defbdds[$idb]['pt']='5432';
      if ($ty == 'mysql') {
	// conecto con el actual server
	@mysql_connect($con['ho'],$con['us'],$con['pw']) or
          logea(vsprintf(__("** No puedo conectar con el servidor mysql actual, puede ser normal si usa un fichero para los datos,\n conexión actual '%s' , '%s' , '%s'"),$con));
	$_qu=mysql_query; $_err=mysql_error; $_nr=mysql_num_rows; $_fr=mysql_fetch_row; $_es=mysql_escape_string; $_fe=mysql_free_result; $_se='`'; $emxrw=$mxrw;
      }
      else {
	$_qu=pg_query;  $_err=pg_last_error; $_nr=pg_num_rows;    $_fr=pg_fetch_row;    $_es=pg_escape_string;    $_fe=pg_free_result;    $_se='"'; $emxrw=1;
      }
    } // }}}
    // {{{ cada una de las bases de datos
    foreach($bd as $ibd => $n)
      if (is_array($n)) {
	if ($n['vdb'] and $n['db']) {
          error(sprintf(__("La definición de bdd %s de %s contiene db y vdb ambos definidos"),$ibd,$idb),$ncte);
	  continue;
	}
	if ($nv=$n['vdb']) {
          if (!$vv=$vars[$nv]) {
	    error(sprintf(__("La variable %s usada para el nombre de la bdd %s de %s no está definida o no tiene valor actual"),$nv,$ibd,$idb),$ncte);
	    continue;
	  }
	  eval('$nbd='.$vv.';');
	}
	else {
          $nbd=$n['db'];
	}
	logea(sprintf(__('Base de datos %s'),$nbd));
	if ($fil=$n['fi']) {
	  if (!$h=fopen($fil,"r")) {
            error(sprintf(__('No puedo abrir el fichero %s'),$fil),$ncte);
	    continue;
	  }
	  $ncr=parseSql($h);
	}
	else if ($con) {
	  if ($ty == 'mysql') {
	    if (!@mysql_select_db($nbd)) {
	      error(sprintf(_("No puedo seleccionar la base de datos %s"),$nbd),$ncte);
	      continue;
	    }
	  }
	  else {
	    $scon=''; $con['db']=$nbd;
	    foreach(array('ho'=>'host','pt'=>'port','us'=>'user','pw'=>'password','db'=>'dbname') as $iicon => $icon)
	      $scon.="$icon='".$con[$iicon]."' ";
	    if (!@pg_connect($scon)) {
	      error(vsprintf("$scon\n",__("No puedo conectar con el servidor postgres actual '%s' , '%s', '%s' , '%s' , '%s'"),$con),$ncte);
	      continue;
	    }
	  }
	  $fil=$n['fc'];
	  if ($fil or $n['dm']) { // {{{
	    if ($fil) {
	      if (!$h=fopen($fil,"r")) {
        	error(sprintf(__('No puedo abrir el fichero %s'),$fil),$ncte);
		continue;
	      }
	    }
	    else {
	      if ($ty == 'mysql') {
  	        if ($drop)
		  $dropdm='--add-drop-table';
		else
		  $dropdm='--skip-add-drop-table';
		$h=popen("mysqldump $dropdm -d -q -Q --triggers --create-options -h'$con[ho]' -u'$con[us]' -p'$con[pw]' '$nbd'","r");
	      }
	      else {
	        if ($drop)
		  $dropdm='-c';
		else
		  $dropdm='';
		putenv('PGPASSWORD='.$con[pw]);
		$h=popen("pg_dump $dropdm -O -s -h '$con[ho]' -U '$con[us]' '$nbd'","r"); 
	      }
	    }
            $ncr=parseSql($h);
	    $tabs=array();
	    if ($ty == 'mysql') {
	      $q=mysql_query("show tables");
	      while (list($tab)=mysql_fetch_row($q)) {
		logea(sprintf(__("Tabla %s"),$tab));
		$tabs[]=$tab;
	      }
	    }
	    else {
	      $q=pg_query("select table_name from information_schema.tables where table_schema = 'public'"); 
	      while (list($tab)=pg_fetch_row($q)) {
		logea(sprintf(__("Tabla %s"),$tab));
		$tabs[]=$tab;
	      }
	    }
	    $tabss=$tabs;
	  } // }}}
	  else { // {{{
	    if ($ty != 'mysql') {
	      error(sprintf(__('Sin fichero ni "dm", la base de datos debe ser mysql')));
	      continue;
	    }
	    // prepara los creates de esta bdd mysql sin usar mysqldump
	    $tabs=array();
	    $q=mysql_query("show tables");
	    while (list($tab)=mysql_fetch_row($q))
	      $tabs[]=$tab;
	    if (!$n['tc']) {
	      logea(__("** Estableciendo como lista de tablas la lista actual"));
	      foreach($tabs as $tab)
		$n['tc'][]="/^$tab\$/";
	      $defbdds[$idb][$ibd]['tc']=$n['tc'];
	    }
	    $tabss=array();
	    $ncr=0; $proc=array();
	    foreach($n['tc'] as $etab) {
	      $itabs=@preg_grep($etab,$tabs);
              if (($itabs === false) // no es regex
		 and in_array($etab,$tabs))
		$itabs=array($etab);
	      if (!$itabs) {
		logea(sprintf(__("** El patrón '%s' no corresponde con ninguna tabla"),$etab));
		continue;
	      }
	      foreach($itabs as $tab) {
		if ($proc[$tab])
        	  continue;
        	$proc[$tab]=true;  // evita duplicadas por regexp
		list($tab,$cr)=mysql_fetch_row(mysql_query("show create table `$tab`"));
		logea(sprintf(__("Crea tabla %s"),$tab));
		if ($drop) {
		  doutW("DROP TABLE IF EXISTS `$tab`");
		  $ncr++;
		}
		/* lo quito porque lo trato al ejecutar
		if ($igno)
		  $cr=preg_replace('/^CREATE TABLE/','\0 IF NOT EXISTS',$cr).';';
		*/
		doutW("$cr;");
		$ncr++;
		$tabss[]=$tab;
	      }
	    }
	  } // }}}
	  $defbdds[$idb][$ibd]['tcc']=$tabss;
	  if ($sql=$n['sql']) {
	    foreach($sql as $isql) {
	      doutW($isql);
	      $ncr++;
	    }
	  }
	  if ($n['tp']) { // {{{
	    $proc=array();
	    foreach($n['tp'] as $etab => $sele) {
	      $itabs=@preg_grep($etab,$tabss);
	      if (($itabs === false) and in_array($etab,$tabss))
		$itabs=array($etab);
	      if (!$itabs) {
		logea(sprintf(__("** El patrón '%s' no corresponde con ninguna tabla"),$etab));
		continue;
	      }
	      foreach($itabs as $tab) {
		if ($proc[$tab])
		  continue;
		$proc[$tab]=true;
		$nins=$peasoq;
		if (is_array($sele)) {
		  if ($sele['nins'])
		    $nins=$sele['nins'];
	          $lf=$sele['cols']; $sql=$sele['sql'];
		  if ($sql)
		    $sql=str_replace('{COLS}',$lf,$sql);
		  else {
		    $sql=$lf;
		    if (!$sql)
		      $sql='*';
		    $sql="select $sql from $_se$tab$_se";
		  }
		}
		else if (($sele === true) and (count($itabs) == 1)) {
	          if ($ty == 'mysql')
	            $q=mysql_query("show columns from `$tab`");
		  else
		    $q=pg_query("select column_name from information_schema.columns where table_name ='$tab'");
		  $lf="";
		  while (list($fi)=$_fr($q))
		    $lf.=",$_se$fi$_se";
		  $lf=substr($lf,1);
		  $sql="select * from $_se$tab$_se";
		  $defbdds[$idb][$ibd]['tp'][$etab]=array('cols'=>$lf,'sql'=>$sql);
		}
		else {
	          $lf='';
		  $sql="select * from $_se$tab$_se";
		}
		logea(sprintf(__("Rellena tabla %s"),$tab)." <= $sql");
		if ($lf)
		  $lf="($lf)";
		$pri=0;
		if ($ty == 'mysql') {
		  // $lf="INSERT DELAYED ".(($igno) ? "IGNORE " : "")."INTO `$tab` $lf values ";
		  // $lf="INSERT DELAYED INTO `$tab` $lf values "; Delayed implica ignore en mysql 5
		  $lf="INSERT INTO `$tab` $lf values ";
		}
		else {
		  $lf="INSERT INTO \"$tab\" $lf values ";
		}
		while (true) {
		  $vas=""; $cins=0;
		  if (!$q=$_qu($tpq="$sql limit $emxrw offset $pri"))
		    error("$tpq\n".$_err(),$ncte);
		  $nro=$_nr($q);
		  while ($vs=$_fr($q)) {
		    $va="";
		    foreach($vs as $v)
		      $va.=",'".$_es($v)."'";
		    if (strlen($vas)+strlen($va) > $peasoq  // insert muy grande
		        or $cins >= $nins ) {
		      $vas=$lf.substr($vas,1).";\n";
		      doutW($vas);
		      $ncr++;
		      $vas=""; $cins=0;
		      logea();
		    }
		    $vas.=",(".substr($va,1).")";
		    $cins++;
		  }
		  $_fe($q);
		  if ($vas) {
		    $vas=$lf.substr($vas,1).";\n";
		    doutW($vas);
		    $ncr++;
		  }
		  logea();
		  if ($nro < $emxrw)
		    break;
		  $pri+=$emxrw;
		}
	      }
	    } // }}}
	  } 
	}
	else {
	  error(sprintf(__("No se especificó ni conexión ni archivo para la bdd %s"),$nbd),$ncte);
	  continue;
	}
	$defbdds[$idb][$ibd]['no']=$ncr;
	// }}}
      }
  }
  // {{{ código en el instalador para bdd
  $phpp.=
'	  if (!$o["skdb"]) {
	    foreach($dsdb as $idb => $sbd) {
	      if ($alt=$sbd["alt"]) {
	        $vv=dechex(crc32($alt));
	        $vv=$v[$vv];
	        if ($vv != $idb) {
	          foreach($sbd as $ibd => $n)
	            if (is_array($n))
	              for($icr=0; $icr < $n["no"]; $icr++)
	                tkBuff();
	          continue;
	        }
	      }
	      foreach(array("ho","pt","us","pw") as $n)
	        if ($nv=$sbd["v$n"]) {
		  $vv=dechex(crc32($nv));
		  $vv=$v[$vv];
	          if (!$vv)
	            salir(sprintf(st("Lvsu"),$nv,$idb));
	          $simu or eval(\'$vv=\'.$vv.";"); // usually due to var_export
	          $con[$n]=$vv;
	        }
	        else
	          $con[$n]=$sbd[$n];
	      if (!$o["dmdb"] and ($ty=$sbd["ty"]) == "mysql")
		if (!$simu) {
		  if (!function_exists("mysql_connect"))
		    loge(sprintf(st("Lfne"),"mysql_connect","mysql"));
		  if ($con["pt"])
		    $con["ho"].=":".$con["pt"];
		  @mysql_connect($con["ho"],$con["us"],$con["pw"]) or
		  salir(sprintf(st("Npcs"),$php_errormsg.@mysql_error()),true);
		}
	      foreach($sbd as $ibd => $n)
	        if (is_array($n)) {
	          if ($nv=$n["vdb"]) {
		    $vv=dechex(crc32($nv));
		    $vv=$v[$vv];
	            if (!$vv)
	              salir(sprintf(st("Lvsu"),$nv,$ibd));
	            $simu or eval(\'$vv=\'.$vv.";");
	            $nbd=$vv;
	          }
	          else
	            $nbd=$n["db"];
		  if ($o["dmdb"]) {
		    if (file_exists("$nbd.dump"))
		      salir(sprintf(st("Npev"),"$nbd.dump"));
		    $simu or $hm=fopen("$nbd.dump","w");
		    $wtg=st("Escr");
		  }
		  else {
		    $wtg=st("Oper");
	            if (!$simu and $ty == "pgsql") {
		      if (!function_exists("pg_connect"))
		        loge(sprintf(st("Lfne"),"pg_connect","PostgreSQL"));
	              if (!@pg_connect("host=\'${con[\'ho\']}\' port=\'${con[\'pt\']}\' user=\'${con[\'us\']}\' password=\'${con[\'pw\']}\' dbname=\'$nbd\'")) {
	                $h=@pg_connect("host=\'${con[\'ho\']}\' port=\'${con[\'pt\']}\' user=\'${con[\'us\']}\' password=\'${con[\'pw\']}\' dbname=template1") or 
		          salir(sprintf(st("Npcs"),$php_errormsg.@pg_last_error()),true);
		        @pg_query("create database \"$nbd\"") or
		          salir(st("Npcb").$php_errormsg.@pg_last_error(),true);
		        loge(sprintf(st("Clbd"),$nbd));
		        @pg_close($h);
		        @pg_connect("host=\'${con[\'ho\']}\' port=\'${con[\'pt\']}\' user=\'${con[\'us\']}\' password=\'${con[\'pw\']}\' dbname=\'$nbd\'")
		          or salir(sprintf(st("Npsb"),$nbd).$php_errormsg.@pg_last_error(),true);
		      }
		    }
		    else
	              if (!$simu and !@mysql_select_db($nbd)) {
	                @mysql_query("create database `$nbd`") or
	                  salir(st("Npcb").$php_errormsg.@mysql_error(),true);
	                loge(sprintf(st("Clbd"),$nbd));
	                @mysql_select_db($nbd) or
	                  salir(sprintf(st("Npsb"),$nbd).$php_errormsg.@mysql_error(),true);
	              }
		  }
	          loge(sprintf(st("Slbd"),$nbd));
	          for($icr=0; $icr < $n["no"]; $icr++) {
	            $cr=tkBuff();
		    loge(sprintf($wtg,substr($cr,0,strpos("$cr(","("))));
		    if (!$simu)
		      if ($o["dmdb"])
		        fwrite($hm,$cr);
		      else if ($ty == "mysql")
	                @mysql_query($cr) or '.(($igno) ? 'loge(sprintf(st("Esae"),@mysql_error(),true))' : 'salir(sprintf(st("Esae"),@mysql_error()),true)').';
		      else
		        @pg_query($cr) or '.(($igno) ? 'loge(sprintf(st("Esae"),@pg_last_error(),true))' : 'salir(sprintf(st("Esae"),@pg_last_error()),true)').';
	          }
	        }
	    }
	  }
	  else
	    loge(st("Bdnp"));
'; // }}}
}
// }}}

// {{{ código del instalador en post para el final
$phpp.=
'	  $tby='.$tby.'; $twr='.$twr.';
	  loge(st("Inco"));
	  if (!$cml)
	    echo "<tr><td class=rtd>\n";
	  if (!$o["nrun"])
	    foreach($run as $nf => $f) {
	      loge(sprintf(st("Eefs"),basename($nf)));
	      $simu or eval("?>$f");
	    }
	  loge(sprintf(st("Tito"),time()-$time));';
// }}}

// {{{ HTML externo e interno
$htmle=
'	<!-- CONT start -->
	<iframe name=cont id=cont class="ifr" src="?wk=1&uniq='.$uniq.'&{QSTR}">{NOFR}</iframe>
	<!-- CONT end -->';
$htmle=intW(qtab($htmle));

$htmli=
'	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<style type="text/css">
	{CSS}
	</style>
	</head>
	<body>
	<script>
	  function mv(po,tb,to) {
	    try {
	      parent.mkProgress(po,tb,to);
	    }
	    catch(e) {}
	  }
	  function sc() {
	    scrollTo(0,document.getElementById("gta").scrollHeight);
	  }
	  mv(0,0,0);
	</script>
	<table id=gta>
';
$htmli=intW(qtab($htmli));

// }}}

// {{{ últimas escrituras internas, debe hacerse antes de _mkI.def
$pbuf=intW(serialize($buf));
$pdsdb=intW(serialize($defbdds));
$pdvars=intW(serialize($defvars));
$pdopt=intW(serialize($myopt)); // solo por -r
$taI=ftell($tmpI);
// }}}

// {{{ _mkI.def
// {{{ quito los 'no' 
foreach($defbdds as $is => $def)
  foreach($def as $idb => $db)
    if (is_array($defbdds[$is][$idb]))
      unset($defbdds[$is][$idb]['no']);
// }}}

// {{{ regenera el fichero $inst
if (!$dtod) {
  $sdv='$defvars='.var_export($defvars,true).";\n".
       '$defbdds='.var_export($defbdds,true).";\n".
       '$myopt='.var_export($myopt,true).";\n".
       '$svbufs='.var_export($svbufs,true).";\n";
  if ($sample)
    $sdv.="
	/*
	\$myopt=array('lic' => en-lic, //shows license
	  'out' => '', // out file
	  'tpl' => '', // template file
	  );
	\$defbdds=array(
	  // template
	  'dbs-on-one-server'=>array(
	    'ty'=>'mysql',		// ignored: mysql server
	    'vho'=>'var',		// index of the variable holding host that must be already defined,
	    'ho'=>'host',		// error: 'vXX' and 'XX' are mutual exclusive
	    'vus'=>'var'		// variable holding user,
	    'us'=>'user',		// error
	    'vpw'=>'var',		// variable holding password,
	    'pw'=>'password',		/error
	    0=>array(
	      'vdb'=>'var',		// variable holding database name',
	      'db'=>'database name',
	      'tc' => array(
		    '+.*+'	// all the tables
	           ),
	      'tp' => array(
	            'pattern of tables to be copied' => array(),
	            'pattern of tables to be copied' => array(),
		    'table name' => array(
			'ins col, ins col, ins col',
			'col for select, col for select', //if empty default to previous
			'select condition',
			),
	            // ...
	           ),
	      ),
	    1=> array(
	      // ...
	      ),
	    ),
	  // sample
	  'mydb'=>array(
	    'ty'=>'mysql',		// ignored
	    'ho'=>'localhost',	// fixed
	    'vus'=>'dbUser',
	    'vpw'=>'dbPwd',
	    'onedb'=>array(
	      'vdb'=>'dbName',
	      'tc' => array(), // empty: all the current tables
	      'tp' => array(
		'mytable' => array( cols=> 'col1,col2,col3', 'sql' => 'select col1,5555,col3 from mytable where col1 < 456'),
		'myothertable' => array( cols => '*', sql => 'select * from myothertable where col4 > 999') ,
		'+^data.*+' => array(),
		),
	      ),
	    ),
	   ); */";
// }}}
// {{{ crea el _mkI...
  $tmp=$inst.uniqid('f');
  creadir($inst);
  if (@filesize($inst) == 0)
    @unlink($inst); // para que no se quede vacío
  $h=fopen($tmp,'wb') or error(__('No puedo crear ficheros'));
  fwrite($h,"<?php //!! Do not modify this line\n$sdv\n?>");
  fclose($h);
  unset($defvars); // tranki
  eval('?>'.file_get_contents($tmp).'<?php ');
  if ($defvars or $defbdds or $svbufs) {
    @unlink($inst);
    if (!rename($tmp,$inst)) {
      copy($tmp,$inst) or error(__('No puedo crear ficheros'));
      @unlink($tmp);
    }
    logea(sprintf(__("Fichero %s regenerado"),$inst));
  }
  else {
    // readfile($tmp); // lo muestra
    unlink($tmp);
    error(sprintf(__("No puedo generar el fichero %s correctamente, causas posibles:\n - ninguna variable definida\n - error interno"),$inst));
  }
}
// }}}
// }}}

// {{{ código  del instalador

if ($ver)
  $xver='
	    $cver='.var_export($ver,true).';
	    if (!$exsfn and function_exists("file_get_contents"))
	      $ver=trim(@file_get_contents("'.$vUrl.'?cur=".urlencode($cver)));
	    if ($ver and ($ver != $cver) and function_exists(preg_match)) {
	      if ($_REQUEST["unv"]) {
		$cont=htmlentities(st("Cont"));
	        if ($nv=@file_get_contents($ver) and @fwrite(@fopen("$sfn","w"),$nv))
		  die("<tr><td id=wvr><a target=_top href=\"?\">$cont</a>");
		else
		  echo "<tr><td id=wvr>".htmlentities(st("Nspu"));
	      }
	      else {
		echo "<tr><td id=wvr>".htmlentities(st("Aeuv"));
		if (preg_match("%^https?://%",$ver) and $nv=@file_get_contents($ver))
		  echo "<tr><td id=wvr><a href=\"?{$_SERVER[\'QUERY_STRING\']}&unv=1\">".htmlentities(st("Dyul"))."</a>";
	      }
	    }';

$php=
'	<?php

	// '.strftime("%c").'
	// built with mkinstaller '.$mver.' by Manuel Mollar (mm AT nisu.org) http://mkInstaller.nisu.org/
	// do not remove this Copyright

	$ilic='.var_export($ili,true).';

	error_reporting('.(($myopt['err']) ? $myopt['err'] : 'E_ALL ^ E_NOTICE').');
	ini_set(track_errors,true);'.(($myopt['ses']) ? '
	session_start();' :'').'
	$lg=detLang($_REQUEST["lang"],"'.$idpr.'");'.(($myopt['ses']) ? '
	$_SESSION["lang"]=$lg;' :'').'
	foreach(array('.(($cmpr) ? '"gzdeflate"=>"zlib", ' : '').') as $f => $p)
	  if (!function_exists($f))
	    salir(sprintf(st("Lfne"),$f,$p));
	$hhost=$_SERVER["HTTP_HOST"];
	if ($exsfn=$_REQUEST["scfn"])
	  $sfn=$exsfn;
	else if ($hhost)
	  $sfn=$_SERVER["SCRIPT_FILENAME"];
	else
	  $sfn=$argv[0];
	$fin=@fopen($sfn,"rb") or
	  salir(st("Eali"));
	$pidi=strpos(fread($fin,I000000000),"\n?>")+3;
'.$imgsa.(($dataf) ? $dataf : '$pidd=$pidi+'.$taI.';').'
	$files=unserialize(tkInBuff('.$pbuf.'));
	$dsdb=unserialize(tkInBuff('.$pdsdb.'));
	$dvars=unserialize(tkInBuff('.$pdvars.'));
	$plans='.myexp($plans).';'.(($lics) ? '
	$lics='.myexp($lics).';' : '').'
	$css='.$cssi.';
	$uniq="'.$uniq.'";'.(($myopt['chr']) ? "
	header('Content-type: text/html; charset={$myopt['chr']}');" : '').'
	if ($j=$_REQUEST["jmp"]) {
	  foreach($files as $fic)
	    if ($fic["j"] == $j)
	      $simu or eval("?>".trim(tkInBuff($fic["po"])));
	  die();
	}
	if ($info'.(($myopt['inf']) ? ' or $minfo=($argv[1] == "--info" or $_GET["info"])' : '').') {
	  '.$imgsai.'$dopt=unserialize(tkInBuff('.$pdopt.'));
	}
	if ($info)
	  return;'.(($myopt['inf']) ? '
	if ($minfo) {
	  eval(file_get_contents("http://mkInstaller.nisu.org/mkInfo.php"));
	  die();
	}' : '').'

	$simu'.$fsimu.' or $simu=$_REQUEST["simu"];
	$tby=$twr=$taa=0; $ma=""; $smo='.(isset($myopt['smo']) ? $myopt['smo'] : "0.5").'; $buf=false;
	
	'.(($myopt['nld'] && $myopt['nsv'] && !$myopt['cip']) ? '' : '
	loadPi();' // era preciso cargarlo aunque no se use porque determinaba el nombre del sav, lo dejo
	).'
	if ($argv[1]) {
	  $cml=true;
	  $brk="\n";
	  $vo=array();
	  foreach($dvars as $var => $def) {
	    if (isset($def["vl"]))
	      $val=$def["vl"];
	    else {
	      $d=$def["df"];
	      if ($def["ml"] and is_array($d))
		if($dlg=$d[$lg])
		  $d=$dlg;
		else
		  $d=current($d);
	      if (is_array($d)) {
	        if ($se=$def["se"]) {
		  $d=array_keys($d);
		  $se=$d[$se-1];
		}
		else
	          $se=key($d);
	        eval(\'$val=\'."$se;");
	      }
	      else
	        eval(\'$val=\'.$d.";");
	    }
	    $vo[$var]=$val;
	  }
	  for($i=1; $i<$argc; $i++) {
	    list($var,$val)=explode("=",$argv[$i]);
	    if ($val)
	      $vo[dechex(crc32($var))]=$val;
	    else
	      $o[$var]=true;
	  }
	  $ve=$v=$vo;
	  if (!$simu)
	    foreach($dvars as $var => $def) {
	      $val=$v[$var];
	      if ($def["ev"]) {
	        if (@eval(\'$val=\'.$val.";") === false)
	          salir(st("ExIn")."\n".$val."\n".$php_errormsg);
	        $ve[$var]=$val;
	      }
	      if (!$ve[$var] && $o["intc"]) {
	        echo $def["va"],": ";
		$ve[$var]=substr(fgets(STDIN),0,-1);
	      }
	    }
	  $v=$ve;
	  foreach($dvars as $var => $def) {
	    if ((($val=$v[$var]) === "") and ($em=$def["em"]))
	      $v[$var]=$val=$v[$em];
	    if ($def["st"])
	      $v[$var]=var_export($val,true);
	  }
	  $doit=true;
	}
	else if ($_REQUEST["doit"]) {
	  $brk="<br>";
	  $cml=(!$_REQUEST["jsav"]);
	  if (!$cml) {
	    ob_start(); $buf=true;
	  }
	  $o=&$_REQUEST;
	  if ($vo=$_REQUEST["v"])
	    foreach($vo as $var => $val) {
	      if (get_magic_quotes_gpc())
	        $vo[$var]=stripslashes($val);
	    }
	  $ve=$v=$vo;
'.		// los eval pueden ir en funcion de $v, debo mantener $v y $ve simult y $vo para savePi
'	  if (!$simu)
	    foreach($dvars as $var => $def) {
	      $val=$v[$var];
	      if ($def["ev"]) {
	        if (@eval(\'$val=\'.$val.";") === false)
	          salir(st("ExIn")."<br>".$val."<br>".$php_errormsg,true);
	        $ve[$var]=$val;
	      }
	    }
	  $v=$ve;
	  foreach($dvars as $var => $def) {
	    if ((($val=$v[$var]) === "") and ($em=$def["em"]))
	      $v[$var]=$val=$v[$em];'.(($myopt['ses']) ? '
	    $_SESSION["ve"][$var]=$val;' :'').'
	    if ($def["st"])
	      $v[$var]=var_export($val,true);
	  }
	  $doit=true;
	}
	else
	  $doit=false;
	
	if ($doit) {
'.$acli.
'	  $time=time();
	  if (!$cml) {
	    header("Pragma: no-cache"); header("Cache-control: no-cache");
	    echo str_replace("{CSS}",tkInBuff($css),tkInBuff('.$htmli.'));
	    echo "<script> try { parent.chStep(\'2\'); } catch(e) {} </script>";
	    echo "<tr><td id=ftd>\n";
	  }
	  $simu and loge(st("Sosi"));
	  if (!$o["nrun"])
	    foreach($files as $fic) {
	      if ($fic["x"] == "f") {
		$nf=$fic["n"];
		loge(sprintf(st("Pefs"),$nf));
	        loge(sprintf(st("Eefs"),$nf));
		$f=trim(tkInBuff($fic["po"]));
		parsea($f);
	        $simu or eval("?>$f");
	      }
	    }
'. // quito los ficheros j y f, los f porque son 'p' y los intentaria cojer del fichero de datos y los j porque son 'x' y a saber ...
'	  foreach($files as $if => $fic)
	    if ($fic["j"] or $fic["x"] == "f")
	      unset($files[$if]);
	  @ob_end_flush(); $buf=false;
	  if (!$cml)
	    echo "<tr><td id=gtd>\n";
'.$phpp.($myopt['nsv'] ? '' : '
	  $simu or savePi();').'
	  if (!$cml)
	    echo"</table>\n<script>try { parent.chStep(\'3\'); } catch(e) {} </script></body>\n</html>";
	}
	else if($hhost) {
	  header("Pragma: no-cache"); header("Cache-control: no-cache");
	  if ($_REQUEST["wk"]) {
	    ob_start(); $buf=true;
	    echo str_replace("{CSS}",tkInBuff($css),tkInBuff('.$htmli.'));
	    echo "<script> try { parent.chStep(\'1\'); } catch(e) {} </script>";
	    $cml=false; '.$xver.'
	    echo "<tr><td id=ftd>\n";
	    $simu and loge(st("Sosi"));
	    '.(($tsfm) ? 'if (!$simu and ini_get("safe_mode")) {
	      loge(st("Einp"));
	      sleep(2);
	    }' : '').'
	    if (!@touch($tmf=uniqid("mktest"))) {
	      loge(sprintf(st("Anpc"),getcwd()),true);
	      loge($php_errormsg);
	    }
	    @unlink($tmf);
	    foreach($files as $if => $fic) {
	      if ($fic["x"] == "l")
		$simu or eval("?>".trim(tkInBuff($fic["po"])));
	    }
	    @ob_end_flush(); $buf=false;
	    echo "<tr><td id=gtd>\n".
	      "<form method=post id=for>\n".
	      "<script>document.write(\'<input type=hidden name=jsav value=1>\');</script>\n";
'.$phpg.
'	    echo "</form>\n<script>mv(100,'.$tby.','.$twr.');</script>\n</table>\n</body></html>";
	  }
	  else {
	    if (!$p=$plans[$lg])
	      $p=$plans["'.$pid.'"];
	    echo str_replace("{CONT}",str_replace(array("{NOFR}","{QSTR}"),
			array(st("Papc"),$_SERVER["QUERY_STRING"]),tkInBuff('.$htmle.')),tkInBuff($p));
	  }
	}
	else {
	  $cml=true;
	  foreach($files as $if => $fic) {
	    if ($fic["x"] == "l")
	      $simu or eval("?>".trim(tkInBuff($fic["po"])));
	  }
	  salir(st("Dppa"));
	}
	die();
	
	'.$deftk.'
	function parsea(&$f) {
	  global $dvars, $v, $uniq;
	  foreach($dvars as $var => $va) {
	    $val=$v[$var];
	    if (!$va["prt"]) {
	      if ($va["ty"] == "password")
	        loge($va["va"]."=********");
	      else {
	        $nlval=explode("\n",$val);
	        loge($va["va"]."=".$nlval[0]);
	      }
	      $dvars[$var]["prt"]=true;
	    }
	    $f=str_replace("$uniq.$".$va["va"].".$uniq",$val,$f);
	  }
	}
	function &gDfVar($n) {
	  global $dvars;
	  return $dvars[dechex(crc32($n))];
	}
	function gValVar($n) {
	  global $v;
	  return $v[dechex(crc32($n))];
	}
	function loge($m,$lit=false) {
	  global $cml, $tby, $twr, $brk, $ma, $taa, $buf, $smo;
	  $ta=floor(100*($tby/'.$tby.'*$smo+$twr/'.$twr.'*(1-$smo)));
	  if (($ma != $m) or ($taa != $ta))
	    if ($cml) {
	      if (function_exists("preg_replace"))
	        $m=preg_replace("/<[^>]*>/","",$m);
	      echo "$m ($ta%,$tby,$twr)$brk";
	    }
	    else {
	      $sc="";
	      if ($ma != $m) {
	        if ($lit)
		  echo "$m<br>";
		else
	          echo htmlentities($m)."<br>";
		$sc.="sc();";
	      }
	      if ($taa != $ta)
	        $sc.="mv($ta,$tby,$twr);";
	      echo "<script>$sc</script>\n";
	    }
	  $ma=$m;
	  $taa=$ta;
	  $buf or flush();
	  return true;
	}
	function salir($m,$lit=false) {
	  loge("\n      $m",$lit);
	  echo "\n";
	  die(intval($m != ""));
	}
	
	function mkdr($dir, $mode = 0755) {
	  if (is_dir($dir) || (@mkdir($dir) && @chmod($dir,$mode))) return true;
	  if (!mkdr(dirname($dir),$mode)) return false;
	  return (@mkdir($dir) && @chmod($dir,$mode));
	}
	
	function crd($f, $m = 0755) {
	  if (!mkdr($d=dirname($f),$m))
	    salir(sprintf(st("Npce"),$d));
	  return true;
	}
	
	function st($id) {
	  global $mg,$lg;
	  if (is_array($id))
	    $p=$id;
	  else {
	    if (!is_array($mg))
'.	      // dos casos $cmpr o no , pero supongo que serialize esta siempre
(($cmpr) ?
'	      $mg=unserialize(\''.serialize($iipgmg).'\');' :
'	      $mg=unserialize(\''.serialize(array_merge($iipgmg,$ipgmg)).'\');'  ).'
	    if (!$mg[$id]) {
'.(($cmpr) ?    // si comprime, en dos pasos mas, el primero parte de que van b64 y gz , pero quiza no puede leer del fichero
'	      $mg=array_merge(unserialize(gzinflate(base64_decode(\''.base64_encode(gzdeflate(serialize($ipgmg))).'\'))),$mg);
' : '').
'	      $mg=array_merge(unserialize(tkInBuff('.$ppgmg.')),$mg); 
	    }
	    $p=&$mg[$id];
	  }
	  if (!$lg)
	    $lg="'.$idpr.'";
	  if ($m=&$p[$lg])
	    return $m;
	  else if ($m=&$p["'.$idpr.'"])
	    return $m;
	  else
	    return $p["en"];
	}
	function detLang($re,$df) {
	  global $dvars;
	  if ($re)
	    return $re;'.(($myopt['ses']) ? '
	  if ($l=$_SESSION["lang"])
	    return $l;' :'').'
'.	  // necesito la lista de idiomas
          // la podria sacar de $defvars, pero $defvars esta en tkInbuff y necesito los idiomas antes que nada
'	  $lgs='.myexp($tids).';
'.	  //foreach(preg_split(\'/,/\',
	  //    preg_replace(\'/;.*/\',\'\',
	  //      strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])))
'	  list($acp)=explode(";",strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]));
	  foreach(explode(",",$acp) as $la)
	    if ($lgs[$la])
	      return $la;
	  if (!$la)
	    $la=substr(setlocale(LC_ALL,""),0,2);
	  if ($la)
	    return $la;
	  else
	    return $df;
	}'.(($myopt['nld'] && $myopt['nsv'] && !$myopt['cip']) ? '' : '
	function loadPi() {
	  global $dvars, $reInst, $iip;
	  if (!$c=@file_get_contents("'.$lst.dechex(crc32($nam)).'.php"))
	    return false;
	  if (substr($c,0,10) != "<?php //!!")
	    return false;
	  $reInst=true;
	  @eval("?>$c<?php ");
	  '.($myopt['cip'] ? // $iip usada desde envol.php
	  'if (!$iip and $sip and $_SERVER["REMOTE_ADDR"] != $sip)
	    salir(st("Didl"));
	  ' : '').($myopt['nld'] ? '' : 'if (!$pdv)
	    return false;
	  if ($_REQUEST["nsav"])
	    return false;
	  foreach($dvars as $v => $vv)
	    if (is_array($pd=$pdv[$v]))
	      $dvars[$v]["vl"]=$pd["vl"];').'
	  return true;
	}').($myopt['nsv'] ? '' : '
	function savePi() {
	  global $dvars, $vo, $o;
	  if ($_REQUEST["nsav"] or $o["nsav"])'. // nsv se pondrá por porgramacion con -f load o -f run
'
	    return false;
	  $pdv=array();
	  foreach($dvars as $vv => $vvv)
	    if (!$vvv["ns"])
	      $pdv[$vv]["vl"]=$vo[$vv];
	  $h=@fopen($fPi="'.$lst.dechex(crc32($nam)).'.php","w");
	  @fwrite($h,"<?php //!!\n'.($myopt['cip'] ? '\$sip=\'{$_SERVER["REMOTE_ADDR"]}\';\n' : '').'\$pdv=".var_export($pdv,true).";\n?>");
	  @fclose($h);
	  @chmod($fPi,0600);
	  return true;
	}').'
	?>';
$php=qtab($php);

// }}}

// {{{ por fin escribe el instalador
$taphp=strlen($php);
// permite editar hasta 50k más de código sobre el instalador construido
$php=str_replace("I000000000",($taphp+50000),$php);

// fichero instalador
if ($dtod) {
  $ar=explode('==',$dtod);
  $dtod=$ar[0];
  if (!dtod)
    error(__("Debe especificarse un directorio de salida con -u"));
  $outf=tempnam('','mk');
  $ar[0]=$outf;
}

if ($fkey=$myopt['key']) {
  if ($pwd=$myopt['pwd'])
    $rpwd=getenv($pwd);
  while (!$key=@openssl_pkey_get_private("file://$fkey",$rpwd)) {
    logea(sprintf(__("*** Falló la carga de la llave privada con la contraseña tomada de la variable %s, firma no generada\nEscriba la contraseña (CON ECO): "),$pwd));
    $rpwd=trim(fgets(STDIN));
    if (!$rpwd) {
      unset($key);
      break;
    }
  }
}

if ($outf) {
  creadir($outf);
  if (!$h=@fopen($outf,"wb") or (fwrite($h,$php) === false))
    error(sprintf(__("No puedo crear el fichero %s"),$outf));
}
else if ($xcml)
  logea(__('Instalador no generado en stdout'));
else {
  echo $php;
  if ($key)
    logea(__('*** Firma no generada en stdout'));
}

fseek($tmpI,0);
while (true) {
  $b=fread($tmpI,$peaso);
  if ($outf)
    fwrite($h,$b);
  else if (!$xcml)
    echo $b;
  if (strlen($b) < $peaso)
    break;
}

if ($big) {
  fclose($dout);
  logea(sprintf(__("Escrito el fichero de datos %s"),$outd));
  if ($key) {
    $hash=sha1_file($outd);
    if (openssl_private_encrypt(serialize(array('hash'=>$hash,'time'=>time())),$sig,$key)) {
      fwrite($h2=fopen("$outd.sig","wb"),base64_encode($sig)); fclose($h2);
      logea(sprintf(__("Escrito el fichero de firma %s"),"$outd.sig"));
    }
    else
      logea(__('La firma ha fallado: ').openssl_error_string());
  }
}
else {
  fseek($dout,0);
  while (true) {
    $b=fread($dout,$peaso);
    if ($outf)
      fwrite($h,$b);
    else if (!$xcml)
      echo $b;
    if (strlen($b) < $peaso)
      break;
  }
}
if ($outf) {
  fclose($h);
  if ($key) {
    $hash=sha1_file($outf);
    if (openssl_private_encrypt(serialize(array('hash'=>$hash,'time'=>time())),$sig,$key)) {
      fwrite($h2=fopen("$outf.sig","wb"),base64_encode($sig)); fclose($h2);
      logea(sprintf(__("Escrito el fichero de firma %s"),"$outf.sig"));
    }
    else
      logea(__('La firma ha fallado: ').openssl_error_string());
  }
  if ($dtod) {
    list($maq,$dtod)=explode(':',$dtod);
    $ar[]='doit';
    $s='';
    foreach(array_slice($ar,1) as $v)
      $s.=" '$v'";
    if ($dtod) {
      system("ssh <'$outf' '$maq' \"mkdir -p '$dtod' && cd '$dtod' && cat >'$uniq' && php -qC -d 'memory_limit=-1' '$uniq'$s ; rm -f '$uniq'\"");
    }
    else {
      $dtod=$maq;
      $argv=$ar;
      chdir($dtod);
      require($outf);
    }
    unlink($outf);
  }
  else {
    logea(sprintf(__("Escrito el instalador %s"),$outf));
    if (($tam=filesize($outf)/1024/1024) > 4) {
      logea(sprintf(__("** El fichero %s es muy grande (%1.1fM), puede que no pueda cargarse"),$outf,$tam));
      if ($big)
        logea(__("** Intenta reducir las plantillas/imagenes usadas"));
      else
        logea(__("** Considera la opción de usar -o big en lugar de -o out"));
    }
  }
}
// }}}

// {{{ parseSql
function parseSql($h) {
  global $peaso;
  $e=i; $s=''; $no=0;
  while (true) {
    $b=fread($h,$peaso);
    if (!$l=strlen($b))
      break;
    for ($i=0; $i<$l; $i++) {
      $c=$b[$i];
      switch ($e) {
	case i:
          if ($c == '\\' and $pl) $e=cm;
	  else { $pl=false;
            if ($c == "\n") { $s.=' '; $pl=true; }
            else if ($c == ';') { $s=trim(strtr($s,"\n"," ")); if ($s) { $no++; doutW($s); $s=''; }}
	    else if ($c == '/') $e=pcb;
	    else if ($c == '-') $e=pcm;
	    else if ($c == "'") { $e=ens; $s.=$c; }
	    else $s.=$c;
	  }
	  break;
	case ens:
          if ($c == '\\') $e=es;
	  else if ($c == "'") $e=i;
	  $s.=$c;
	  break;
	case es:
          $s.=$c;
	  $e=ens;
	  break;
	case pcb:
          if ($c == '*') $e=cb;
	  else { $s.='/';
            if ($c == "\n") { $s.=' '; $pl=true; }
	    else if ($c == '-') $e=pcm;
	    else if ($c == "'") { $e=ens; $s.=$c; }
	    else if ($c != '/') { $s.=$c; $e=i; }
	  }
	  break;
	case cb:
	  if ($c == '*') $e=pscb;
	  break;
	case pscb:
          if ($c == '/') $e=i;
	  else $e=cb;
	  break;
	case pcm:
          if ($c == '-') $e=cm;
	  else {
	    $s.='-';
            if ($c == "\n") { $s.=' '; $pl=true; }
	    else if ($c == '/') $e=pcb;
	    else if ($c == "'") { $e=ens; $s.=$c; }
	    else if ($c != '-') { $s.=$c; $e=i; }
	  }
	  break;
	case cm:
          if ($c == "\n") {
	    $pl=true;
	    $e=i;
	  }
	  break;
      }
    }
  }
  return $no;
}
// }}}

// {{{ mmGetText
/* mmGetText start */

function mmIniStr($my) {
  global $lang_lang;
  $lang_lang=array(
    ' *** Binario ***' => array(
      'ca' => ' *** Binari ***',
      'en' => ' *** Binary ***', ),
    '%d comentarios eliminadas por mkInstaller' => array(
      'ca' => '%d comentaris eliminats per mkInstaller',
      'en' => '%d comments removed by mkInstaller', ),
    '%d líneas de código de depuración eliminadas por mkInstaller' => array(
      'ca' => '%d llinies de codig de depuració eliminades per mkInstaller',
      'en' => '%d lines of debug code removed by mkInstaller', ),
    '%s ya existe' => array(
      'ca' => '%s ja existeix',
      'en' => '%s already exists', ),
    '** Considera la opción de usar -o big en lugar de -o out' => array(
      'ca' => 'Considera la opció de fer servir -o big en lloc de -o out',
      'en' => 'Consider the option of using -o big instead of -o out', ),
    '** Debería especificar una licencia con -o lic' => array(
      'ca' => '** Deurie de especificar una llicencia de us amb -o lic',
      'en' => '** You should especify a license with -o lic', ),
    '** Definición de base de datos %s ignorada, ya existe una igual' => array(
      'ca' => '** Definició de base de dades %s ignorada, ja existeix una igual',
      'en' => '** Data base definition %s ignored, already exists', ),
    '** El fichero %s es muy grande (%1.1fM), puede que no pueda cargarse' => array(
      'ca' => '** El arxiu es molt gran (%1.1fM), pot ser que no puga carregarse',
      'en' => '** The file is very big (%1.1fM), perhaps it cannot be loaded', ),
    '** El patrón \'%s\' no corresponde con ninguna tabla' => array(
      'ca' => '** El patró \'%s\' no es correspon amb cap taula',
      'en' => '** The pattern \'%s\' does not match any table', ),
    '** Estableciendo como lista de tablas la lista actual' => array(
      'ca' => '** Estableint com a llista de taules la llista actual',
      'en' => '** Settin as list of tables the current list', ),
    '** Idioma %s no totalmente soportado' => array(
      'ca' => '** Idioma %s no totalment soportat',
      'en' => '** Language %s not fully supported', ),
    '** Intenta reducir las plantillas/imagenes usadas' => array(
      'ca' => '** Intenta reduir les plantilles/imatges emprades',
      'en' => '** Try to reduce the used templates/images', ),
    '** La inclusión de nombres de fichero no-relativos puede s-3032891603' => array(
      'ca' => '** La inclusió de noms de arxiu no-relatius pot ser perillosa: %s',
      'en' => '** The inclussion of non relative filenames can be dangerous: %s', ),
    '** La variable %s ya no está en las fuentes' => array(
      'ca' => '** La variable %s ya no está en les fonts',
      'en' => '** The variable %s is not yet in the sources', ),
    '** Licencia del instalador por defecto, debería usar -o ili' => array(
      'ca' => '** Llicencia del instal.lador per defecte, deuríe emprar -o ili',
      'en' => '** Default installer license, you should use -o ili', ),
    '** No existe el fichero %s para %s, cojo el de %s' => array(
      'ca' => '** No existeix el arxiu %s per a %s, agafe el de %s',
      'en' => '** The %s file for %s does not exists, taking %s', ),
    '** No puedo conectar con el servidor mysql actual, puede s-854983643' => array(
      'ca' => '** No puc conectar amb el servidor mysql actual, pot ser normal si es fa servir un arxiu de dades,'."\n".
       ' conexió actual: \'%s\' , \'%s\' , \'%s\'',
      'en' => '** Cannot connect with current mysql server, may be normal is a data file is employed,'."\n".
       ' current connection: \'%s\' , \'%s\' , \'%s\'', ),
    '** Ponga un nombre a su aplicación' => array(
      'ca' => '** Done-li un nom a la seva aplicació',
      'en' => '** Give a name to your application', ),
    '** Revise la definicin de la varible autodefinida %s' => array(
      'ca' => '** Revise la definici de la variable autodefinida %s',
      'en' => '** Rewiev the definition of the autodefined variable %s', ),
    '** Usando la opción peligrosa \'drp\' => drop tables' => array(
      'ca' => '** Fent servir la opcio perillosa \'drp\' => drop tables',
      'en' => '** Using dangerous option \'drp\' => drop tables', ),
    '** Valor por defecto para %s : %s' => array(
      'ca' => '** Valor per defecte per a %s : %s',
      'en' => '** Default value for %s : %s', ),
    '*** El procesamiento de %s ha producido un error sintáctico' => array(
      'ca' => '*** El processament de %s ha produit una errada sintàctica',
      'en' => '*** Processing %s has produced syntax error', ),
    '*** Falló la carga de la llave privada con la contraseña t-1607244275' => array(
      'ca' => 'Ha fallat la càrrega de la clau privada fent servir la contraseña de la variable %s, la firma no se ha generat'."\n".
       'Escriga la paraula de pas (AMB ECO): ',
      'en' => 'The loading of the private key has failed using the password stored in variable %s, signature not generated'."\n".
       'Type in the password (WITH ECHO): ', ),
    '*** Firma no generada en stdout' => array(
      'ca' => '*** Signatura no generada en stdout',
      'en' => '*** Signature not generated in stdout', ),
    '*** La carga de %s ha producido un error sintáctico' => array(
      'ca' => '*** La carrega de %s ha produit una errada sintàctica',
      'en' => '*** loading of %s has produced a syntactic error', ),
    '*** La ejecución de %s ha producido un error, %s no filtra-2114977031' => array(
      'ca' => '*** La ejecució de %s ha produit una errada, %s no ha segut filtrat, sense canvis',
      'en' => '*** The execution of %d has produced an error, %s not filtered, unchanged', ),
    '*** No puedo comprobar la firma, no hay soporte OpenSSL' => array(
      'ca' => '*** No puc verificar la signatura, no hi ha suport OpenSSL',
      'en' => '*** Cannot verify the signature, OpenSSL support missing', ),
    '-d host==user==passw==database[==type[:port][==[+]file]]'."\n".
     'C-1796139491' => array(
      'ca' => '-d host==user==passw==database[==type[:port][==[+]file]]'."\n".
       'Cada camp: host, port, database, usuari y pass es, o be : valor, o be variable'."\n".
       'Si especifica tipus (i fitxer), el tipus deu de ser mysql o pgsql',
      'en' => '-d host==user==passw==database[==type[:port][==[+]file]]'."\n".
       'Every field: host, port, database, user and pass is, or : value, or variable'."\n".
       'If type (and file) are specified, type must be mysql or pgsql', ),
    'Actualizando %s' => array(
      'ca' => 'Actualizant %s',
      'en' => 'Updating %s', ),
    'Añado variable %s al fichero de definiciones' => array(
      'ca' => 'Afegix variable %s al arxiu de definicions',
      'en' => 'Adding variable %s to definitions file', ),
    'Base de datos ' => array(
      'ca' => 'Base de dades',
      'en' => 'Data base', ),
    'Base de datos %s' => array(
      'ca' => 'Base de dades %s',
      'en' => 'Data base %s', ),
    'Cambios' => array(
      'ca' => 'Canvis',
      'en' => 'Changes', ),
    'Construido con' => array(
      'ca' => 'Construit amb',
      'en' => 'Built with', ),
    'Contraseña' => array(
      'ca' => 'Paraula de pas',
      'en' => 'Password', ),
    'Crea tabla %s' => array(
      'ca' => 'Crea taula %s',
      'en' => 'Create table %s', ),
    'Debe especificarse un directorio de salida con -u' => array(
      'ca' => 'Deu de especificarse un directori de eixida amb -u',
      'en' => 'With -u, an output directory must be specified', ),
    'Descargado %s'."\n" => array(
      'ca' => 'Descarregat %s',
      'en' => '%s downloaded', ),
    'Descargando ...' => array(
      'ca' => 'Descarregant ...',
      'en' => 'Downloading ...', ),
    'Detecto etiqueta \'%s\' para %s, idioma %s' => array(
      'ca' => 'Detecte eitqueta \'%s\' per a %s, idioma %s',
      'en' => 'Detected label \'%s\' for %s, language %s', ),
    'Detecto variable %s de valor %s' => array(
      'ca' => 'Detecte variable %s de valor %s',
      'en' => 'Dectect variable %s with value %s', ),
    'Disponible una nueva versión de mkInstaller' => array(
      'ca' => 'Es disposa d\'una nova versió de mkInstaller',
      'en' => 'A new version of mkInstaller is available', ),
    'Disponible una nueva versión de mkInstaller, puede usar -D-1093888853' => array(
      'ca' => 'Es disposa d\'una nova versió de mkInstaller, pot emprar -D per a instal.larla',
      'en' => 'A new version of mkInstaller is available, you can use -D to install it', ),
    'El fichero %s %s no corresponde con ningún idioma definido' => array(
      'ca' => 'El arxiu de %s %s no es correspon amb cap idioma definit',
      'en' => 'The %s file %s do not correspond to any defined language', ),
    'El fichero %s no existe' => array(
      'ca' => 'El arxiu %s no existeix',
      'en' => 'The file %s does not exists', ),
    'El fichero %s no existe o no es un instalador' => array(
      'ca' => 'El arxiu %s no existeix o no es un instal.lador',
      'en' => 'The file %s does not exist or is not an installer', ),
    'El fichero \'%s\' no es válido' => array(
      'ca' => 'El arxiu \'%s\' no vàlid',
      'en' => 'The file \'%s\' is not valid', ),
    'Error en %s' => array(
      'ca' => 'Error en %s',
      'en' => 'Error in %s', ),
    'Escrito el fichero de datos %s' => array(
      'ca' => 'Escrit el arxiu de dades %s',
      'en' => 'Data file %s written', ),
    'Escrito el fichero de firma %s' => array(
      'ca' => 'Escrit el arxiu de signatura %s',
      'en' => 'Signature file %s written', ),
    'Escrito el instalador %s' => array(
      'ca' => 'Escrit el instalador %s',
      'en' => 'Installer %s written', ),
    'Esta versión de mkInstaller tiene problemas graves, debe s-3989198745' => array(
      'ca' => 'Esta versió de mkInstaller te problemes greus, deu de ser actualitzada',
      'en' => 'This version of mkInstaller has problems, must be updated', ),
    'Este tipo de fichero no es parseable: %s' => array(
      'ca' => 'Este tipus de arxiu no es parsejable: %s',
      'en' => 'This type of file is not parseable: %s', ),
    'Fallo en contenido' => array(
      'ca' => 'Falla en el contingut',
      'en' => 'Content failure', ),
    'Fallo en firma ' => array(
      'ca' => 'Falla en la signatura',
      'en' => 'Signature failure', ),
    'Fallo en la descarga' => array(
      'ca' => 'Falla en la descarrega',
      'en' => 'Download failure', ),
    'Fallo en la descarga de %s' => array(
      'ca' => 'Falla en la descarrega de %s',
      'en' => 'Failure downloading %s', ),
    'Fichero %s regenerado' => array(
      'ca' => 'Arxiu %s regenerat',
      'en' => 'Regenerated file %s', ),
    'Ficheros disponibles' => array(
      'ca' => 'Arxius disponibles',
      'en' => 'Avaiable files', ),
    'Fin' => array(
      'ca' => 'Fi',
      'en' => 'End', ),
    'Fin de ' => array(
      'ca' => 'Fi de ',
      'en' => 'End of ', ),
    'Idioma principal: %s' => array(
      'ca' => 'Idioma principal',
      'en' => 'Main language: %s', ),
    'Inicio de ' => array(
      'ca' => 'Inici de ',
      'en' => 'Start of ', ),
    'Instalada' => array(
      'ca' => 'Instal.lada',
      'en' => 'Installed', ),
    'Instalador no generado en stdout' => array(
      'ca' => 'Instal.lador no generat en stdout',
      'en' => 'Installer not generated in stdout', ),
    'Instalador para %s' => array(
      'ca' => 'Instal.lador per a %s',
      'en' => 'Installer for %s', ),
    'Instalador para %s - Construido con mkInstaller' => array(
      'ca' => 'Instal.lador per a %s - Construit amb mkInstaller',
      'en' => 'Installer for %s - Built with mkInstaller', ),
    'Interface web de %s' => array(
      'ca' => 'Interficie web de %s',
      'en' => '%s web interface', ),
    'Introduzca el valor de la variable <i>%s</i>' => array(
      'ca' => 'Introdueixca el valor de la variable <i>%s</i>',
      'en' => 'Type the value of variable <i>%s</i>', ),
    'La definición de bdd %s contiene %s y v%s ambos definidos' => array(
      'ca' => 'La definició de bdd %s conté %s i v%s els dues definits',
      'en' => 'The definition of db %s contains %s and v%s both defined', ),
    'La definición de bdd %s de %s contiene db y vdb ambos definidos' => array(
      'ca' => 'La definició de bdd %s de %s conté db i vdb els dues definits',
      'en' => 'The definition of db %s of %s contains db and vdb both defined', ),
    'La firma ha fallado: ' => array(
      'ca' => 'La signatura ha fallat: ',
      'en' => 'Signature has failed: ', ),
    'La función %s no está disponible, revisa el modulo php %s'."\n".
     '-692263411' => array(
      'ca' => 'La funció %s no esta disponible, revisa el mòdul php %s'."\n".
       'Es posible que mkInstaller no funcione correctament',
      'en' => 'The php function %s is not available, review the php modul %s'."\n".
       'Is possible than mkInstaller do not work properly', ),
    'La opción \'drp\' ha quedado desactivada' => array(
      'ca' => 'La opció \'drp\' ha quedat desactivada',
      'en' => 'The \'drp\' option has bee disabled', ),
    'La variable %s usada en la def de bdd %s no está definida -3835832309' => array(
      'ca' => 'La variable %s usada en la def de la bdd %s de %s no està definida o no te valor actual',
      'en' => 'The variable %s used in the def of db of %s is not defined or has not actual value', ),
    'La variable %s usada para el nombre de la bdd %s de %s no -4292040829' => array(
      'ca' => 'La variable %s usada per al nom de la bdd %s de %s no està definida o no te valor actual',
      'en' => 'The variable %s used for the name of db %s of %s is not defined or has not actual value', ),
    'Las opciones válidas son: ' => array(
      'ca' => 'Les opcions vàlides son: ',
      'en' => 'The valid options are: ', ),
    'Leo el fichero %s' => array(
      'ca' => 'Llig el arxiu %s',
      'en' => 'Reading file %s', ),
    'Línea de comandos:' => array(
      'ca' => 'Llinea de comandaments',
      'en' => 'Command line', ),
    'No puedo abrir el fichero %s' => array(
      'ca' => 'No puc obrir el arxiu %s',
      'en' => 'Cannot open file %s', ),
    'No puedo cargar el fichero %s' => array(
      'ca' => 'No puc carregar el archiu %s',
      'en' => 'Cannot load file %s', ),
    'No puedo cargar la imagen %s' => array(
      'ca' => 'No puc carregar l\'imatge %s',
      'en' => 'Cannot load image %s', ),
    'No puedo conectar con el servidor postgres actual \'%s\' , \'-2617923037' => array(
      'ca' => 'No puc conectar amb el servidor postgresql actual \'%s\' , \'%s\' , \'%s\' , \'%s\' , \'%s\'',
      'en' => 'Cannot connect with current postgresql server \'%s\' , \'%s\' , \'%s\' , \'%s\' , \'%s\'', ),
    'No puedo crear el directorio %s' => array(
      'ca' => 'No puc crear el directori %s',
      'en' => 'Canot create directory %s', ),
    'No puedo crear el fichero %s' => array(
      'ca' => 'No puc crear el arxiu %s',
      'en' => 'Canot create file %s', ),
    'No puedo crear ficheros' => array(
      'ca' => 'No puc crear arxius',
      'en' => 'Canot create files', ),
    'No puedo generar el fichero %s correctamente, causas posib-1606610545' => array(
      'ca' => 'No puc generar el fitxer %s correctament, causes posibles:'."\n".
       ' - cap variable definida'."\n".
       ' - problema intern',
      'en' => 'Cannot generate a correct %s, possible causes:'."\n".
       ' - any defined variable'."\n".
       ' - internal error', ),
    'No puedo obtener la versión actual a partir de %s' => array(
      'ca' => 'No puc obtenir la versio actual a partir de %s',
      'en' => 'Cannot obtain the current version form %s', ),
    'No se especificó ni conexión ni archivo para la bdd %s' => array(
      'ca' => 'No es va especificar ni conexió ni arxiu per a la bdd %s',
      'en' => 'Neither connection nor file was especified fot bdd %s', ),
    'Nueva contraseña' => array(
      'ca' => 'Nova paraula de pass',
      'en' => 'New password', ),
    'Opción ambigua' => array(
      'ca' => 'Opció ambigua',
      'en' => 'Ambiguous option', ),
    'Opción desconocida \'%s\'' => array(
      'ca' => 'Opció desconeguda \'%s\'',
      'en' => 'Unknown option \'%s\'', ),
    'Para usar con \'%s\', \'%s\' debe ser un directorio' => array(
      'ca' => 'Per a fer servir amb \'%s\', \'%s\' deu de ser un directori',
      'en' => 'To use with \'%s\', \'%s\' mush be a directory', ),
    'Para usar con \'%s\', \'%s\' debe ser un fichero ordinario' => array(
      'ca' => 'Per a fer servir amb \'%s\', \'%s\' deu de ser un fitxer ordinari',
      'en' => 'To use with \'%s\', \'%s\' mush be an ordinary file', ),
    'Parseado %s con %s' => array(
      'ca' => 'Parsejant %s amb %s',
      'en' => 'Parsing %s with %s', ),
    'Paso 1' => array(
      'ca' => 'Pas 1',
      'en' => 'Step 1', ),
    'Paso 2' => array(
      'ca' => 'Pas 2',
      'en' => 'Step 2', ),
    'Problemas en el código fuente de %s, edítalo a mano' => array(
      'ca' => 'Problemes amb el codi font de %s, edítal a ma',
      'en' => 'Troubles with %s source code, edit it by hand', ),
    'Proceder' => array(
      'ca' => 'Precedir',
      'en' => 'Proceed', ),
    'Rellena tabla %s' => array(
      'ca' => 'Ompli taula %s',
      'en' => 'Fill table %s', ),
    'Sólo un fichero de instalación' => array(
      'ca' => 'Sols un fitcher d\'instalació',
      'en' => 'Only a instalation file', ),
    'Sólo un nombre de plantilla, deben existir: en-fichero , e-2469566208' => array(
      'ca' => 'Nomes un nom de plantilla, deuen existir: ca-fitxer, es-fitxer ...',
      'en' => 'Only a template name, must exist: en-file , de-file ...', ),
    'Tabla %s' => array(
      'ca' => 'Taula %s',
      'en' => 'Table %s', ),
    'Tipo de base de datos \'%s\' desconocido' => array(
      'ca' => 'Tipus de base de dades \'%s\' desconeguda',
      'en' => 'Database type \'%s\' unknown', ),
    'Tomo imagen %s de tipo %s, id %s' => array(
      'ca' => 'Agafe imatge %s de tipus %s, id %s',
      'en' => 'Taking image %s of type %s, id %s', ),
    'Un comentario eliminado por mkInstaller' => array(
      'ca' => 'Un comentari eliminat per mkInstaller',
      'en' => 'One comment removed by mkInstaller', ),
    'Versión aceptada: %s' => array(
      'ca' => 'Versió aceptada: %s',
      'en' => 'Accepted version: %s', ),
    'Versión actual obtenida: %s' => array(
      'ca' => 'Versió actual obtinguda: %s',
      'en' => 'Obtained current version: %s', ),
    'auto-ejecutables' => array(
      'ca' => 'auto-ejecutables',
      'en' => 'auto-run', ),
    'bases de datos' => array(
      'ca' => 'bases de dades',
      'en' => 'databases', ),
    'carga' => array(
      'ca' => 'càrrega',
      'en' => 'load', ),
    'ficheros' => array(
      'ca' => 'arxius',
      'en' => 'files', ),
    'filtros' => array(
      'ca' => 'filtres',
      'en' => 'filters', ),
    'finales' => array(
      'ca' => 'finals',
      'en' => 'enders', ),
    'licencia' => array(
      'ca' => 'llicencia',
      'en' => 'license', ),
    'plantilla' => array(
      'ca' => 'plantilla',
      'en' => 'template', ),
    'plantillas y CSS' => array(
      'ca' => 'plantilles y CSS',
      'en' => 'templates & CSS', ),
    's' => array(
      'ca' => 's',
      'en' => 'y', ),
    'var ' => array(
      'ca' => 'var',
      'en' => 'var', ),
    'variables' => array(
      'ca' => 'variables',
      'en' => 'variables', ),
    'ver %s' => array(
      'ca' => '0',
      'en' => '0', ),
    '¿Desea actualizarla ahora?' => array(
      'ca' => 'Desitja actualitzarla ara?',
      'en' => 'Do you want to upgrade now?', ),
   );
  $idios[$my]=1;
  foreach($lang_lang as $st =>$tra)
    foreach($tra as $la => $kk)
      $idios[$la]=2;
  return $idios;
}

function mmSetLang($langs,$def) {
  global $whichLang, $altLang;
  $altLang=$def;
  if (!$langs[$altLang])
    $altLang="";
  if (!$whichLang) { //force?
    foreach(preg_split('/,/',
          preg_replace('/;.*/','',
          strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'])))
        as $lang) {
      $lang=substr($lang,0,2);
      if ($langs[$lang]) {
        $whichLang=$lang;
        break;
      }
    }
  }
  if (!$whichLang) {
    $whichLang=substr(setlocale(LC_ALL,""),0,2);
  }
  // si nada coincide asume $altLang
  if (strlen($whichLang) != 2)
    $whichLang=$altLang;
  if ($langs[$whichLang] == 1)
    $altLang="";
}

function forceLangSession($lang) {
  global $whichLang;
  if ($lang)
    $_SESSION["whichLang"]=$lang;
  if ($lang=$_SESSION["whichLang"])
    $whichLang=$lang;
}

function __($mes,$lang="") {
  global $lang_lang, $whichLang, $altLang;
  $idi=$lang or $idi=$whichLang;
  if (strlen($mes) > 70)
    $imes=substr($mes,0,58)."-".sprintf("%u",crc32($mes));
  else 
    $imes=$mes;
  $mm=$lang_lang[$imes][$idi];
  if ($mm)
    return $mm;
  else {
    $mm=$lang_lang[$imes][$altLang];
    if ($mm)
      return $mm;
    else
      return $mes;
  }
}

/* mmGetText end */
// }}}

/*
 * vim600: cms=//%s foldmethod=marker
 */

?>

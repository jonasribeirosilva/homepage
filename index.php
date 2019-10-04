<?php
$meses = [
  1 => 'Janeiro', 'Fevereiro', 'Março',
  'Abril', 'Maio', 'Junho',
  'Julho', 'Agosto', 'Setembro',
  'Outubro', 'Novembro', 'Dezembro'
];
$mesesCurto = [
  1 => 'Jan', 'Fev', 'Mar',
  'Abr', 'Mai', 'Jun',
  'Jul', 'Ago', 'Set',
  'Out', 'Nov', 'Dez'
];
$diaSemana = [
  'Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira',
  'Quinta-Feira', 'Sexta-Feira', 'Sábado'
];
$diaSemanaCurto = [
  'Dom', 'Seg', 'Ter', 'Qua',
  'Qui', 'Sex', 'Sáb'
];
$now = time();
$date = [
  'dia' => date('d', $now),
  'mes' => date('n', $now),
  'ano' => date('Y', $now),
  'diaSemana' => date('w', $now)
];
$hojeExt = "{$diaSemana[$date['diaSemana']]}, {$date['dia']} de {$meses[$date['mes']]} de {$date['ano']}";
$hoje = date('d/m/Y', $now);
function faicon ($icon)
{
  return ' <i class="'.$icon.'"></i> ';
}
// --------------------------------
// ----------- Atalhos ------------
// --------------------------------
function addAtalho (&$atalhos = [], $label, $href, $color = 'teal')
{
  $atalhos[] = [
    'icon' => null,
    'label' => $label,
    'href' => $href,
    'color' => $color
  ];  
}
try {
  $atalhos = json_decode(
    file_get_contents('atalhos.json'),
    true
  );
  
  if (json_last_error() != JSON_ERROR_NONE) {
    throw new \Exception("Erro ao abrir atalhos");
  }
} catch (\Exception $e) {
  $atalhos = [];
}

// ------------------------------------
// ----------- Projetos ---------------
// ------------------------------------
function addProjetos (&$projetos = [], $label, $href, $srcIcon = null)
{
  $projetos[] = [
    'label' => $label,
    'href' => $href,
    'srcIcon' => $srcIcon
  ];  
}
try {
  $projetos = json_decode(
    file_get_contents('projetos.json'),
    true
  );
  
  if (json_last_error() != JSON_ERROR_NONE) {
    throw new \Exception("Erro ao abrir projetos");
  }
} catch (\Exception $e) {
  $projetos = [];
}

// addProjetos($projetos, 'Klug ERP', 'http://klugerp.com', 'http://klugerp.com/favicon.ico');
/**
 * Listar um diretorio
 * 
 * @param string $path Caminho para listar
 * @param array of string $excludes Nomes excluidos da lista
 * @param int $type Tipo de arquivos (0 - Pastas / 1 - Arquivos / 2 - Ambos)
 * @return array of string Lista de arquivos/pastas
 * */
function listDir ($path, $excludes = [], $type = 0)
{
  $excludes[] = '.';
  $excludes[] = '..';
  if (is_dir($path)) {
    if ($handle = opendir($path)) {
      $data = [];
      while (false !== ($entry = readdir($handle))) {
        if (substr($entry, 0, 1) != '.' && !in_array($entry, $excludes)) {
            if ($type == 2 || ($type == 0 && is_dir($path.$entry)) || ($type == 1 && is_file($path.$entry))) {
                $data[] = $entry;
            }
        }
      }
      closedir($handle);
      return $data;
    }
  }
  return [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>HOME</title>
    <link rel="stylesheet" href="public/materialize/css/materialize.min.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <link rel="stylesheet" href="public/style.css"> 
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body class="grey lighten-2">
  <a id="top"></a>
  <!-- MENU -->
   <nav class="grey darken-3 z-depth-0">
    <div class="nav-wrapper">
      <div class="container">
        <a href="#" class="brand-logo white-text"><?php echo faicon('fas fa-home');?> HOME</a>
        <a href="#" data-target="menu-mobile" class="black-text sidenav-trigger">
          <i class="fas fa-bars"></i>
        </a>
        <ul class="right hide-on-med-and-down">
          <li><a href="/phpmyadmin" target="_blank" class="white-text">PHPMyAdmin</a></li>
          <li><a href="#atalhos" class="white-text">Atalhos</a></li>
          <li><a href="#projetos" class="white-text">Projetos</a></li>
          <li><a href="/homepage/phpinfo.php" target="_blank" class="white-text">PHPINFO</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <ul class="sidenav" id="menu-mobile">
    <li><a href="#atalhos" class="black-text">Atalhos</a></li>
    <li><a href="#projetos" class="black-text">Projetos</a></li>
    <li><a href="/homepage/phpinfo.php" target="_blank" class="black-text">PHPINFO</a></li>
  </ul>
  <!-- INICIO DA PAGINA -->
  <section id="atalhos">
    <div class="row">
      <div class="col m12 s12 z-depth-2" style="background:url('/homepage/public/img/top.jpg');background-size:cover;padding: 20px 0;">
        <div class="col m4 s6">
          <!--<div class="card teal white-text">
            <div class="card-content">-->
              <h1 class="card-title teal-text text-darken-3"><?php echo $hojeExt;?></h1>
              <p class="teal-text text-darken-3"><?php echo $hoje;?></p>
          <!-- </div>
          </div>-->
        </div>
        <div class="col m8 s6">
          <div class="card white teal-text">
            <div class="card-content">
              <span class="card-title">Atalhos</span>
  <?php 
    foreach($atalhos as $atalho) {
      echo '<a href="'.$atalho['href'].'" target="_blank" class="btn '.$atalho['color'].' white-text" style="margin:5px;">';
      if (isset($atalho['icon']) && !is_null($atalho['icon']) && $atalho['icon'] != '') {
        echo "<i class=\"{$atalho['icon']}\"></i> ";
      }
      echo $atalho['label']."</a>\r\n";
    }
  ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="projetos" class="container">
    <div class="row">
      <div class="col m6 s12">
        <div class="card white">
          <div class="card-content">
            <span class="card-title">Projetos</span>
<?php 
  echo '<div class="collection">';
  foreach($projetos as $projeto) {
    echo '<a href="'.$projeto['href'].'" target="_blank" class="collection-item">';
    if (!is_null( $projeto['srcIcon'])) {
      echo '<img src="'.$projeto['srcIcon'].'" style="width:16px;height:16px;" /> ';
    }
    echo $projeto['label']."</a>\r\n";
  }
  echo '</div>';
?>
          </div>
        </div>
      </div>
      <div class="col m6 s12">
        <div class="card white">
          <div class="card-content">
            <span class="card-title">Outros projetos</span>
<?php
  echo '<div class="collection">';
  foreach (listDir('../', ['homepage']) as $entry)
  {
    echo '<a href="/'.$entry.'" target="_blank" class="collection-item">'.strtoupper($entry).'</a>';
  }
  echo '</div>';
?>
          </div>
        </div>
      </div>
      <div class="col m6 s12">
        <div class="card white">
          <div class="card-content">
            <span class="card-title">Downloads</span>
<?php
  if (isset($_GET['del']) && !empty($_GET['del'])) {
    $filename = str_replace('/', '', $_GET['del']);
    if (!in_array(substr($filename,0,1),['.','~'])) {
		$filename = realpath('./download'). DIRECTORY_SEPARATOR . $filename;
		if (is_file($filename)) {
		  unlink($filename);
		}
	}
  }
  foreach ($_FILES["arquivo"]["error"] as $i => $error) {
    if ($error == UPLOAD_ERR_OK) {
      $filename = realpath('./download'). DIRECTORY_SEPARATOR . $_FILES['arquivo']['name'][$i];
      if (is_file($filename)) {
        unlink($filename);
      }
      if (move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $filename)) {
          chmod($filename, 0666);
      } else {
        echo '<p>Erro ao enviar arquivo</p>';
      }
    }
  }
  $files = listDir('./download/', [], 1);
  if (count($files) == 0) {
	echo '<p class="grey-text">// Nenhum arquivo //</p>';
  } else {
	  echo '<table class="table">';
	  foreach ($files as $entry)
	  {
		echo '<tr>';
		if ( in_array(substr($entry, -3), ['jpg','png','ico'])) {
		  echo '<td width="64"><img src="download/'.$entry.'" style="width:64px;border:solid 1px #000;" /></td>';
		  echo '<td><a href="download/'.$entry.'" target="_blank">'.strtoupper($entry).'</a></td>';
		} else {
		  echo '<td colspan="2"><a href="download/'.$entry.'" target="_blank">'.strtoupper($entry).'</a></td>';
		}
		echo '<td width="1"><a href="?del='.$entry.'" class="btn red"><i class="fa fa-trash"></i></a></td>';
		echo '</tr>';
	  }
	}
  echo '</table>';
?>
                <form id="frm_upload" action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="arquivo[]" id="in_arquivo" style="display:none;" onchange="document.getElementById('frm_upload').submit();" />
                    
                </form>
          </div>
          <div class="card-action">
			  <a href="#" class="teal-text" onclick="$('#in_arquivo').click();return false;"><i class="fa fa-upload"></i> Enviar arquivo</a>
          </div>
        </div>
      </div>
    </div>
    <div id="lista"></div>
  </section>
  <!-- Rodape center -->
  <footer class="blue-grey darken-4 white-text" style="margin:0px;padding: 30px;">
  <div class="container center-align">
    <a href="#top" class="white-text">
      <i class="fas fa-chevron-up"></i><br/>
      Ir para o Topo
    </a>
    <div style="margin-top: 20px;">&copy; Copyright 2018 Jonas Silva.</div>
  </div>
  </footer>
  <script src="public/jquery-3.3.1.min.js"></script>
  <script src="public/materialize/js/materialize.min.js"></script>
  <script>
  $(document).ready(function(){
    $('.sidenav').sidenav();
  });
  </script>
  </body>
</html>

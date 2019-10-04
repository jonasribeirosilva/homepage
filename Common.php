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


function deleteFile ($filename) {
    $filename = str_replace('/', '', $filename);
    if (!in_array(substr($filename,0,1),['.','~'])) {
        $filename = realpath('./download'). DIRECTORY_SEPARATOR . $filename;
        if (is_file($filename)) {
            unlink($filename);
        }
    }
}
function uploadFile () {
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
}
<?php

error_reporting(E_ALL);
include 'Command.php';
include 'Projetos.php';
include 'Atalhos.php';

try {
    $cmd = new Command($argv,$argc);

    $cmd->cmd("projeto add {nome} {href} {srcIcon?}","Projetos@create");
    $cmd->cmd("projeto clear","projetos@clear");

    $cmd->cmd("atalho add {nome} {href} {classIcon?} {classColor?}","Atalhos@create");
    $cmd->cmd("atalho clear","projetos@clear");

    echo "Comandos possiveis:\n";
    echo "projeto add <nome> <href> <srcIcon*>\n";
    echo "projeto clear\n";
    echo "atalho add <nome> <href> <classIcon*> <classColor*>\n";
    echo "atalho clear\n\n";
    echo "* Opcional\n";
} catch (\Error $e){
    echo "ERROR ".$e->getCode().": ".$e->getMessage();
  } catch (\Exception $e){
    echo "ERROR ".$e->getCode().": ".$e->getMessage();
  }
?>
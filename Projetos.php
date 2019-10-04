<?php

class Projetos {
    private $projetos = [];
    public function create ($nome, $href, $srcIcon = '') {
        if (empty($srcIcon)) {
            $srcIcon = $href . (substr($href,-1)=='/'?'':'/') . 'favicon.ico';
        }
        $projeto = [
            "label" => $nome,
            "href" => $href,
            "srcIcon" => $srcIcon
        ];
        $projetos = $this->readProjetos();
        $projetos[] = $projeto;
        $this->saveProjeto($projetos);
    }
    public function clear () {
        $this->projetos = [];
        $this->saveProjeto();
    }
    static public function getProjetos () {
        try {
            $projetos = json_decode(file_get_contents('projetos.json'), true);
            
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new Exception("Erro ao abrir projetos");
            }
        } catch (Exception $e) {
            $projetos = [];
        }
        return $projetos;
    }
    public function readProjetos () {
        $this->projetos = $this->getProjetos();
        return $this->projetos;
    }
    public function saveProjeto ($projetos = null) {
        if (is_null($projetos) && is_array($projetos)) {
            $projetos = $this->projetos;
        } else {
            $this->projetos = $projetos;
        }
        return file_put_contents('projetos.json', json_encode($this->projetos, JSON_PRETTY_PRINT));
    }
}
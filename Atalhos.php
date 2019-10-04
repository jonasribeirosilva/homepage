<?php

class Atalhos {
    private $atalhos = [];
    public function create ($nome, $href, $classIcon = '', $classColor = '') {
        if (empty($classIcon)) {
            $classIcon = 'fa fa-circle';
        }
        if (empty($classColor)) {
            $classColor = 'blue';
        }
        $atalho = [
            "icon" => $classIcon,
            "label" => $nome,
            "href" => $href,
            "color" => $classColor
        ];
        $atalhos = $this->readAtalho();
        $atalhos[] = $atalho;
        $this->saveAtalho($atalhos);
    }
    public function clear () {
        $this->saveProjeto([]);
    }
    static public function getAtalhos () {
        try {
            $atalhos = json_decode(file_get_contents('atalhos.json'), true);
            
            if (json_last_error() != JSON_ERROR_NONE) {
                throw new \Exception("Erro ao abrir atalhos");
            }
        } catch (\Exception $e) {
            $atalhos = [];
        }
        return $atalhos;
    }
    public function readAtalho () {
        $this->atalhos = $this->getAtalhos();
        return $this->atalhos;
    }
    public function saveProjeto ($atalhos = null) {
        if (is_null($atalhos) && is_array($atalhos)) {
            $atalhos = $this->atalhos;
        } else {
            $this->atalhos = $atalhos;
        }
        return file_put_contents('atalhos.json', json_encode($atalhos, JSON_PRETTY_PRINT));
    }
}
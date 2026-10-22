<?php
class Nodo
{
    private string $valor;
    private ?Nodo $izquierda;
    private ?Nodo $derecha;

    public function __construct(string $valor, ?Nodo $izquierda = null, ?Nodo $derecha = null)
    {
        $this->valor = $valor;
        $this->izquierda = $izquierda;
        $this->derecha = $derecha;
    }
    public function getValor()
    {
        return $this->valor;
    }
    public function setValor(string $valor)
    {
        $this->valor = $valor;
    }
    public function getIzquierda()
    {
        return $this->izquierda;
    }
    public function setIzquierda(?Nodo $valor = null)
    {
        $this->izquierda = $valor;
    }
    public function getDerecha()
    {
        return $this->derecha;
    }
    public function setDerecha(?Nodo $valor = null)
    {
        $this->derecha = $valor;
    }

    public function preorden()
    {
        echo "<h2 class=subtitulo>$this->valor</h2>";
        if ($this->izquierda != null) {
            $this->izquierda->preorden();
        }
        if ($this->derecha != null) {
            $this->derecha->preorden();
        }
    }
    public function inorden()
    {
        if ($this->izquierda != null) {
            $this->izquierda->inorden();
        }
        echo "<h2 class=subtitulo>$this->valor</h2>";
        if ($this->derecha != null) {
            $this->derecha->inorden();
        }
    }
    public function postorden()
    {
        if ($this->izquierda != null) {
            $this->izquierda->postorden();
        }
        if ($this->derecha != null) {
            $this->derecha->postorden();
        }
        echo "<h2 class=subtitulo>$this->valor</h2>";
    }
}
?>
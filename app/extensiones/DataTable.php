<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 20/09/2018
 * Time: 12:42
 */

namespace App\extensiones;

use Yajra\DataTables\Services\DataTable as BaseDataTables;

class DataTable extends BaseDataTables
{

    /**
     * @var null
     */
    private $titulo;
    /**
     * @var null
     */
    private $subtitulo;

    public function __construct($titulo=null,$subtitulo=null) {
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
    }

    /**
     * @return null
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param null $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return null
     */
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }

    /**
     * @param null $subtitulo
     */
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;
    }




    public function snappyPdf()
    {
        /** @var \Barryvdh\Snappy\PdfWrapper $snappy */
        $snappy      = resolve('snappy.pdf.wrapper');
        $options     = config('datatables-buttons.snappy.options');
        $orientation = config('datatables-buttons.snappy.orientation');

        $snappy->setOptions($options)
            ->setOrientation($orientation);

        return $snappy->loadHTML($this->printPreview())
            ->inline($this->getFilename() . '.pdf');
    }

    public function printPreview()
    {
        $data = $this->getDataForPrint();
        $titulo = $this->getTitulo();
        $subTitulo = $this->getSubtitulo();

        return view($this->printPreview, compact('data','titulo','subTitulo'));
    }


}
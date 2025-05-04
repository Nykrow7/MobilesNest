<?php

namespace App\Services;

use Dompdf\Dompdf;

class PDF
{
    protected $dompdf;

    public function __construct(Dompdf $dompdf)
    {
        $this->dompdf = $dompdf;
    }

    public function loadView($view, $data = [], $mergeData = [])
    {
        $html = view($view, $data, $mergeData)->render();
        return $this->loadHTML($html);
    }

    public function loadHTML($html)
    {
        $this->dompdf->loadHtml($html);
        return $this;
    }

    public function setPaper($size, $orientation = 'portrait')
    {
        $this->dompdf->setPaper($size, $orientation);
        return $this;
    }

    public function render()
    {
        $this->dompdf->render();
        return $this->dompdf->output();
    }

    public function stream($filename = null, $options = [])
    {
        return $this->dompdf->stream($filename, $options);
    }

    public function download($filename = 'document.pdf')
    {
        return response($this->render(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function save($filepath)
    {
        file_put_contents($filepath, $this->render());
        return $this;
    }
}

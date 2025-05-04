<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Test PDF',
            'content' => 'This is a test PDF generated with our custom PDF service.'
        ];

        $pdf = app('pdf');
        return $pdf->loadView('pdf.test', $data)->download('test.pdf');
    }
}

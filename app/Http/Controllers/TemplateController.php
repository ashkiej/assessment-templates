<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Barryvdh\DomPDF\Facade\Pdf;

class TemplateController extends Controller
{
    public function downloadPdf(Template $template)
    {
        // Eager load relationships for performance
        $template->load('sections.subsections.items', 'sections.ratingColumns');

        $pdf = Pdf::loadView('templates.pdf', ['template' => $template]);

        return $pdf->download($template->name . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;

class PdfMergeController extends Controller
{
    public function index()
    {
        return view('pdf-merge');
    }

    public function merge(Request $request)
    {
        $request->validate([
            'pdfs' => 'required|array|min:2',
            'pdfs.*' => 'required|file|mimes:pdf|max:51200',
        ]);

        $files = $request->file('pdfs');

        $inputPaths = [];

        foreach ($files as $file) {
            $inputPaths[] = $file->getRealPath();
        }

        $outputName = 'merged_' . date('Ymd_His') . '.pdf';

        $outputPath = storage_path(
            'app/' . $outputName
        );

        $pdfunite = PHP_OS_FAMILY === 'Windows'
            ? 'C:\poppler-26.02.0\Library\bin\pdfunite.exe'
            : '/usr/bin/pdfunite';

        $command = array_merge(
            [$pdfunite],
            $inputPaths,
            [$outputPath]
        );

        $result = Process::run($command);

        if ($result->failed()) {

            return back()->withErrors([
                'pdfs' => 'Không thể ghép PDF: ' . $result->errorOutput()
            ]);
        }

        return response()
            ->download($outputPath, $outputName)
            ->deleteFileAfterSend(true);
    }
}
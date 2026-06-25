<?php
/**
 * Hand hygiene test PDF: draw answer text at the legacy positions and ring it in red for visibility.
 */

function hh_pdf_draw_circle($pdf, $cx, $cy, $r = 2.8, $segments = 56)
{
    $pdf->SetDrawColor(200, 0, 0);
    $pdf->SetLineWidth(0.5);
    for ($i = 0; $i < $segments; $i++) {
        $a1 = 2 * M_PI * $i / $segments;
        $a2 = 2 * M_PI * ($i + 1) / $segments;
        $pdf->Line(
            $cx + $r * cos($a1),
            $cy + $r * sin($a1),
            $cx + $r * cos($a2),
            $cy + $r * sin($a2)
        );
    }
}

function hh_pdf_format_answer_display($label)
{
    $t = trim((string) $label);
    if ($t === '') {
        return '';
    }
    $lower = strtolower($t);
    if ($lower === 'true') {
        return 'True';
    }
    if ($lower === 'false') {
        return 'False';
    }

    return strtoupper($t);
}

/**
 * Same as legacy Write(translate(...)) at ($x,$y), with a red circle around the text.
 * $x/$y are the original template anchor points; answers are shifted left so the ring
 * does not cross the printed question numbers (1., 2., …) on test_handhygiene.pdf.
 */
function hh_pdf_write_answer_circled($pdf, $x, $y, $label)
{
    $label = hh_pdf_format_answer_display($label);
    if ($label === '') {
        return;
    }
    $leftShiftMm = 12;
    $x -= $leftShiftMm;
    $x = max($x, 11);
    $pdf->SetFont('Arial', '', 12);
    $w = $pdf->GetStringWidth($label);
    $hMm = 4.8;
    $pad = 1.5;
    $cx = $x + $w / 2;
    $circleDownMm = 2.6;
    $cy = $y - $hMm / 2 + $circleDownMm;
    $r = max($w / 2 + $pad, $hMm / 2 + $pad, 3.0);
    hh_pdf_draw_circle($pdf, $cx, $cy, $r, 56);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY($x, $y);
    $pdf->Write(0, $label);
}

/**
 * Waive / Hep B / Harassment / Emergency / Covid / Gluco / Blood pathogen test PDFs:
 * show the recorded answer in Title/upper form (true→True, letters→uppercase) and ring it in red.
 *
 * @param float $leftShiftMm Nudge left so the circle clears printed question numbers (use 0 if already aligned).
 */
function test_pdf_write_answer_circled($pdf, $x, $y, $raw_label, $fontSize = 9, $leftShiftMm = 8)
{
    $t = trim((string) $raw_label);
    if ($t === '') {
        return;
    }
    $label = hh_pdf_format_answer_display($t);
    if ($label === '') {
        return;
    }
    $x -= $leftShiftMm;
    $x = max($x, 4);
    $pdf->SetFont('Arial', '', $fontSize);
    $w = $pdf->GetStringWidth($label);
    $hMm = max(3.2, $fontSize * 0.48 + 0.4);
    $pad = 1.35;
    $cx = $x + $w / 2;
    $circleDownMm = max(1.8, $fontSize * 0.22 + 0.6);
    $cy = $y - $hMm / 2 + $circleDownMm;
    $r = max($w / 2 + $pad, $hMm / 2 + $pad, 2.5);
    hh_pdf_draw_circle($pdf, $cx, $cy, $r, 56);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY($x, $y);
    $pdf->Write(0, $label);
}

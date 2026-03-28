<?php

declare(strict_types=1);

namespace App\Core;

final class TicketPdfGenerator
{
    public static function output(array $ticket, bool $download = true): void
    {
        $content = self::buildPdf($ticket);
        $filename = 'ticket-' . ($ticket['ticket_number'] ?? $ticket['id']) . '.pdf';

        header('Content-Type: application/pdf');
        header('Content-Length: ' . strlen($content));
        header('Content-Disposition: ' . ($download ? 'attachment' : 'inline') . '; filename="' . $filename . '"');
        echo $content;
        exit;
    }

    public static function raw(array $ticket): string
    {
        return self::buildPdf($ticket);
    }

    private static function buildPdf(array $ticket): string
    {
        $lines = [
            'Around Aruba UTV Tour Ticket',
            'Ticket No: ' . ($ticket['ticket_number'] ?? ''),
            'Generated On: ' . date('Y-m-d H:i'),
            '',
            'Customer Name: ' . ($ticket['customer_name'] ?? ''),
            'Customer Email: ' . ($ticket['customer_email'] ?? ''),
            'Customer Phone: ' . ($ticket['customer_phone'] ?? ''),
            'OTG Number: ' . ($ticket['otg_number'] ?? ''),
            'Date of Tour: ' . ($ticket['date_of_tour'] ?? ''),
            'Time of Tour: ' . ($ticket['time_of_tour'] ?? ''),
            'Number of Members: ' . ($ticket['number_of_members'] ?? ''),
            '2-Seater UTVs: ' . ($ticket['number_of_2_seater_utvs'] ?? ''),
            '3-Seater UTVs: ' . ($ticket['number_of_3_seater_utvs'] ?? ''),
            '4-Seater UTVs: ' . ($ticket['number_of_4_seater_utvs'] ?? ''),
            '5-Seater UTVs: ' . ($ticket['number_of_5_seater_utvs'] ?? ''),
            'Pickup Location: ' . ($ticket['pickup_location'] ?? ''),
            'Drop-off Location: ' . ($ticket['dropoff_location'] ?? ''),
        ];

        $operations = ['BT', '/F1 12 Tf'];
        $y = 790;

        foreach ($lines as $line) {
            $escapedLine = self::escapeText($line);
            $operations[] = sprintf('1 0 0 1 40 %d Tm (%s) Tj', $y, $escapedLine);
            $y -= 22;
        }

        $operations[] = 'ET';
        $stream = implode("\n", $operations);

        $objects = [];
        $objects[] = '1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj';
        $objects[] = '2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj';
        $objects[] = '3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj';
        $objects[] = '4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj';
        $objects[] = '5 0 obj << /Length ' . strlen($stream) . " >> stream\n" . $stream . "\nendstream endobj";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n";
        $pdf .= '0 ' . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1, $count = count($offsets); $i < $count; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= 'trailer << /Size ' . (count($objects) + 1) . ' /Root 1 0 R >>' . "\n";
        $pdf .= "startxref\n";
        $pdf .= $xrefOffset . "\n";
        $pdf .= '%%EOF';

        return $pdf;
    }

    private static function escapeText(string $text): string
    {
        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}

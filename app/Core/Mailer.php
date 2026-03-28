<?php

declare(strict_types=1);

namespace App\Core;

final class Mailer
{
    public static function sendTicket(array $ticket): bool
    {
        $to = $ticket['customer_email'] ?? '';

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $boundary = 'ticket-' . bin2hex(random_bytes(12));
        $subject = 'Your Around Aruba UTV Tour Ticket - ' . ($ticket['ticket_number'] ?? '');
        $body = self::plainBody($ticket);
        $attachment = chunk_split(base64_encode(TicketPdfGenerator::raw($ticket)));

        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'From: ' . app_config('mail.from_name', 'Around Aruba') . ' <' . app_config('mail.from_email', 'no-reply@example.com') . '>';
        $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';

        $message = '--' . $boundary . "\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $message .= $body . "\r\n\r\n";
        $message .= '--' . $boundary . "\r\n";
        $message .= 'Content-Type: application/pdf; name="ticket.pdf"' . "\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= 'Content-Disposition: attachment; filename="ticket.pdf"' . "\r\n\r\n";
        $message .= $attachment . "\r\n";
        $message .= '--' . $boundary . "--\r\n";

        return mail($to, $subject, $message, implode("\r\n", $headers));
    }

    private static function plainBody(array $ticket): string
    {
        return implode("\r\n", [
            'Hello ' . ($ticket['customer_name'] ?? 'Guest') . ',',
            '',
            'Thank you for booking your Around Aruba UTV tour.',
            'Your ticket number is ' . ($ticket['ticket_number'] ?? '') . '.',
            '',
            'Date: ' . ($ticket['date_of_tour'] ?? ''),
            'Time: ' . ($ticket['time_of_tour'] ?? ''),
            'Pickup: ' . ($ticket['pickup_location'] ?? ''),
            'Drop-off: ' . ($ticket['dropoff_location'] ?? ''),
            '',
            'A PDF copy of your ticket is attached to this email.',
        ]);
    }
}

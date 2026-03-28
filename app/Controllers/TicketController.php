<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Mailer;
use App\Core\Session;
use App\Core\TicketPdfGenerator;
use App\Core\Validator;
use App\Models\Ticket;

final class TicketController extends Controller
{
    private Ticket $tickets;

    public function __construct()
    {
        $this->tickets = new Ticket();
    }

    public function dashboard(): void
    {
        $this->view('tickets/dashboard', [
            'title' => 'Create Ticket',
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
        ]);
    }

    public function index(): void
    {
        $this->view('tickets/index', [
            'title' => 'Manage Tickets',
            'tickets' => $this->tickets->all(),
        ]);
    }

    public function store(): void
    {
        $this->requireValidCsrf();
        $data = $this->ticketPayload($_POST);
        $errors = Validator::ticket($data);

        if ($errors) {
            Session::flash('errors', $errors);
            Session::flash('old', $data);
            $this->redirect('dashboard');
        }

        $data['ticket_number'] = $this->generateTicketNumber();
        $id = $this->tickets->create($data);

        Session::flash('success', 'Ticket created successfully.');
        $this->redirect('tickets/edit&id=' . $id);
    }

    public function edit(): void
    {
        $ticket = $this->findTicketOrRedirect((int) ($_GET['id'] ?? 0));

        $this->view('tickets/edit', [
            'title' => 'Edit Ticket',
            'ticket' => $ticket,
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
        ]);
    }

    public function update(): void
    {
        $this->requireValidCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $ticket = $this->findTicketOrRedirect($id);
        $data = $this->ticketPayload($_POST);
        $errors = Validator::ticket($data);

        if ($errors) {
            Session::flash('errors', $errors);
            Session::flash('old', $data);
            $this->redirect('tickets/edit&id=' . $ticket['id']);
        }

        $this->tickets->update($ticket['id'], $data);
        Session::flash('success', 'Ticket updated successfully.');
        $this->redirect('tickets');
    }

    public function delete(): void
    {
        $this->requireValidCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $ticket = $this->findTicketOrRedirect($id);
        $this->tickets->delete($ticket['id']);

        Session::flash('success', 'Ticket deleted successfully.');
        $this->redirect('tickets');
    }

    public function download(): void
    {
        $ticket = $this->findTicketOrRedirect((int) ($_GET['id'] ?? 0));
        TicketPdfGenerator::output($ticket);
    }

    public function email(): void
    {
        $this->requireValidCsrf();
        $ticket = $this->findTicketOrRedirect((int) ($_POST['id'] ?? 0));

        if (!Mailer::sendTicket($ticket)) {
            Session::flash('error', 'Ticket email could not be sent. Please check your mail server configuration.');
            $this->redirect('tickets');
        }

        Session::flash('success', 'Ticket emailed successfully.');
        $this->redirect('tickets');
    }

    private function generateTicketNumber(): string
    {
        return 'UTV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
    }

    private function requireValidCsrf(): void
    {
        if (!Csrf::validate($_POST['_token'] ?? null)) {
            Session::flash('error', 'Invalid request token. Please try again.');
            $this->redirect('tickets');
        }
    }

    private function findTicketOrRedirect(int $id): array
    {
        $ticket = $this->tickets->find($id);

        if ($ticket) {
            return $ticket;
        }

        Session::flash('error', 'Ticket not found.');
        $this->redirect('tickets');
    }

    private function ticketPayload(array $input): array
    {
        return [
            'customer_name' => trim((string) ($input['customer_name'] ?? '')),
            'customer_email' => trim((string) ($input['customer_email'] ?? '')),
            'customer_phone' => trim((string) ($input['customer_phone'] ?? '')),
            'otg_number' => trim((string) ($input['otg_number'] ?? '')),
            'date_of_tour' => trim((string) ($input['date_of_tour'] ?? '')),
            'time_of_tour' => trim((string) ($input['time_of_tour'] ?? '')),
            'number_of_members' => (int) ($input['number_of_members'] ?? 0),
            'number_of_2_seater_utvs' => (int) ($input['number_of_2_seater_utvs'] ?? 0),
            'number_of_3_seater_utvs' => (int) ($input['number_of_3_seater_utvs'] ?? 0),
            'number_of_4_seater_utvs' => (int) ($input['number_of_4_seater_utvs'] ?? 0),
            'number_of_5_seater_utvs' => (int) ($input['number_of_5_seater_utvs'] ?? 0),
            'pickup_location' => trim((string) ($input['pickup_location'] ?? '')),
            'dropoff_location' => trim((string) ($input['dropoff_location'] ?? '')),
        ];
    }
}

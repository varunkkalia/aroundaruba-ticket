<?php

$ticket = array_merge($ticket ?? [], $old ?? []);
$errors = $errors ?? [];
?>
<section>
    <div class="section-heading">
        <h2>Edit Ticket</h2>
        <p>Update the tour details for ticket <strong><?= e($ticket['ticket_number'] ?? '') ?></strong>.</p>
    </div>

    <div class="action-row">
        <a class="button" href="index.php?route=tickets">Back to Tickets</a>
        <a class="button button-secondary" href="index.php?route=tickets/download&id=<?= (int) ($ticket['id'] ?? 0) ?>">Download PDF</a>
    </div>

    <?php
    $action = 'index.php?route=tickets/update';
    $buttonLabel = 'Save Changes';
    require BASE_PATH . '/app/Views/tickets/_form.php';
    ?>
</section>

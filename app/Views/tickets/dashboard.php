<?php

$old = $old ?? [];
$errors = $errors ?? [];
?>
<section>
    <div class="section-heading">
        <h2>Create UTV Tour Ticket</h2>
        <p>Enter the customer details below to generate a new ticket.</p>
    </div>

    <?php
    $ticket = $old;
    $action = 'index.php?route=tickets/store';
    $buttonLabel = 'Generate Ticket';
    require BASE_PATH . '/app/Views/tickets/_form.php';
    ?>
</section>

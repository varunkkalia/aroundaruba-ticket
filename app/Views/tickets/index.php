<?php

use App\Core\Csrf;

$tickets = $tickets ?? [];
?>
<section>
    <div class="section-heading section-heading-inline">
        <div>
            <h2>Ticket Management</h2>
            <p>View, edit, email, download, or delete previously created tickets.</p>
        </div>
        <a class="button button-primary" href="index.php?route=dashboard">Create New Ticket</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Ticket #</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Tour Date</th>
                    <th>Tour Time</th>
                    <th>Members</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$tickets): ?>
                    <tr>
                        <td colspan="7" class="empty-state">No tickets have been created yet.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= e($ticket['ticket_number']) ?></td>
                        <td><?= e($ticket['customer_name']) ?></td>
                        <td>
                            <div><?= e($ticket['customer_email']) ?></div>
                            <div><?= e($ticket['customer_phone']) ?></div>
                        </td>
                        <td><?= e($ticket['date_of_tour']) ?></td>
                        <td><?= e($ticket['time_of_tour']) ?></td>
                        <td><?= e((string) $ticket['number_of_members']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a class="button button-small" href="index.php?route=tickets/edit&id=<?= (int) $ticket['id'] ?>">Edit</a>
                                <a class="button button-small button-secondary" href="index.php?route=tickets/download&id=<?= (int) $ticket['id'] ?>">Download</a>

                                <form method="POST" action="index.php?route=tickets/email">
                                    <input type="hidden" name="_token" value="<?= e(Csrf::token()) ?>">
                                    <input type="hidden" name="id" value="<?= (int) $ticket['id'] ?>">
                                    <button type="submit" class="button button-small">Email</button>
                                </form>

                                <form method="POST" action="index.php?route=tickets/delete" onsubmit="return confirm('Delete this ticket?');">
                                    <input type="hidden" name="_token" value="<?= e(Csrf::token()) ?>">
                                    <input type="hidden" name="id" value="<?= (int) $ticket['id'] ?>">
                                    <button type="submit" class="button button-small button-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

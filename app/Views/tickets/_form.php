<?php

$errors = $errors ?? [];
$ticket = $ticket ?? [];
$action = $action ?? 'index.php?route=tickets/store';
$buttonLabel = $buttonLabel ?? 'Create Ticket';
?>
<form method="POST" action="<?= e($action) ?>" class="form-grid">
    <input type="hidden" name="_token" value="<?= e(\App\Core\Csrf::token()) ?>">
    <?php if (!empty($ticket['id'])): ?>
        <input type="hidden" name="id" value="<?= (int) $ticket['id'] ?>">
    <?php endif; ?>

    <label>
        <span>Customer Name</span>
        <input type="text" name="customer_name" value="<?= e($ticket['customer_name'] ?? '') ?>" required>
        <?php if (isset($errors['customer_name'])): ?><small class="field-error"><?= e($errors['customer_name']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Customer Email</span>
        <input type="email" name="customer_email" value="<?= e($ticket['customer_email'] ?? '') ?>" required>
        <?php if (isset($errors['customer_email'])): ?><small class="field-error"><?= e($errors['customer_email']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Customer Phone</span>
        <input type="text" name="customer_phone" value="<?= e($ticket['customer_phone'] ?? '') ?>" required>
        <?php if (isset($errors['customer_phone'])): ?><small class="field-error"><?= e($errors['customer_phone']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>OTG Number</span>
        <input type="text" name="otg_number" value="<?= e($ticket['otg_number'] ?? '') ?>" required>
        <?php if (isset($errors['otg_number'])): ?><small class="field-error"><?= e($errors['otg_number']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Date of Tour</span>
        <input type="date" name="date_of_tour" value="<?= e($ticket['date_of_tour'] ?? '') ?>" required>
        <?php if (isset($errors['date_of_tour'])): ?><small class="field-error"><?= e($errors['date_of_tour']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Time of Tour</span>
        <input type="time" name="time_of_tour" value="<?= e($ticket['time_of_tour'] ?? '') ?>" required>
        <?php if (isset($errors['time_of_tour'])): ?><small class="field-error"><?= e($errors['time_of_tour']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Number of Members</span>
        <input type="number" min="1" name="number_of_members" value="<?= e((string) ($ticket['number_of_members'] ?? 1)) ?>" required>
        <?php if (isset($errors['number_of_members'])): ?><small class="field-error"><?= e($errors['number_of_members']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Number of 2-Seater UTVs</span>
        <input type="number" min="0" name="number_of_2_seater_utvs" value="<?= e((string) ($ticket['number_of_2_seater_utvs'] ?? 0)) ?>" required>
        <?php if (isset($errors['number_of_2_seater_utvs'])): ?><small class="field-error"><?= e($errors['number_of_2_seater_utvs']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Number of 3-Seater UTVs</span>
        <input type="number" min="0" name="number_of_3_seater_utvs" value="<?= e((string) ($ticket['number_of_3_seater_utvs'] ?? 0)) ?>" required>
        <?php if (isset($errors['number_of_3_seater_utvs'])): ?><small class="field-error"><?= e($errors['number_of_3_seater_utvs']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Number of 4-Seater UTVs</span>
        <input type="number" min="0" name="number_of_4_seater_utvs" value="<?= e((string) ($ticket['number_of_4_seater_utvs'] ?? 0)) ?>" required>
        <?php if (isset($errors['number_of_4_seater_utvs'])): ?><small class="field-error"><?= e($errors['number_of_4_seater_utvs']) ?></small><?php endif; ?>
    </label>

    <label>
        <span>Number of 5-Seater UTVs</span>
        <input type="number" min="0" name="number_of_5_seater_utvs" value="<?= e((string) ($ticket['number_of_5_seater_utvs'] ?? 0)) ?>" required>
        <?php if (isset($errors['number_of_5_seater_utvs'])): ?><small class="field-error"><?= e($errors['number_of_5_seater_utvs']) ?></small><?php endif; ?>
    </label>

    <label class="full-width">
        <span>Pickup Location</span>
        <input type="text" name="pickup_location" value="<?= e($ticket['pickup_location'] ?? '') ?>" required>
        <?php if (isset($errors['pickup_location'])): ?><small class="field-error"><?= e($errors['pickup_location']) ?></small><?php endif; ?>
    </label>

    <label class="full-width">
        <span>Drop-off Location</span>
        <input type="text" name="dropoff_location" value="<?= e($ticket['dropoff_location'] ?? '') ?>" required>
        <?php if (isset($errors['dropoff_location'])): ?><small class="field-error"><?= e($errors['dropoff_location']) ?></small><?php endif; ?>
    </label>

    <div class="full-width">
        <button type="submit" class="button button-primary"><?= e($buttonLabel) ?></button>
    </div>
</form>

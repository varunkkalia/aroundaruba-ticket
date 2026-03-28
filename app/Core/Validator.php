<?php

declare(strict_types=1);

namespace App\Core;

final class Validator
{
    public static function ticket(array $input): array
    {
        $errors = [];

        $requiredStrings = [
            'customer_name' => 'Customer name',
            'customer_email' => 'Customer email',
            'customer_phone' => 'Customer phone',
            'otg_number' => 'OTG number',
            'date_of_tour' => 'Date of tour',
            'time_of_tour' => 'Time of tour',
            'pickup_location' => 'Pickup location',
            'dropoff_location' => 'Drop-off location',
        ];

        foreach ($requiredStrings as $field => $label) {
            if (trim((string) ($input[$field] ?? '')) === '') {
                $errors[$field] = $label . ' is required.';
            }
        }

        if (!filter_var($input['customer_email'] ?? '', FILTER_VALIDATE_EMAIL)) {
            $errors['customer_email'] = 'Please enter a valid email address.';
        }

        $integerFields = [
            'number_of_members' => 'Number of members',
            'number_of_2_seater_utvs' => 'Number of 2-seater UTVs',
            'number_of_3_seater_utvs' => 'Number of 3-seater UTVs',
            'number_of_4_seater_utvs' => 'Number of 4-seater UTVs',
            'number_of_5_seater_utvs' => 'Number of 5-seater UTVs',
        ];

        foreach ($integerFields as $field => $label) {
            $value = filter_var($input[$field] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

            if ($value === false) {
                $errors[$field] = $label . ' must be 0 or greater.';
            }
        }

        if (($input['number_of_members'] ?? 0) < 1) {
            $errors['number_of_members'] = 'At least one member is required.';
        }

        return $errors;
    }

    public static function login(array $input): array
    {
        $errors = [];

        if (trim((string) ($input['username'] ?? '')) === '') {
            $errors['username'] = 'Username is required.';
        }

        if (trim((string) ($input['password'] ?? '')) === '') {
            $errors['password'] = 'Password is required.';
        }

        return $errors;
    }
}

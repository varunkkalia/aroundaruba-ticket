<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Ticket extends Model
{
    public function all(): array
    {
        return $this->db()->query('SELECT * FROM tickets ORDER BY created_at DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db()->prepare('SELECT * FROM tickets WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $ticket = $statement->fetch();

        return $ticket ?: null;
    }

    public function create(array $data): int
    {
        $statement = $this->db()->prepare(
            'INSERT INTO tickets (
                ticket_number,
                customer_name,
                customer_email,
                customer_phone,
                otg_number,
                date_of_tour,
                time_of_tour,
                number_of_members,
                number_of_2_seater_utvs,
                number_of_3_seater_utvs,
                number_of_4_seater_utvs,
                number_of_5_seater_utvs,
                pickup_location,
                dropoff_location,
                created_at,
                updated_at
            ) VALUES (
                :ticket_number,
                :customer_name,
                :customer_email,
                :customer_phone,
                :otg_number,
                :date_of_tour,
                :time_of_tour,
                :number_of_members,
                :number_of_2_seater_utvs,
                :number_of_3_seater_utvs,
                :number_of_4_seater_utvs,
                :number_of_5_seater_utvs,
                :pickup_location,
                :dropoff_location,
                NOW(),
                NOW()
            )'
        );

        $statement->execute($data);

        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['id'] = $id;

        $statement = $this->db()->prepare(
            'UPDATE tickets SET
                customer_name = :customer_name,
                customer_email = :customer_email,
                customer_phone = :customer_phone,
                otg_number = :otg_number,
                date_of_tour = :date_of_tour,
                time_of_tour = :time_of_tour,
                number_of_members = :number_of_members,
                number_of_2_seater_utvs = :number_of_2_seater_utvs,
                number_of_3_seater_utvs = :number_of_3_seater_utvs,
                number_of_4_seater_utvs = :number_of_4_seater_utvs,
                number_of_5_seater_utvs = :number_of_5_seater_utvs,
                pickup_location = :pickup_location,
                dropoff_location = :dropoff_location,
                updated_at = NOW()
            WHERE id = :id'
        );

        $statement->execute($data);
    }

    public function delete(int $id): void
    {
        $statement = $this->db()->prepare('DELETE FROM tickets WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}

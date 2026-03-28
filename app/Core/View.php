<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = []): void
    {
        $viewFile = BASE_PATH . '/app/Views/' . $view . '.php';

        if (!is_file($viewFile)) {
            http_response_code(500);
            echo 'View not found.';
            exit;
        }

        extract($data, EXTR_SKIP);

        require BASE_PATH . '/app/Views/layouts/header.php';
        require $viewFile;
        require BASE_PATH . '/app/Views/layouts/footer.php';
    }
}

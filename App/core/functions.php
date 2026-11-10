<?php
function isPasswordHash(string $value): bool
{
    return password_get_info($value)['algoName'] !== 'unknown';
}

function setmessage($message, $type)
{
    $_SESSION['message'] = [
        'text' => $message,
        'type' => $type
    ];
}

function showmessage($type = null, $field = null)
{
    // General message
    if ($type !== 'error' && isset($_SESSION['message'])) {
        $text = $_SESSION['message']['text'];
        $messageType = $_SESSION['message']['type'];

        if ($type === null || $messageType === $type) {
            echo "<div class='alert alert-$messageType'>$text</div>";
            unset($_SESSION['message']);
        }
    }

    // Validation errors
    if ($type === 'error' && !empty($_SESSION['errors'])) {
        if ($field === null) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div class='text-danger mt-1'>" . htmlspecialchars($error, ENT_QUOTES) . "</div>";
            }
            unset($_SESSION['errors']);
        } elseif (isset($_SESSION['errors'][$field])) {
            echo "<div class='text-danger mt-1'>" . htmlspecialchars($_SESSION['errors'][$field], ENT_QUOTES) . "</div>";
            unset($_SESSION['errors'][$field]);
        }
    }

    return "";
}

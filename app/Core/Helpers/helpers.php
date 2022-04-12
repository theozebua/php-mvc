<?php

if (!function_exists('baseUrl')) {

    /**
     * Base URL
     */
    function baseUrl(?string $url = ''): string
    {
        global $config;
        return rtrim(getenv('APP_BASE_URL'), '/') . '/' . ltrim($url, '/');
    }
}

if (!function_exists('view')) {

    /**
     * Load the view from Veiws directory
     */
    function view(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . DIRECTORY_SEPARATOR . '../../Views/' . $view . '.php';
    }
}

if (!function_exists('getRequest')) {

    /**
     * GET request
     */
    function getRequest(?string $key = ''): string|array
    {
        unset($_GET['url']);
        return $key ? $_GET[$key] : $_GET;
    }
}

if (!function_exists('postRequest')) {

    /**
     * POST request
     */
    function postRequest(?string $key = ''): string|array
    {
        return $key ? $_POST[$key] : $_POST;
    }
}

if (!function_exists('fileRequest')) {

    /**
     * FILE request
     */
    function fileRequest(?string $key = ''): string|array
    {
        return $key ? $_FILES[$key] : $_FILES;
    }
}

if (!function_exists('upload')) {

    /**
     * Upload file
     */
    function upload(array $file, array $ext = [], int $maxSize, string $path): array
    {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
        $fileSize = $file['size'];

        if ($fileError === 4) {
            throw new Exception("File can not be empty");
        }
        if ($fileSize > $maxSize * 1048576) {
            throw new Exception("Max file size is {$maxSize} MB.");
        }
        if (!empty($ext) && !in_array(strtolower(pathinfo($fileName, PATHINFO_EXTENSION)), $ext)) {
            throw new Exception("File extension is not allowed.");
        }

        $directory = rtrim($path . DIRECTORY_SEPARATOR);

        if (!file_exists($directory)) {
            mkdir($directory);
        }

        $fileName = time() . '_' . $fileName;
        move_uploaded_file($fileTmpName, $directory . $fileName);

        return ['status' => true, 'path' => $path . '/' . $fileName];
    }
}

if (!function_exists('setFlashData')) {

    /**
     * Set session flashdata
     */
    function setFlashData(string $key, string $value)
    {
        $_SESSION[$key] = $value;
    }
}

if (!function_exists('getFlashData')) {

    /**
     * Get session flashdata
     */
    function getFlashData($key)
    {
        echo $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);
    }
}

if (!function_exists('redirectTo')) {

    /**
     * Redirect
     */
    function redirect(string $to, int $code = 302): void
    {
        header('Location: ' . $to, response_code: $code);
    }
}

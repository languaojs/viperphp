<?php

namespace System\Libraries;

if (basename($_SERVER['PHP_SELF']) == 'Upload.php') {
    exit("Direct access to this file is not allowed.");
}

class Upload {

    protected $config = [
        'upload_path'   => '../public/files/',
        'allowed_types' => ['jpg', 'jpeg', 'png', 'pdf'],
        'max_size'      => 2048, // In Kilobytes (2MB)
        'encrypt_name'  => true
    ];

    protected $messages = [];
    protected $uploadData = [];

    public function __construct($config = []) {
        if (!empty($config)) {
            $this->initialize($config);
        }
    }

    public function initialize($config) {
        $this->config = array_merge($this->config, $config);
    }

    public function do_upload($field = 'userfile') {
        if (!isset($_FILES[$field])) {
            $this->messages['error'] = "No file was selected.";
            return false;
        }

        $file = $_FILES[$field];

        // 1. Check for PHP upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->messages['error'] = "Upload error code: " . $file['error'];
            return false;
        }

        // 2. Check File Size
        if ($file['size'] > ($this->config['max_size'] * 1024)) {
            $this->messages['error'] = "File size exceeds the limit of " . $this->config['max_size'] . " KB.";
            return false;
        }

        // 3. Check Extension & Secure MIME Type
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        // finfo_close($finfo);

        if (!in_array($ext, $this->config['allowed_types'])) {
            $this->messages['error'] = "The file type is not allowed.";
            return false;
        }

        // 4. Prepare Filename
        $filename = $file['name'];
        if ($this->config['encrypt_name']) {
            $filename = md5(uniqid(rand(), true)) . '.' . $ext;
        }

        $targetPath = rtrim($this->config['upload_path'], '/') . '/' . $filename;

        // 5. Move File
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $this->uploadData = [
                'file_name' => $filename,
                'file_type' => $mime,
                'file_path' => $targetPath,
                'full_path' => realpath($targetPath),
                'file_size' => $file['size']
            ];
            return true;
        }

        $this->messages['error'] = "Failed to move uploaded file.";
        return false;
    }

    public function data() {
        return $this->uploadData;
    }

    public function display_errors() {
        return $this->messages;
    }
}
<?php

namespace App\Controllers;

use App\Models\Configure;

class ConfigurationController
{
    protected Configure $configModel;

    public function __construct()
    {
        $this->configModel = new Configure();
    }

    public function index()
    {
        $config = $this->configModel->getAll();
        view("configuration/index.view.php", ['config' => $config]);
    }

    public function update(string $key)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!$this->configModel->update($key, $data['value'])) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update configuration']);
            return;
        }
        echo json_encode(['success' => true, 'message' => 'Configuration updated successfully']);
    }

    public function delete(string $key)
    {
        if (!$this->configModel->delete($key)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete configuration']);
            return;
        }
        echo json_encode(['success' => true, 'message' => 'Configuration deleted successfully']);
    }
}

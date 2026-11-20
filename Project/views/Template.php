<?php
// Kelas Template: mengisi placeholder DATA_XXX pada file html di folder templates/
class Template
{
    private $content = "";
    private $data = array();

    // Membaca file template (nama tanpa .html)
    function __construct($name)
    {
        $path = dirname(__DIR__) . "/templates/" . $name . ".html";
        $this->content = file_get_contents($path);
    }

    // Mengisi placeholder, contoh: replace("NAME", "Budi") mengganti DATA_NAME
    function replace($key, $value)
    {
        $this->data[$key] = (string) $value;
    }

    // Menghasilkan html akhir (placeholder yang tidak diisi dikosongkan)
    function getContent()
    {
        $data = $this->data;
        return preg_replace_callback("/DATA_([A-Z0-9_]+)/", function ($m) use ($data) {
            return isset($data[$m[1]]) ? $data[$m[1]] : "";
        }, $this->content);
    }

    // Menampilkan html ke browser
    function write()
    {
        echo $this->getContent();
    }
}

// Escape teks supaya aman ditampilkan di html
function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

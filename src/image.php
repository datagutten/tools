<?php


namespace datagutten\tools;


use FileNotFoundException;
use GdImage;
use InvalidArgumentException;

class image
{
    /**
     * @var resource GD image resource
     */
    public $im;
    /**
     * @var string
     */
    public string $file;
    public int $width;
    public int $height;

    public function __construct($im, $file = null)
    {
        if (empty($im))
            throw new InvalidArgumentException('Argument is not resource');
        $this->im = $im;
        if (!empty($file))
            $this->file = $file;
        $this->update_size();
    }

    protected function update_size()
    {
        $this->width = imagesx($this->im);
        $this->height = imagesy($this->im);
    }

    public static function create_true_color(int $width, int $height): static
    {
        $im = imagecreatetruecolor($width, $height);
        return new static($im);
    }

    /**
     * @param $file
     * @return image
     * @throws FileNotFoundException
     */
    public static function from_png($file): static
    {
        if (!file_exists($file))
            throw new FileNotFoundException($file);
        return new static(imagecreatefrompng($file), $file);
    }

    /**
     * @param $x
     * @param $y
     * @param $width
     * @param $height
     * @return image
     */
    function crop($x, $y, $width, $height): static
    {
        $im2 = imagecreatetruecolor($width, $height);
        imagecopy($im2, $this->im, 0, 0, $x, $y, $width, $height);
        $this->im = $im2;
        $this->update_size();
        return $this;
    }

    public function resize($width, $height): static
    {
        $im2 = imagecreatetruecolor($width, $height);
        imagecopyresized($im2, $this->im, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
        $this->im = $im2;
        $this->update_size();
        return $this;
    }

    public function png(string $file = null): bool
    {
        return imagepng($this->im, $file);
    }

    /**
     * Get the index of the color of a pixel
     * @param int $x x-coordinate of the point.
     * @param int $y y-coordinate of the point.
     * @return int
     */
    public function colorat(int $x, int $y): int
    {
        return imagecolorat($this->im, $x, $y);
    }
}
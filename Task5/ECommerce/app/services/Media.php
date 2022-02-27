<?php
class Media
{
    private $img;
    public $errors;
    private $extension;
    public $imgName;
    /**
     * Get the value of img
     */

    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */

    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }
    public function sizeValidation(int $maxSize)
    {
        if ($this->img['size'] > $maxSize) {
            $this->errors[
                'size'
            ] = "<div class='alert alert-danger'>Too Large File , Max Size Is $maxSize Bytes </div>";
        }
        return $this;
    }
    public function extensionValidation(array $extAvailable)
    {
        $this->extension = pathinfo($this->img['name'], PATHINFO_EXTENSION);
        if (!in_array($this->extension, $extAvailable)) {
            $this->errors['extension'] =
                "<div class='alert alert-danger'>Not Available Extension , Available Extensions " .
                implode(' , ', $extAvailable) .
                '</div>';
        }
        return $this;
    }
    public function uploadImg(string $dir)
    {
        if (empty($this->errors)) {
            $this->imgName =
                time() . '-' . $_SESSION['user']->id . '.' . $this->extension;
            $path = "assets/img/$dir/$this->imgName";
            move_uploaded_file($this->img['tmp_name'], $path);
        }
        return $this;
    }
}
?>

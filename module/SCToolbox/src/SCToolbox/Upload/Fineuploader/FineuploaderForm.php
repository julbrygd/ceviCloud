<?php

namespace SCToolbox\Upload\Fineuploader;

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class FineuploaderForm {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    public function save($path) {
        return move_uploaded_file($_FILES['qqfile']['tmp_name'], $path);
    }

    /**
     * Get the original filename
     * @return string filename
     */
    public function getName() {
        return $_FILES['qqfile']['name'];
    }

    /**
     * Get the file size
     * @return integer file-size in byte
     */
    public function getSize() {
        return $_FILES['qqfile']['size'];
    }

}

?>

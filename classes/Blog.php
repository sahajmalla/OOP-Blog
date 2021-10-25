<?php


class Blog
{
    private $_db,
        $_data,
        $_sessionName,
        $_uploadedFileName,
        $_paginationCount,
        $_pageNo = 0;


    public function __construct()
    {
        $this->_db = DB::getInstance();

        $this->_sessionName =  Config::get('session/session_name');
    }


    public function getBlogsWithLimit()
    {
        if ($this->_db->query("SELECT * from posts LIMIT {$this->_pageNo}, $this->_paginationCount")) {
            $this->_data = $this->_db->results();
            return $this->_data;
        }
    }

    public function get($where = [])
    {
        if (!$this->_db->get('posts', $where)) {
            throw new Exception('There was an problem getting the blog.');
        }else{
            $this->_data = $this->_db->results();
        }
    }

    public function create($fields = [])
    {
        if (!$this->_db->insert('posts', $fields)) {
            throw new Exception('There was an problem creating an account.');
        }
    }

    public function update($id, $fields = [])
    {
        if (!$this->_db->update('posts', $id, $fields)) {
            throw new Exception('There was an problem creating an account.');
        }
    }

    public function delete($id)
    {
        if (!$this->_db->delete('posts', ['id', '=', $id])) {
            throw new Exception('There was an problem creating an account.');
        }
    }

    public function data()
    {
        return $this->_data;
    }

    public function upload($filename)
    {
        $ext = pathinfo($_FILES["$filename"]['name'])['extension'];
        $this->_uploadedFileName = $this->generateRandomString() . ".$ext";
        $location = "images/";
        if (move_uploaded_file($_FILES["$filename"]['tmp_name'], $location . $this->_uploadedFileName)) {
            return true;
        }
        return false;
    }

    private function generateRandomString($length = 10)
    {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length);
    }

    public function getUploadedFileName()
    {
        return $this->_uploadedFileName;
    }

    public function findById($id = null)
    {
        if ($id) {
            $data = $this->_db->get('posts', ['id', '=', $id]);

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function paginate($paginationCount)
    {

        $data = $this->_db->query("SELECT * from posts");
        $pageLinkCount = $this->_db->count();
        $this->_paginationCount = $paginationCount;
        $pageLinks = ($pageLinkCount) / $paginationCount;
        $pageLinks = ceil($pageLinks);

        echo "<div class='flex'>";
        for ($index = 1; $index <= $pageLinks; $index++) {
            echo " <a href='{$this->getCurrentPage()}?page={$index}' class='flex items-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-white rounded-md dark:bg-gray-800 dark:text-gray-200 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-gray-200'>";
            echo $index;
            echo "</a>";
        }
        echo "</div>";
    }

    private function getCurrentPage()
    {
        return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
    }

    public function getPageNumber()
    {
        if (Input::get('page') == "" || Input::get('page') == "1") {
            $this->_page = 0;
        } else {
        }
    }
}

<?php
include_once __DIR__ . '\..\config\connection.php';
include_once __DIR__ . '\..\config\crud.php';
class Review extends connection implements crud{
    private $value;
    private $product_fk_id;
    private $user_fk_id;
    private $comment;
    private $created_at;
    private $updated_at;

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of product_fk_id
     */ 
    public function getProduct_fk_id()
    {
        return $this->product_fk_id;
    }

    /**
     * Set the value of product_fk_id
     *
     * @return  self
     */ 
    public function setProduct_fk_id($product_fk_id)
    {
        $this->product_fk_id = $product_fk_id;

        return $this;
    }

    /**
     * Get the value of user_fk_id
     */ 
    public function getUser_fk_id()
    {
        return $this->user_fk_id;
    }

    /**
     * Set the value of user_fk_id
     *
     * @return  self
     */ 
    public function setUser_fk_id($user_fk_id)
    {
        $this->user_fk_id = $user_fk_id;

        return $this;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */ 
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    public function create()
    {
        $query = "insert into reviews values($this->value,$this->product_fk_id,$this->user_fk_id,'$this->comment',default,default)";
        // print_r($query);die;
        return $this->runDML($query);
    }
    public function read()
    {
        $query = "select reviews.* ,users.name as user_name from reviews join users on users.id = reviews.user_fk_id where reviews.product_fk_id = $this->product_fk_id ";
        return $this->runDQL($query);
    }
    public function update()
    {
    }
    public function delete()
    {
    }
}

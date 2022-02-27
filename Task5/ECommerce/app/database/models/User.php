<?php
include_once __DIR__ . '\..\config\connection.php';
include_once __DIR__ . '\..\config\crud.php';
class User extends connection implements crud
{
    private $id;
    private $name;
    private $gender;
    private $phone;
    private $email;
    private $status;
    private $password;
    private $img;
    private $code;
    private $created_at;
    private $updated_at;

    /**
     * Get the value of id
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */

    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of gender
     */

    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */

    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of phone
     */

    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     */

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of status
     */

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of password
     */

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */

    public function setPassword($password)
    {
        $this->password = sha1($password);

        return $this;
    }

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

    /**
     * Get the value of code
     */

    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */

    public function setCode($code)
    {
        $this->code = $code;

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
        $query = "INSERT INTO `USERS` (`name`,`gender`,`phone`,`email`,`password`,`code`) VALUES ('$this->name','$this->gender','$this->phone','$this->email','$this->password',$this->code)";
        return $this->runDML($query);
    }
    public function checkEmailExists()
    {
        $query = "select * from users where email = '$this->email'";
        return $this->runDQL($query);
    }
    public function checkPhoneExists()
    {
        $query = "select * from users where phone = '$this->phone'";
        return $this->runDQL($query);
    }
    public function read()
    {
    }
    public function update()
    {
        $image = '';
        if ($this->img) {
            $image = ", img = '$this->img' ";
        }
        $query = "UPDATE users SET phone =  '$this->phone' , name =  '$this->name' , gender =  '$this->gender' $image WHERE email = '$this->email' ";

        return $this->runDML($query);
    }
    public function delete()
    {
    }
    public function verifyCode()
    {
        $query = "select * from users where code = $this->code and email = '$this->email'";
        return $this->runDQL($query);
    }
    public function updateStatus()
    {
        $query = "UPDATE users SET STATUS =  $this->status WHERE email = '$this->email' ";
        return $this->runDML($query);
    }
    public function login()
    {
        $query = "select * from users where email = '$this->email' and password = '$this->password'";
        return $this->runDQL($query);
    }
    public function updateCode()
    {
        $query = "UPDATE users SET code =  $this->code WHERE email = '$this->email' ";
        return $this->runDML($query);
    }
    public function updatePassword()
    {
        $query = "UPDATE users SET password =  '$this->password' WHERE email = '$this->email' ";
        return $this->runDML($query);
    }
    public function updateEmail()
    {
        $query = "UPDATE users SET email =  '$this->email' , STATUS =  $this->status WHERE id = '$this->id' ";
        return $this->runDML($query);
    }
}

<?php 
include_once __DIR__.'/../database/models/User.php';
class registerRequest{
    private $name;
    private $phone;
    private $password;
    private $email;
    private $gender;
    private $confirmPassword;
    

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
        $this->password = $password;

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
     * Get the value of confirmPassword
     */ 
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * Set the value of confirmPassword
     *
     * @return  self
     */ 
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
    public function emailValidation()
    {
        //required
        $errors=[];
        if (empty($this->email)) {
            $errors['email_required']="<div class='alert alert-danger'>Email Is Required</div>";
        }
        else
        {
        //has specific pattern
        $pattern='/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/';
        if(!preg_match($pattern,$this->email)){
            $errors['email_pattern']="<div class='alert alert-danger'>Email Is Invalid</div>";
        };
        }
        return $errors;
    }
    public function passwordValidation()
    {
        //required
        $errors=[];
        if (empty($this->password)) {
            $errors['password_required']="<div class='alert alert-danger'>Password Is Required</div>";
        }
        return $errors;
    }
    public function confirmPasswordValidation()
    {
        //required
        $errors=[];
        if (empty($this->confirmPassword)) {
            $errors['confirmPassword_required']="<div class='alert alert-danger'>Confirm Password Is Required</div>";
        }
        return $errors;
    }
    public function confirmPasswordEqualPassword()
    {
        //required
        $errors=[];
        if (empty($this->passwordValidation()) && empty($this->confirmPasswordValidation())) {
            if ($this->confirmPassword == $this->password) {
                $errors=$this->passwordPattern();
            }
            else{
                $errors['notmatched']="<div class='alert alert-danger'>Password && Confirm Password Not Matched</div>";
            }
        }
        return $errors;
    }
    public function passwordPattern()
    {
        //has specific pattern
        $errors=[];
        $pattern='/^(?=[^\d_].*?\d)\w(\w|[!@#$%]){7,20}/';
        if(!preg_match($pattern,$this->password)){
            $errors['password_pattern']="<div class='alert alert-danger'>Password requires a length of 8 to 20 aplhanumeric characters and select special characters. The password also can not start with a digit, underscore or special character and must contain at least one digit</div>";
        };
        return $errors;
    }
    public function emailExists(){
        $errors=[];
        $user = new User;
        $user->setEmail($this->email);
        $result=$user->checkEmailExists();
        if ($result) {
            $errors['email_exists']="<div class='alert alert-danger'>Email Already Exists</div>";
        }
        return $errors;
    }
    public function phoneExists(){
        $errors=[];
        $user = new User;
        $user->setPhone($this->phone);
        $result=$user->checkPhoneExists();
        if ($result) {
            $errors['phone_exists']="<div class='alert alert-danger'>Phone Already Exists</div>";
        }
        return $errors;
    }
}

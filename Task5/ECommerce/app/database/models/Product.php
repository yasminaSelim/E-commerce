<?php
include_once __DIR__ . '\..\config\connection.php';
include_once __DIR__ . '\..\config\crud.php';
class Product extends connection implements crud
{
    private $id;
    private $name_ar;
    private $name_en;
    private $status;
    private $img;
    private $desc_ar;
    private $desc_en;
    private $price;
    private $quantity;
    private $created_at;
    private $updated_at;
    private $brand_fk_id;
    private $subcategories_fk_id;
    private $category_id;

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
     * Get the value of name_ar
     */
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

        return $this;
    }

    /**
     * Get the value of name_en
     */
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of categories_fk_id
     */
    public function getCategories_fk_id()
    {
        return $this->categories_fk_id;
    }

    /**
     * Set the value of categories_fk_id
     *
     * @return  self
     */
    public function setCategories_fk_id($categories_fk_id)
    {
        $this->categories_fk_id = $categories_fk_id;

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
    /**
     * Get the value of desc_ar
     */
    public function getDesc_ar()
    {
        return $this->desc_ar;
    }

    /**
     * Set the value of desc_ar
     *
     * @return  self
     */


    /**
     * Get the value of desc_en
     */
    public function getDesc_en()
    {
        return $this->desc_en;
    }

    /**
     * Set the value of desc_en
     *
     * @return  self
     */
    public function setDesc_en($desc_en)
    {
        $this->desc_en = $desc_en;

        return $this;
    }
    public function setDesc_ar($desc_ar)
    {
        $this->desc_ar = $desc_ar;

        return $this;
    }
    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of brand_fk_id
     */
    public function getBrand_fk_id()
    {
        return $this->brand_fk_id;
    }

    /**
     * Set the value of brand_fk_id
     *
     * @return  self
     */
    public function setBrand_fk_id($brand_fk_id)
    {
        $this->brand_fk_id = $brand_fk_id;

        return $this;
    }

    /**
     * Get the value of subcategories_fk_id
     */
    public function getSubcategories_fk_id()
    {
        return $this->subcategories_fk_id;
    }

    /**
     * Set the value of subcategories_fk_id
     *
     * @return  self
     */

    public function setSubcategories_fk_id($subcategories_fk_id)
    {
        $this->subcategories_fk_id = $subcategories_fk_id;

        return $this;
    }

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }
    public function create()
    {
    }
    public function read()
    {
        $query = "select id ,img ,price,desc_en, name_en from products_details where status=$this->status order by price , name_en";
        return $this->runDQL($query);
    }
    public function update()
    {
    }
    public function delete()
    {
    }
    public function readBySubId()
    {
        $query = "select id ,img ,price,desc_en, name_en from products_details where status=$this->status and subcatergories_fk_id =$this->subcategories_fk_id order by price , name_en";
        return $this->runDQL($query);
    }
    public function readByCatId()
    {
        $query = "select id ,img ,price,desc_en, name_en from products_details where status=$this->status and category_id =$this->category_id order by price , name_en";
        return $this->runDQL($query);
    }
    public function productById()
    {
        $query = "select * from products_details where status=$this->status and id =$this->id";
        return $this->runDQL($query);
    }
    public function readByBrandId()
    {
        $query = "select * from products_details where status=$this->status and brand_fk_id =$this->brand_fk_id order by price , name_en";
        //print_r($query);die;
        return $this->runDQL($query);
    }
    public function mostRecentProducts()
    {
        $query = "select * from products_details where STATUS=$this->status  order by created_at DESC limit 4";
        return $this->runDQL($query);
    }
    public function mostRatedProducts()
    {
        $query = "SELECT * FROM `products_details` where status = $this->status order by reviews_count desc,reviews_average DESC limit 4";
        return $this->runDQL($query);
    }
    public function mostOrderedProducts()
    {
        $query = "SELECT * ,count(products.id) as count,sum(products_orders.quantity) as total_quantity FROM `products` join products_orders on products.id = products_orders.product_fk_id where STATUS = $this->status  group by products.id  order by count DESC , total_quantity DESC  limit 4";
        return $this->runDQL($query);
    }
}

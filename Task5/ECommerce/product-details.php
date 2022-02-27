<?php $title = 'Product Details';
include_once 'layouts/header.php';
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/database/models/Product.php';
include_once 'app/database/models/Review.php';
$reviews = new Review;
if (isset($_POST['review'])) {
    //    print_r($_POST);die;
    $reviews->setProduct_fk_id($_GET['prod']);
    $reviews->setValue($_POST['value']);
    // $reviews->setUser_fk_id(3);
    $reviews->setUser_fk_id($_SESSION['user']->id);
    $reviews->setComment($_POST['comment']);
    $resultAddReview = $reviews->create();
    if ($resultAddReview) {
        $msgReview = "<div class='alert alert-success'>Thank You</div>";
    } else {
        $msgReview = "<div class='alert alert-danger'>Try Letar </div>";
    }
}
if ($_GET) {
    if (isset($_GET['prod'])) {
        if (is_numeric($_GET['prod'])) {
            $products = new Product();
            $products->setStatus(1);
            $products->setId($_GET['prod']);
            $productsResult = $products->productById();
            if ($productsResult) {
                $product = $productsResult->fetch_object();
                // print_r($product);die;
            } else {
                header('Location:errors/404.php');
                die;
            }
        } else {
            header('Location:errors/404.php');
            die;
        }
    } else {
        header('Location:errors/404.php');
        die;
    }
}
?>
<style>
    * {
        margin: 0;
        padding: 0;
    }

    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #519f10;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #519f10;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #519f10;
    }
</style>
<!-- Product Details Area Start -->
<div class="product-details pt-100 pb-95">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="product-details-img">
                    <img class="zoompro" src="assets/img/product/<?= $product->img ?>" data-zoom-image="assets/img/product/<?= $product->img ?>" alt="zoom" />
                    <span>-29%</span>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="product-details-content">
                    <h4><?= $product->name_en ?></h4>
                    <div class="rating-review">
                        <div class="pro-dec-rating">
                            <?php for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $product->reviews_average) { ?>
                                    <i class="ion-android-star-outline theme-star"></i>
                                <?php } else { ?>
                                    <i class="ion-android-star-outline"></i>
                            <?php }
                            } ?>

                        </div>
                        <div class="pro-dec-review">
                            <ul>
                                <li><?= $product->reviews_count ?> Reviews </li>
                                <li> Add Your Reviews</li>
                            </ul>
                        </div>
                    </div>
                    <span><?= $product->price ?> EGP</span>
                    <div class="in-stock">
                        <?php
                        if ($product->quantity <= 5 and $product->quantity >= 1) {
                            $msg = "In Stock";
                            $color = "warning";
                        } elseif ($product->quantity > 5) {
                            $msg = "In Stock";
                            $color = "success";
                        } else {
                            $msg = "Out Of Stock";
                            $color = "danger";
                        }
                        ?>
                        <p>Available: <span class="text-<?= $color ?>"><?= $msg ?></span></p>
                    </div>
                    <p><?= $product->desc_en ?> </p>
                    <div class="quality-add-to-cart">
                        <div class="quality">
                            <label>Qty:</label>
                            <input class="cart-plus-minus-box" type="text" name="qtybutton" value="<?= $product->quantity ?>">
                        </div>
                        <div class="shop-list-cart-wishlist">
                            <a title="Add To Cart" href="#">
                                <i class="icon-handbag"></i>
                            </a>
                            <a title="Wishlist" href="#">
                                <i class="icon-heart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="pro-dec-categories">
                        <ul>
                            <li class="categories-title">Categories:</li>
                            <li><a href="shop.php?subcat=<?= $product->subcatergories_fk_id ?>"><?= $product->category_name_en ?>,</a></li>
                            <li><a href="shop.php?cat=<?= $product->category_id ?>"><?= $product->sub_name_en ?>, </a></li>
                            <li><a href="shop.php?brand=<?= $product->brand_fk_id ?>"><?= $product->brand_name_en ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Details Area End -->
<div class="description-review-area pb-70">
    <div class="container">
        <div class="description-review-wrapper">
            <div class="description-review-topbar nav text-center">
                <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                <a data-toggle="tab" href="#des-details3">Review</a>
            </div>
            <div class="tab-content description-review-bottom">
                <div id="des-details1" class="tab-pane active">
                    <div class="product-description-wrapper">
                        <p><?= $product->desc_en ?></p>
                    </div>
                </div>
                <div id="des-details3" class="tab-pane">
                    <div class="rattings-wrapper">
                        <?php
                        $reviews->setProduct_fk_id($product->id);
                        $reviewResult = $reviews->read();
                        if (!empty($reviewResult)) {
                            $reviewData = $reviewResult->fetch_all(MYSQLI_ASSOC);
                            foreach ($reviewData as $index => $review) { ?>
                                <div class="sin-rattings">
                                    <div class="star-author-all">
                                        <div class="ratting-star f-left">
                                            <?php for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $review['value']) { ?>
                                                    <i class="ion-star theme-color"></i>
                                                <?php } else { ?>
                                                    <i class="ion-android-star-outline"></i>
                                            <?php }
                                            } ?>
                                            <span>(<?= $review['value'] ?>)</span>
                                        </div>
                                        <div class="ratting-author f-right">
                                            <h3><?= $review['user_name'] ?></h3>
                                            <span><?= $review['created_at'] ?></span>
                                        </div>
                                    </div>
                                    <p><?= $review['comment'] ?></p>
                                </div>
                        <?php }
                        } else {
                            echo "<div class='alert alert-warning'>No Reviews</div>";
                        }
                        ?>
                    </div>
                    <?php if (isset($_SESSION['user'])) {
                        if (isset($msgReview)) {
                            echo $msgReview;
                        }
                     ?>
                    <div class="ratting-form-wrapper">
                        <h3>Add your Comments :</h3>
                        <div class="ratting-form">
                            <form method="post">
                                <div class="row">
                                    <div class="star-box">
                                        <h2>Rating:</h2>
                                        <div class="ratting-star">
                                            <div class="rate">
                                                <input type="radio" id="star5" name="value" value="5" />
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="value" value="4" />
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="value" value="3" />
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="value" value="2" />
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="value" value="1" />
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12  ">
                                        <div class="rating-form-style form-submit">
                                            <textarea name="comment" placeholder=" Comment"></textarea>
                                            <input type="submit" name="review" value="Add Review">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php  }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-area pb-100">
    <div class="container">
        <div class="product-top-bar section-border mb-35">
            <div class="section-title-wrap">
                <h3 class="section-title section-bg-white">Related Products</h3>
            </div>
        </div>
        <div class="featured-product-active hot-flower owl-carousel product-nav">
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img alt="" src="assets/img/product/product-1.jpg">
                    </a>
                    <span>-30%</span>
                    <div class="product-action">
                        <a class="action-wishlist" href="#" title="Wishlist">
                            <i class="ion-android-favorite-outline"></i>
                        </a>
                        <a class="action-cart" href="#" title="Add To Cart">
                            <i class="ion-ios-shuffle-strong"></i>
                        </a>
                        <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                            <i class="ion-ios-search-strong"></i>
                        </a>
                    </div>
                </div>
                <div class="product-content text-left">
                    <div class="product-hover-style">
                        <div class="product-title">
                            <h4>
                                <a href="product-details.html">Le Bongai Tea</a>
                            </h4>
                        </div>
                        <div class="cart-hover">
                            <h4><a href="product-details.html">+ Add to cart</a></h4>
                        </div>
                    </div>
                    <div class="product-price-wrapper">
                        <span>$100.00 -</span>
                        <span class="product-price-old">$120.00 </span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img alt="" src="assets/img/product/product-2.jpg">
                    </a>
                    <div class="product-action">
                        <a class="action-wishlist" href="#" title="Wishlist">
                            <i class="ion-android-favorite-outline"></i>
                        </a>
                        <a class="action-cart" href="#" title="Add To Cart">
                            <i class="ion-ios-shuffle-strong"></i>
                        </a>
                        <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                            <i class="ion-ios-search-strong"></i>
                        </a>
                    </div>
                </div>
                <div class="product-content text-left">
                    <div class="product-hover-style">
                        <div class="product-title">
                            <h4>
                                <a href="product-details.html">Society Ice Tea</a>
                            </h4>
                        </div>
                        <div class="cart-hover">
                            <h4><a href="product-details.html">+ Add to cart</a></h4>
                        </div>
                    </div>
                    <div class="product-price-wrapper">
                        <span>$100.00 -</span>
                        <span class="product-price-old">$120.00 </span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img alt="" src="assets/img/product/product-3.jpg">
                    </a>
                    <span>-30%</span>
                    <div class="product-action">
                        <a class="action-wishlist" href="#" title="Wishlist">
                            <i class="ion-android-favorite-outline"></i>
                        </a>
                        <a class="action-cart" href="#" title="Add To Cart">
                            <i class="ion-ios-shuffle-strong"></i>
                        </a>
                        <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                            <i class="ion-ios-search-strong"></i>
                        </a>
                    </div>
                </div>
                <div class="product-content text-left">
                    <div class="product-hover-style">
                        <div class="product-title">
                            <h4>
                                <a href="product-details.html">Green Tea Tulsi</a>
                            </h4>
                        </div>
                        <div class="cart-hover">
                            <h4><a href="product-details.html">+ Add to cart</a></h4>
                        </div>
                    </div>
                    <div class="product-price-wrapper">
                        <span>$100.00 -</span>
                        <span class="product-price-old">$120.00 </span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img alt="" src="assets/img/product/product-4.jpg">
                    </a>
                    <div class="product-action">
                        <a class="action-wishlist" href="#" title="Wishlist">
                            <i class="ion-android-favorite-outline"></i>
                        </a>
                        <a class="action-cart" href="#" title="Add To Cart">
                            <i class="ion-ios-shuffle-strong"></i>
                        </a>
                        <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                            <i class="ion-ios-search-strong"></i>
                        </a>
                    </div>
                </div>
                <div class="product-content text-left">
                    <div class="product-hover-style">
                        <div class="product-title">
                            <h4>
                                <a href="product-details.html">Best Friends Tea</a>
                            </h4>
                        </div>
                        <div class="cart-hover">
                            <h4><a href="product-details.html">+ Add to cart</a></h4>
                        </div>
                    </div>
                    <div class="product-price-wrapper">
                        <span>$100.00 -</span>
                        <span class="product-price-old">$120.00 </span>
                    </div>
                </div>
            </div>
            <div class="product-wrapper">
                <div class="product-img">
                    <a href="product-details.html">
                        <img alt="" src="assets/img/product/product-5.jpg">
                    </a>
                    <span>-30%</span>
                    <div class="product-action">
                        <a class="action-wishlist" href="#" title="Wishlist">
                            <i class="ion-android-favorite-outline"></i>
                        </a>
                        <a class="action-cart" href="#" title="Add To Cart">
                            <i class="ion-ios-shuffle-strong"></i>
                        </a>
                        <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                            <i class="ion-ios-search-strong"></i>
                        </a>
                    </div>
                </div>
                <div class="product-content text-left">
                    <div class="product-hover-style">
                        <div class="product-title">
                            <h4>
                                <a href="product-details.html">Instant Tea Premix</a>
                            </h4>
                        </div>
                        <div class="cart-hover">
                            <h4><a href="product-details.html">+ Add to cart</a></h4>
                        </div>
                    </div>
                    <div class="product-price-wrapper">
                        <span>$100.00 -</span>
                        <span class="product-price-old">$120.00 </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <!-- Thumbnail Large Image start -->
                        <div class="tab-content">
                            <div id="pro-1" class="tab-pane fade show active">
                                <img src="assets/img/product-details/product-detalis-l1.jpg" alt="">
                            </div>
                            <div id="pro-2" class="tab-pane fade">
                                <img src="assets/img/product-details/product-detalis-l2.jpg" alt="">
                            </div>
                            <div id="pro-3" class="tab-pane fade">
                                <img src="assets/img/product-details/product-detalis-l3.jpg" alt="">
                            </div>
                            <div id="pro-4" class="tab-pane fade">
                                <img src="assets/img/product-details/product-detalis-l4.jpg" alt="">
                            </div>
                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        <div class="product-thumbnail">
                            <div class="thumb-menu owl-carousel nav nav-style" role="tablist">
                                <a class="active" data-toggle="tab" href="#pro-1"><img src="assets/img/product-details/product-detalis-s1.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-2"><img src="assets/img/product-details/product-detalis-s2.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-3"><img src="assets/img/product-details/product-detalis-s3.jpg" alt=""></a>
                                <a data-toggle="tab" href="#pro-4"><img src="assets/img/product-details/product-detalis-s4.jpg" alt=""></a>
                            </div>
                        </div>
                        <!-- Thumbnail image end -->
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-12">
                        <div class="modal-pro-content">
                            <h3>Dutchman's Breeches </h3>
                            <div class="product-price-wrapper">
                                <span class="product-price-old">£162.00 </span>
                                <span>£120.00</span>
                            </div>
                            <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
                            <div class="quick-view-select">
                                <div class="select-option-part">
                                    <label>Size*</label>
                                    <select class="select">
                                        <option value="">S</option>
                                        <option value="">M</option>
                                        <option value="">L</option>
                                    </select>
                                </div>
                                <div class="quickview-color-wrap">
                                    <label>Color*</label>
                                    <div class="quickview-color">
                                        <ul>
                                            <li class="blue">b</li>
                                            <li class="red">r</li>
                                            <li class="pink">p</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="product-quantity">
                                <div class="cart-plus-minus">
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="02">
                                </div>
                                <button>Add to cart</button>
                            </div>
                            <span><i class="fa fa-check"></i> In stock</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
<?php include_once 'layouts/footer.php';
?>
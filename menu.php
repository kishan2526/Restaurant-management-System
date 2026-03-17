<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   header('location:home.php');
   exit;
}

include 'components/add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Our Menu</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .container {
         max-width: 1200px;
         margin: auto;
         padding: 20px;
         text-align: center;
      }
      .container h1 {
         font-size: 2.2rem;
         color: #333;
         margin-bottom: 1rem;
      }
      .menu {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
         gap: 1rem;
      }
      .menu .item {
         background: #f7f7f7;
         border-radius: 8px;
         padding: 1rem;
         box-shadow: 0 2px 8px rgba(0,0,0,0.1);
         transition: transform 0.2s;
      }
      .menu .item:hover {
         transform: translateY(-5px);
      }
      .menu .item h3 {
         margin: 0.5rem 0;
         color: #222;
      }
      .menu .item p {
         font-weight: bold;
         color: #555;
      }
      .products {
         padding: 40px 20px;
      }
      .products .title {
         text-align: center;
         font-size: 2rem;
         margin-bottom: 2rem;
         color: #333;
      }
      .products .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
         gap: 1.5rem;
      }
      .products .box {
         border: 1px solid #ddd;
         border-radius: 8px;
         padding: 1rem;
         text-align: center;
         position: relative;
         background: #fff;
         transition: box-shadow 0.3s;
      }
      .products .box:hover {
         box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      }
      .products .box img {
         width: 100%;
         height: 180px;
         object-fit: cover;
         border-radius: 6px;
      }
      .products .box .cat {
         display: inline-block;
         margin-top: 0.5rem;
         color: #888;
         font-size: 0.9rem;
      }
      .products .box .name {
         margin-top: 0.5rem;
         font-size: 1.1rem;
         color: #222;
      }
      .products .box .flex {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin-top: 0.8rem;
      }
      .products .box .price {
         font-size: 1.2rem;
         color: #E67E22;
      }
      .products .box .qty {
         width: 50px;
         padding: 0.3rem;
      }
      .products .box .fas {
         position: absolute;
         top: 10px;
         font-size: 1.2rem;
         color: #333;
         cursor: pointer;
      }
      .products .box .fa-eye {
         right: 35px;
      }
      .products .box .fa-shopping-cart {
         right: 10px;
         background: none;
         border: none;
      }
   </style>

</head>

<body>

<!-- header section -->
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>Our Menu</h3>
   <p><a href="home.php">Home</a> <span> / Menu</span></p>
</div>

<div class="container">
   <h1>Restaurant Menu</h1>
   <div class="menu">
      <div class="item">
         <h3>Burger</h3>
         <p>₹5</p>
      </div>
      <div class="item">
         <h3>Pizza</h3>
         <p>₹8</p>
      </div>
      <div class="item">
         <h3>Pasta</h3>
         <p>₹7</p>
      </div>
      <div class="item">
         <h3>Salad</h3>
         <p>₹4</p>
      </div>
   </div>
</div>

<section class="products">
   <h1 class="title">Latest Dishes</h1>
   <div class="box-container">
   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= htmlspecialchars($fetch_products['id']); ?>">
      <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_products['name']); ?>">
      <input type="hidden" name="price" value="<?= htmlspecialchars($fetch_products['price']); ?>">
      <input type="hidden" name="image" value="<?= htmlspecialchars($fetch_products['image']); ?>">
      <a href="quick_view.php?pid=<?= urlencode($fetch_products['id']); ?>" class="fas fa-eye"></a>
      <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
      <img src="uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="<?= htmlspecialchars($fetch_products['name']); ?>">
      <a href="category.php?category=<?= urlencode($fetch_products['category']); ?>" class="cat"><?= htmlspecialchars($fetch_products['category']); ?></a>
      <div class="name"><?= htmlspecialchars($fetch_products['name']); ?></div>
      <div class="flex">
         <div class="price">₹<?= htmlspecialchars($fetch_products['price']); ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1">
      </div>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }
   ?>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

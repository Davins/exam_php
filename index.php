<?php
$_title = 'Welcome to Examon';
require_once('components/header.php');
$data = file_get_contents(__DIR__.'/shops/shop-1.txt');
$json = json_decode($data);
?>
     <div id="main-content-container">
        <div class="splash">
            <div class='splash-wrapper'>
                <img class='splash-img' src='images/splash-1.png' alt='splash image'>
            </div>
    </a>
    </div>
    <h1 class="partner-heading">Items from our Partners</h1>
    <main id="items-container">

        <?php
        foreach ($json as $item) {
            echo    "<article class='shop-item'>
                    <h2>$item->title_en</h2>
                    <img src='https://coderspage.com/2021-F-Web-Dev-Images/$item->image'>
                    <p class='item-desc'>$item->desc_en</p>
                    <h3>$item->price</h3>
                    </article>";
        }
        ?>

    </main>
<?php
require_once('components/footer.php');
?>

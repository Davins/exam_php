<?php
$_title = 'Items';
$_className = "item-page";
require_once 'components/header.php';
$current_user = $_SESSION['user_name'];
$itemApi = "localhost/apis/api-fetch-items.php";
function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'user_id=' . $_SESSION['user_id'] . '&method=post&access_token=xyz'); // define what you want to post
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}
$items = json_decode(file_get_contents_curl($itemApi), true);
?>


<!-- Main HTML START -->
<div class="content-container">
    <h1>Upload your own items</h1>
</div>
<div class="form-wrapper">
    <form id="item-form" onsubmit="return false">
        <label for="item-name">Item Name</label>
        <input type="text" id="item-name" name="item_name">
        <label for="item-desc">Item Description</label>
        <input type="text" id="item-desc" name="item_desc">
        <label for="item-price">Item Price</label>
        <input type="number" id="item-price" name="item_price" step=".01">
        <label for="item-image">Item Image</label>
        <input type="file" size="60" id="item-image" name="item_image">
        <button class="sign-up-btn" onclick="upload_item()">Add Item</button>
    </form>
</div>

<div class="content-container item-header">
    <H2><?= "$current_user's items"; ?></H2>
</div>
<div id="your-items">
    <?php
    foreach ($items as $item) {
        echo "
        <div class='your-uploads'>
            <h3 class='item-name' data-itemId='{$item['item_id']}'>{$item['item_name']}</h3>
            <button class='sign-up-btn open-modal'>Edit Item</button>
            <img class=''item-image src='./item-images/{$item['item_image']}'/>
            <p class='item-desc'>{$item['item_desc']}</p>
            <p class='item-price'>{$item['item_price']} £</p>
         
        </div>

     
        ";
    };
    ?>
</div>
<div class='modal hide'>
    <div class="modal-content">
        <span class="close-btn">X</span>
        <h2>Item Name</h2>
        <div class="form-wrapper">
            <form class="update-form" onsubmit="return false">
                <label for="item-name-edit">Item Name</label>
                <input name="item-name-edit" id="item-name-edit" value="">
                <label for="item-desc-edit">Item Description</label>
                <input name="item-desc-edit" id="item-desc-edit" value="">
                <label for="item-price-edit">Item Price</label>
                <input name="item-price-edit" id="item-price-edit" value="">
                <label for="item-image-edit">Item Image</label>
                <input name="item-image-edit" id="item-image-edit" type="file" value="">
                <img class="current-image" alt="current image">
                <div class="button-wrapper">
                    <button class="sign-up-btn cancel">Cancel</button>
                    <button class="sign-up-btn" onclick="updateItem()">Update Item</button>
                </div>
            </form>
        </div>

    </div>

</div>


<script>
    let itemId;
    async function upload_item() {
        const form = document.querySelector("#item-form")

        let conn = await fetch("apis/api-upload-item.php", {
            method: "POST",
            body: new FormData(form),
        });
        const res = await conn.json()
        console.log(res)
        location.href = "/items.php";



    }
    const modal = document.querySelector(".modal");
    const modals = document.querySelectorAll(".open-modal");

    document.querySelector(".cancel").addEventListener("click", closeModal);
    document.querySelector(".close-btn").addEventListener("click", closeModal);
    modals.forEach(singleModal => {
        singleModal.addEventListener("click", function(e) {
            modal.classList.remove("hide");
            itemId = e.target.parentElement.querySelector("h3").getAttribute('data-itemId');

            getContent();
        });
    })







    function closeModal() {

        modal.classList.add("hide");
    }


    async function getContent() {

        const formData = new FormData();
        formData.append('item_id', itemId)
        let conn = await fetch("apis/api-fetch-item.php", {
            method: "POST",
            body: formData,
        });
        const res = await conn.json()
        console.log(res)
        if (conn.ok) {
            const editName = document.querySelector("#item-name-edit");
            const editDesc = document.querySelector("#item-desc-edit");
            const editPrice = document.querySelector("#item-price-edit");
            const editImage = document.querySelector("#item-image-edit");
            const currentImage = document.querySelector(".current-image");

            editName.value = res.item_name;
            editDesc.value = res.item_desc;
            editPrice.value = res.item_price;
            currentImage.src = `item-images/${res.item_image}`

        }

    }
    async function updateItem() {

        const formTwo = document.querySelector(".update-form")
        const formData = new FormData(formTwo);
        formData.append('item_id', itemId)
        if (document.querySelector("#item-image-edit").files.length == 0) {
            const imgSrc = document.querySelector(".current-image").src;
            const imgSrcId = imgSrc.substring(imgSrc.lastIndexOf('/') + 1);
            formData.append('item-image', imgSrcId);

        }


        let conn = await fetch("apis/api-update-items.php", {
            method: "POST",
            body: formData,
        });
        const res = await conn.json()
        console.log(res)
        closeModal();
        location.href = "items.php";

    }


    //TODO WIll add delete item functions before final exam
</script>
<!-- Main HTML END  -->
<?php
require_once 'components/footer.php';
?>
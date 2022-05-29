


<?php
require_once(__DIR__.'/components/header.php');
?>

<div class="content-wrapper">
<div class="loader"></div>
<div class="error"> </div>
</div>
<?php
require_once(__DIR__.'/components/footer.php');

?>


<script> 
validateUser();
async function validateUser() {
  const error = document.querySelector('.error');
  const key = "<?php echo $_GET['key']; ?>";
  const formData = new FormData();


  if(!key){
    return error.textContent = 'Key is required';
  }

  if(key.length != 32){
    return error.textContent = 'Suspicious';
  }

  formData.append('key',key);

  const conn = await fetch("apis/api-validate-user.php", {
      method: "POST",
      body: formData
    })
   const response = await conn.json();
    console.log(response);

    error.textContent = response?.info;


    if(conn.ok){
error.textContent ="verified"

//setTimeout(function(){
//error.textContent ="verified";
//}, 2000)
//      setTimeout(function(){ location.href = "/send_sms.php" }, 4000);
//     
//    } else {
//      error.textContent = "failed to validate or key expired"
    }


  }


</script>







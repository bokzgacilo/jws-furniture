function getAllProduct() {
  $.ajax({
    type: 'get',
    url: 'api/getAllProduct.php',
    success: (response) => {
      $('#product-container').html(response)
    }
  })
}

function addToCart(product_id) {
  alert(product_id)
}

$(document).ready(function(){
  getAllProduct();
})
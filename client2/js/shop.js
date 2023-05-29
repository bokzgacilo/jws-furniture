const currentURL = new URL(location.href);
const inputParams = new URLSearchParams(currentURL.search);

function getAllProducts(){
  $.ajax({
    type: 'get',
    url: 'api/getAllProducts.php',
    success: (response) => {
      $('#product-list').html(response)
    }
  })
}

function getAllCategories() {
  $.ajax({
    type: 'get',
    url: 'api/getCategories.php',
    success: (response) => {
      $('.sidebar').html(response)
    }
  })
}

function addToCart(id){
  var quantity = $(`#item${id}`).val();
  
  $.ajax({
    type: 'post',
    url: 'api/addtocart.php',
    data: {
      quantity: quantity,
      id: id
    },
    success: (response) => {
      console.log(response)
    }
  })
  // if(quantity !== 0 || quantity !== ""){
  //   alert()
  // }
  // Swal.fire(
  //   'Item was added to your cart!',
  //   'Please check your cart for modifying cart order and quantity',
  //   'success'
  // )

  // $('.quickview').animate({
  //   bottom: '-100vh'
  // }, 500, () => {
  //   $('.quickview').css({
  //     'display':'none'
  //   })
  // })
}

$('.quickview-closer').on('click', function(){
  $('.quickview').animate({
    top: '100vh'
  }, 500, () => {
    $('.quickview').css({
      'display':'none'
    })
  })
})

function quickView(id){
  $('.quickview').css({
    'display':'flex'
  })

  $('.quickview').animate({
    top: 0
  }, 500)

  $.ajax({
    type: 'get',
    url: 'api/getProduct.php',
    data: {
      id: id
    },
    success: (response) => {
      $('.quickview-body').html(response)
    }
  })
}

$(document).ready(function(){
  

  getAllCategories();

  if(location.search !== ''){
    $('#searchInput').val(inputParams.getAll('q')[0]);
    // $.ajax({
    //   type: 'get',
    //   url: 'api/search.php',
    //   data: {
    //     q: inputParams.getAll('q')[0]
    //   },
    //   beforeSend: () => {
    //     $('#product-list').html('<p>Getting product</p>');
    //   },
    //   success: (response) => {
    //     $('#product-list').html(response);
    //   }
    // })
  }else {
    // getAllProducts();
  }
})  

$(document).on('click', '.sidebar > a', function(){
  var category = $(this).attr('name');

  inputParams.set('category', category)

  const path = window.location.href.split('?')[0];
  const newURL = `${path}?${inputParams}`;

  history.pushState({}, '', newURL);

  location.reload();
})
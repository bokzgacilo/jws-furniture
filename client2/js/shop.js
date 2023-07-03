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

function getAllProductsByCategory(q, category){
  $.ajax({
    type: 'get',
    url: 'api/getAllProductsByCategory.php',
    data: {
      q: q,
      category: category
    },
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
      $('.category-list').html(response)

      if(localStorage.getItem('category') != null || localStorage.getItem('category') != ''){
        $(`a[name='${localStorage.getItem('category')}']`).addClass('category-selected');
      }
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
  location.href = `product.php?id=${id}`;
}

$(document).ready(function(){
  

  getAllCategories();


})  

$(document).on('click', '.category-list > a', function(){
  $('.category-list > a').removeClass('category-selected');
  $(this).addClass('category-selected');

  var category = $(this).attr('name');

  inputParams.set('category', category)
  localStorage.setItem('category', category)

  const path = window.location.href.split('?')[0];
  const newURL = `${path}?${inputParams}`;

  history.pushState({}, '', newURL);
  getAllProductsByCategory(localStorage.getItem('q'), category);
})
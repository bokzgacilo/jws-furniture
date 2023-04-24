function getTotal() {
  $.ajax({
    type: 'get',
    url: 'api/getTotal.php',
    data: {
      uid : localStorage.getItem('uid')
    },
    success: (response) => {
      $('.total').html(response)
    }
  })
}

function getMyCart(){
  $.ajax({
    type: 'get',
    url: 'api/getMyCart.php',
    data: {
      uid: localStorage.getItem('uid')
    },
    success: (response) => {
      if(response == 'empty'){
        $('#my-cart').html("<h2>Cart is empty</h2>")
      }else {
        $('#my-cart').html(response)
        getTotal();
      }
    }
  })
}
function getMyTransactions(){
  $.ajax({
    type: 'get',
    url: 'api/getMyTransactions.php',
    data: {
      uid: localStorage.getItem('uid')
    },
    success: (response) => {
      if(response == 'empty'){
        $('#my-transactions').html("<h2>No Transaction</h2>")
      }else {
        $('#my-transactions').html(response)
        getTotal();
        // console.log(response)
      }
    }
  })
}

function getTransactionDetail(id) {
  $.ajax({
    type: 'get',
    url: 'api/viewTransaction.php',
    data: {
      transaction_id: id
    },
    success: (response) => {
      // $('#transactionModal')
      $('#transactionModal').modal('show');

      $('#transaction-body').html(response);
      // console.log(response)
    }
  })
}

function proceed_checkout() {
  var amount = $('#total_price').val();

  $.ajax({
    type: 'get',
    url: 'api/xendit.php',
    data: {
      amount: amount,
      uid: localStorage.getItem('uid')
    },
    success: (response) => {
      $('#proceed-button').replaceWith(response)
    }
  })
}

function removeItem(product_id){
  $.ajax({
    type: 'post',
    url: "api/removefromcart.php",
    data: {
      product_name : product_id,
      uid : localStorage.getItem('uid')
    },
    success: (response) => {
      console.log(response)
      location.reload();
    }
  })
}

$(document).ready(function (){
  getMyCart();
  getMyTransactions();
})
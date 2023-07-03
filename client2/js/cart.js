function removeFromCart(id){
  $.ajax({
    type: 'post',
    url: 'api/removeItemFromCart.php',
    data: {
      id: id
    },
    success: (response) => {
      console.log(response)

      if(response == 1){
        location.reload()
      }
    }
  })
}

function plusQuantity(id){
  $.ajax({
    type: 'post',
    url: 'api/incrementProduct.php',
    data: {
      id: id
    },
    success: (response) => {
      console.log(response)

      if(response == 1){
        location.reload()
      }
    }
  })
}

function minusQuantity(id){
  $.ajax({
    type: 'post',
    url: 'api/decrementProduct.php',
    data: {
      id: id
    },
    success: (response) => {
      console.log(response)

      if(response == 1){
        location.reload()
      }
    }
  })
}

// // Paying Using GCASH
// $(document).on('submit', '#GCashForm', function(event){
//   event.preventDefault();

//   var amount = $('#gcash_amount').val();
//   var description = $('#gcash_description').val();
//   // console.log(serializedData);

//   const settings = {
//     async: true,
//     crossDomain: true,
//     url: 'https://api.paymongo.com/v1/links',
//     method: 'POST',
//     headers: {
//       accept: 'application/json',
//       'content-type': 'application/json',
//       authorization: 'Basic c2tfdGVzdF9pYXloeE1wMXY3VFVBcU00ZnhZeUh0YVg6'
//     },
//     processData: false,
//     data: `{"data":{"attributes":{"amount":${amount},"description":"${description}"}}}`
//   };
  
//   $.ajax(settings).done(function (response) {
//     console.log(response);
//   });
// })
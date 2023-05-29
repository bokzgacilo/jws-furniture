$(document).ready(function(){
  $('.modal-closer').on('click', function(){
    $(this).parent().parent().parent().css({
      'display' : 'none'
    })
  })

  $('#searchForm').on('submit', function(e){
    e.preventDefault();

    var searchword = $('#searchInput').val();    

    inputParams.set('q', searchword)
    // $.ajax({
    //   type: 'get',
    //   url: 'api/search.php',
    //   data: {
    //     q: searchword
    //   },
    //   beforeSend: () => {
    //     $('#product-list').html('<p>Getting product</p>');
    //   },
    //   success: (response) => {
    //     $('#product-list').html(response);
    //   }
    // })

    const path = window.location.href.split('?')[0];
    const newURL = `${path}?${inputParams}`;

    history.pushState({}, '', newURL);
    location.reload();
  })
})
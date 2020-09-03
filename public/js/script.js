$( document ).ready(function() {

  // Currency On change function
  $( "#change_currency" ).change(function() {
    var to = $( this ).val();
    $('#loading_section').show();

    //Update currency code at cookie
    $.ajax({
        url: '/updateCurrency?to='+to,
        dataType: 'json',
        success: function(data) {}
    });

    //Get Fuxer Exchange Rates
    $.ajax({
        url: '/getCurrencyRates',
        dataType: 'json',
        success: function(data) {
          // console.log(data);

          if(  data['rates']['success'] == false ) {

            alert( data['rates']['error']['info'] );
            $('#loading_section').hide();

          } else {

            var rates = data['rates'];
            var currency_symbols = {
               'EUR': '€',
               'USD': '$',
               'ZAR': 'R'
            };

            $( ".cur_price" ).each(function( index, value ) {

              var oldPrice =  $( this ).text();
              var bundleid = $( this ).attr( "id" );
              var price_arr = oldPrice.split(" ");

              var symbol = price_arr[0];
              var oldPrice = price_arr[1];
              var from = price_arr[2];

              $( '#'+bundleid ).text('Updating please wait...');

              if(to == 'EUR') {
                updatePrice = oldPrice / rates[from];
              } else {
                updatePrice1 = oldPrice / rates[from];
                updatePrice = updatePrice1 * rates[to];
              }

              $( '#'+bundleid ).text(currency_symbols[to]+" "+updatePrice.toFixed(2)+" "+to);

            });

            $('#loading_section').hide();

          }

        }
    });

  });

});

$( document ).ready(function() {
    console.log( "ready!" );

  if(typeof( $.session.get('currency_value') ) != "undefined" && $.session.get('currency_value') !== null) {
      var to = $.session.get('currency_value');
      $('#change_currency option[value='+to+']').attr('selected','selected');
      convertCurrency( to );
    }

    $( "#change_currency" ).change(function() {
      var to = $( this ).val();
      $.session.set('currency_value', to);
      convertCurrency( to );
    });

});


function convertCurrency( to ) {

  var access_key = $('#app_currency_key').val();

  $( ".cur_price" ).each(function( index, value ) {
    var oldPrice =  $( this ).text();
    var bundleid = $( this ).attr( "id" );
    var price_arr = oldPrice.split(" ");

    var symbol = price_arr[0];
    var amount = price_arr[1];
    var from = price_arr[2];

    $.ajax({
        url: 'http://data.fixer.io/api/latest?access_key='+access_key,
        dataType: 'jsonp',
        success: function(json) {
          if( from == 'USD' ) {

            if( to == "EUR" ) {
            var updateamount = amount * 0.85;
            $( '#'+bundleid ).text("€ "+updateamount.toFixed(2)+" EUR");
            }

            if( to == "ZAR" ) {
            var updateamount = ( amount * 0.85 ) * json['rates']['ZAR'];
            $( '#'+bundleid ).text("R "+updateamount.toFixed(2)+" ZAR");
            }

          }

          if( from == 'EUR' ) {

            if( to == "USD" ) {
            var updateamount = amount / 0.85;
            $( '#'+bundleid ).text("$ "+updateamount.toFixed(2)+" USD");
            }

            if( to == "ZAR" ) {
            var updateamount = amount * json['rates']['ZAR'];
            $( '#'+bundleid ).text("R "+updateamount.toFixed(2)+" ZAR");
            }

          }

          if( from == 'ZAR' ) {

            if( to == "USD" ) {
            var updateamount = amount / 17.51;
            $( '#'+bundleid ).text("$ "+updateamount.toFixed(2)+" USD");
            }

            if( to == "EUR" ) {
            var updateamount = amount / json['rates']['ZAR'];
            $( '#'+bundleid ).text("€ "+updateamount.toFixed(2)+" EUR");
            }

          }

        }
    });

  });

}

$( document ).ready(function() {

    if(typeof( $.session.get('currency_value') ) != "undefined" && $.session.get('currency_value') !== null) {
        var to = $.session.get('currency_value');
        $('#change_currency option[value='+to+']').attr('selected','selected');
        convertCurrency( to );
      } else {
        var to = 'USD';
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
    var amount = price_arr[1];
    var from = price_arr[2];

    $.ajax({
        url: 'http://data.fixer.io/api/latest?access_key='+access_key,
        dataType: 'jsonp',
        success: function(json) {

            if(to == 'EUR') {

              var updateamount = amount / json['rates'][from];
              $( '#'+bundleid ).text("€ "+updateamount.toFixed(2)+" EUR");

            } else {

              var updateamount1 = amount / json['rates'][from];
              var updateamount = updateamount1 * json['rates'][to];
              $( '#'+bundleid ).text(currency_symbols[to]+" "+updateamount.toFixed(2)+" "+to);

            }

        }
    });

  });

}

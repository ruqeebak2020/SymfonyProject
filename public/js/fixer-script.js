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

if(access_key !== '') {

  $( ".cur_price" ).each(function( index, value ) {
    var oldPrice =  $( this ).text();
    var bundleid = $( this ).attr( "id" );
    var price_arr = oldPrice.split(" ");

    var symbol = price_arr[0];
    var amount = price_arr[1];
    var from = price_arr[2];
    $( '#'+bundleid ).text('Updating please wait...');
    $.ajax({
        url: '/convertCurrency?from='+from+'&to='+to+'&amount='+amount+'&access_key='+access_key,
        dataType: 'json',
        success: function(data, status) {

          $( '#'+bundleid ).text(currency_symbols[to]+" "+data['updateAmount'].toFixed(2)+" "+to);

        }
    });

  });

} else {
  //Display error for the API Key is not entered
    alert("Please Update Fixer.io API Key in .ENV file for the price conversion");
}

}

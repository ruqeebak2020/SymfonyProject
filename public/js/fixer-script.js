$( document ).ready(function() {

    var access_key = $('#app_currency_key').val();

    $.ajax({
        url: 'http://data.fixer.io/api/latest?access_key='+access_key,
        dataType: 'jsonp',
        success: function(json) {

          $( "#change_currency" ).empty();
          var currencies = json['rates'];
            for (var key in currencies) {
              $option = $("<option></option>")
              .attr("value", key)
              .text(key);

             $( "#change_currency" ).append($option);

            }

            if(typeof( $.session.get('currency_value') ) != "undefined" && $.session.get('currency_value') !== null) {
                var to = $.session.get('currency_value');
                $('#change_currency option[value='+to+']').attr('selected','selected');
                convertCurrency( to );
              } else {
                var to = 'USD';
                $('#change_currency option[value='+to+']').attr('selected','selected');
                convertCurrency( to );
              }

        }
    });

    $( "#change_currency" ).change(function() {
      var to = $( this ).val();
      $.session.set('currency_value', to);
      convertCurrency( to );
    });

});


function convertCurrency( to ) {

  var access_key = $('#app_currency_key').val();

  var currency_symbols = {
     'AED': 'د.إ',
     'AFN': '؋',
     'ALL': 'Lek',
     'AMD': 'NA',
     'ANG': 'ƒ',
     'AOA': 'NA',
     'ARS': '$',
     'AUD': '$',
     'AWG': 'ƒ',
     'AZN': '₼',
     'BAM': 'KM',
     'BBD': '$',
     'BDT': 'NA',
     'BGN': 'лв',
     'BHD': 'NA',
     'BIF': 'NA',
     'BMD': '$',
     'BND': '$',
     'BOB': '$b',
     'BRL': 'R$',
     'BSD': '$',
     'BTC': 'NA',
     'BTN': 'NA',
     'BWP': 'P',
     'BYN': 'NA',
     'BYR': 'p.',
     'BZD': 'BZ$',
     'CAD': '$',
     'CDF': 'NA',
     'CHF': 'CHF',
     'CLF': 'NA',
     'CLP': '$',
     'CNY': '¥',
     'COP': '$',
     'CRC': '₡',
     'CUC': 'NA',
     'CUP': '₱',
     'CVE': 'NA',
     'CZK': 'Kč',
     'DJF': 'NA',
     'DKK': 'kr',
     'DOP': 'RD$',
     'DZD': 'NA',
     'EGP': '£',
     'ERN': 'NA',
     'ETB': 'NA',
     'EUR': '€',
     'FJD': '$',
     'FKP': '£',
     'GBP': '£',
     'GEL': '₾',
     'GGP': '£',
     'GHS': 'NA',
     'GIP': '£',
     'GMD': 'NA',
     'GNF': 'NA',
     'GTQ': 'Q',
     'GYD': '$',
     'HKD': '$',
     'HNL': 'L',
     'HRK': 'kn',
     'HTG': 'NA',
     'HUF': 'Ft',
     'IDR': 'Rp',
     'ILS': '₪',
     'IMP': '£',
     'INR': '₹',
     'IQD': 'NA',
     'IRR': '﷼',
     'ISK': 'kr',
     'JEP': '£',
     'JMD': 'J$',
     'JOD': 'NA',
     'JPY': '¥',
     'KES': 'NA',
     'KGS': 'лв',
     'KHR': '៛',
     'KMF': 'NA',
     'KPW': '₩',
     'KRW': '₩',
     'KWD': 'NA',
     'KYD': 'NA',
     'KZT': 'лв',
     'LAK': '₭',
     'LBP': '£',
     'LKR': '₨',
     'LRD': '$',
     'LSL': 'NA',
     'LTL': 'Lt',
     'LVL': 'Ls',
     'LYD': 'NA',
     'MAD': 'NA',
     'MDL': 'NA',
     'MGA': 'NA',
     'MKD': 'ден',
     'MMK': 'NA',
     'MNT': '₮',
     'MOP': 'NA',
     'MRO': 'NA',
     'MUR': '₨',
     'MVR': 'NA',
     'MWK': 'NA',
     'MXN': '$',
     'MYR': 'RM',
     'MZN': 'MT',
     'NAD': '$',
     'NGN': '₦',
     'NIO': 'C$',
     'NOK': 'kr',
     'NPR': '₨',
     'NZD': '$',
     'OMR': '﷼',
     'PAB': 'B/.',
     'PEN': 'S/.',
     'PGK': 'NA',
     'PHP': '₱',
     'PKR': '₨',
     'PLN': 'zł',
     'PYG': 'Gs',
     'QAR': '﷼',
     'RON': 'lei',
     'RSD': 'Дин.',
     'RUB': '₽',
     'RWF': 'NA',
     'SAR': '﷼',
     'SBD': '$',
     'SCR': '₨',
     'SDG': 'NA',
     'SEK': 'kr',
     'SGD': '$',
     'SHP': '£',
     'SLL': 'NA',
     'SOS': 'S',
     'SRD': 'NA',
     'STD': 'NA',
     'SVC': '$',
     'SYP': '£',
     'SZL': 'NA',
     'THB': '฿',
     'TJS': 'NA',
     'TMT': 'NA',
     'TND': 'NA',
     'TOP': 'NA',
     'TRY': '₺',
     'TTD': 'TT$',
     'TWD': 'NT$',
     'TZS': 'NA',
     'UAH': '₴',
     'UGX': 'NA',
     'USD': '$',
     'UYU': '$U',
     'UZS': 'лв',
     'VEF': 'Bs',
     'VND': '₫',
     'VUV': 'NA',
     'WST': 'NA',
     'XAF': 'NA',
     'XAG': 'NA',
     'XAU': 'NA',
     'XCD': 'NA',
     'XDR': 'NA',
     'XOF': 'NA',
     'XPF': 'NA',
     'YER': '﷼',
     'ZAR': 'R',
     'ZMK': 'NA',
     'ZMW': 'NA',
     'ZWL': 'symbol'
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

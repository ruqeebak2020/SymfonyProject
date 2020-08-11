$( document ).ready(function() {
    console.log( "ready!" );

    $( "#change_currency" ).change(function() {

      var to = $( this ).val();
      var oldAmont = [];
      var updateprice = [];

        $( ".cur_price" ).each(function( index, value ) {
          oldAmont.push( $( this ).text() );
        });

          console.log(oldAmont);

        for(var i=0; i<oldAmont.length; i++) {

          var price_arr = oldAmont[i].split(" ");
          console.log( price_arr );

          var symbol = price_arr[0];
          var amount = price_arr[1];
          var from = price_arr[2];

          $.ajax({
              url: 'http://data.fixer.io/api/latest?access_key=1e4ccfcd08ab4f2ace04229990dfdcc0',
              dataType: 'jsonp',
              success: function(json) {

                  // access the conversion result in json.result
                  console.log(json);

                  if( from == 'USD' ) {
                    console.log(from);

                    if( to == "EUR" ) {
                        console.log(to);
                    var updateamount = amount * 0.85;
                    console.log(updateamount);
                  //  $( this ).text("€ "+updateamount+" EUR");
                    updateprice.push( "€ "+updateamount+" EUR" );
                  //  console.log(updateprice);
                    }

                    if( to == "ZAR" ) {
                    var updatamount = ( amount * 0.85 ) * json['rates']['ZAR'];
                  //  $( this ).text("R "+updateamount+" ZAR");
                    updateprice.push( "R "+updateamount+" ZAR" );
                    }

                  }

              }
          });

        }

        console.log("update price >>");
        console.log(updateprice);

        var j = 0;

        $( ".cur_upd_price" ).each(function( index, value ) {
        //   console.log("Update >> "+updateprice[j]);
           console.log($( this ).text());
        //   $( this ).text( updateprice[j] );
        //   j++;
        });

  //    $( ".cur_price" ).each(function( index, value ) {
  //      var price = $( this ).text();
  //      var updateamount1 = 23;

  //      var price_arr = price.split(" ");


        // set endpoint and your API key
  //      endpoint = 'convert';
        //access_key = '51af1acaa4c27f8d17868c3d5382faf8';
  //      access_key = '1e4ccfcd08ab4f2ace04229990dfdcc0';
        // define from currency, to currency, and amount
    //    from = 'EUR';
  //      to = 'GBP';
    //    amount = '10';


  //      1 EUR = 1.17 USD

//  1 USD = 1/1.17 = 0.85 EUR

      //  $.ajax({
        //           url: 'http://data.fixer.io/api/' + endpoint + '?access_key=' + access_key + '&from=' + from + '&to=' + to + '&amount=' + amount,
        //           dataType: 'jsonp',
        //           success: function(json) {
        //                  console.log(json);
        //           }
        //       });



  //    });

    });

});

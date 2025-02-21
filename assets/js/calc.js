$('#f1').click(function() {
    var first = $('#first1').val();
    var tarif;
    var result;
    var n = document.getElementById("first2").options.selectedIndex;
    var val = document.getElementById("first2").options[n].value;
    if (first == 0 || first == '') {
        result = 0;
        tarif = '0';
    }
    else if (first < 200 && first > 9 &&  val == '1') {
        result = first * 1.2;
        tarif = 'Classic';
    }
    else if (first > 199  && val == '1') {
        result = first * 0;
        tarif = '10$ - 199$';
    }
    else if (first < 10  && val == '1') {
        result = first * 0;
        tarif = '10$ - 199$';
    }
    else if (first < 2000 && first > 199 && val == '2') {
        result = first * 1.33;
        tarif = 'Premium';
    }
    else if (first > 1999 && val == '2') {
        result = first * 0;
        tarif = '200$ - 1999$';
    }
    else if (first < 200 && val == '2') {
        result = first * 0;
        tarif = '200$ - 1999$';
    }
    else if ( first < 5001 && first > 1999 && val == '4') {
        result = first * 1.4;
        tarif = 'Exclusive';
    }
    else if (first < 2000 && val == '4') {
        result = first * 0;
        tarif = '2000$ - 5000$';
    }
    else if (first > 5000 && val == '4') {
        result = first * 0;
        tarif = '2000$ - 5000$';
    }
    else if (first > 5000 ) {
        result = 0;
        tarif = '0';
    }
    result=result.toFixed(2);
    $('#tarif1').text(tarif);
    $('#result1').text(result);

});
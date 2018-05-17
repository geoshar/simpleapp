(function(){
    // prepare data
    var sym_num = document.getElementById('sym_num');
    var link1 = document.getElementById('link1');
    var link2 = document.getElementById('link2');
    var sum1 = document.getElementById('sum1');
    var sum2 = document.getElementById('sum2');
    var get_sym_alphabet = function(word, elem){
        var sum = 0;
        word.toUpperCase().split('').forEach(function(alphabet) {
            sum += alphabet.charCodeAt(0) - 64;
        });
        elem.innerHTML = sum;
    }
    var update_sym_num = function(){
        sym_num.innerHTML = link1.value.length + link2.value.length;
    };

    // set events
    link1.oninput = function(){
        update_sym_num();
        get_sym_alphabet(this.value, sum1);
    };
    link2.oninput = function(){
        update_sym_num();
        get_sym_alphabet(this.value, sum2);
    };
    // initial update
    update_sym_num();
    get_sym_alphabet(link1.value, sum1);
    get_sym_alphabet(link2.value, sum2);

})();
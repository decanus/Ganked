[].slice.apply(document.querySelectorAll('[repeat]')).forEach(function ($elem) {
    var repeat = (parseInt($elem.getAttribute('repeat')) - 1);
    
    for (var i = 0; i < repeat; i++) {
        var $copy = $elem.cloneNode(true);
        $copy.removeAttribute('repeat');
        $elem.parentNode.appendChild($copy);
    }
});

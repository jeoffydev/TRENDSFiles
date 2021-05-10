$(document).on('click','.top-color ul li',function(){
    $('.top-color ul li').removeClass('active');
    $(this).addClass('active');
    $('.metro .metro-top .clip-box').removeClassRegex(/^cbase-/)
    $('.metro .metro-top .clip-box').addClass($(this).attr('class'));
});

$(document).on('click','.grip-color ul li',function(){
    $('.grip-color ul li').removeClass('active');
    $(this).addClass('active');
    $('.cup .cup-grip .clip-box').removeClassRegex(/^cbase-/)
    $('.cup .cup-grip .clip-box').addClass($(this).attr('class'));
});

$(document).on('click','.button-color ul li',function(){
    $('.button-color ul li').removeClass('active');
    $(this).addClass('active');
    $('.metro .metro-barrel .clip-box').removeClassRegex(/^cbase-/)
    $('.metro .metro-barrel .clip-box').addClass($(this).attr('class'));
});

$(document).on('click','a.download',function(){
    var node = document.getElementById('mask-obj');

    domtoimage.toBlob(node)
    .then(function (blob) {
        window.saveAs(blob, 'metro-cup.jpg');
    },'image/jpeg');
    
});

function filter (node) {
    return (node.tagName !== 'i');
}
$.fn.removeClassRegex = function(regex) {
  return $(this).removeClass(function(index, classes) {
    return classes.split(/\s+/).filter(function(c) {
      return regex.test(c);
    }).join(' ');
  });
};
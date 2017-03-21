
document.getElementById('start-btn').onclick = function() {
    document.getElementById('intro').outerHTML = '';
    document.getElementsByTagName('a-scene')[0].style.zIndex = 'auto';
};
